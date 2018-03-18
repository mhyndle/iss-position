<?php

namespace mhyndle\ISSPosition\Infrastructure;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use GuzzleHttp\ClientInterface as HttpClientInterface;
use mhyndle\ISSPosition\Domain\GeoPositionDto;

class GoogleMapsApiTest extends TestCase
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    protected function setUp()
    {
        parent::setUp();

        $this->httpClient = $this->prophesize(HttpClientInterface::class);
    }

    /**
     * @dataProvider googleMapsApiProperResponses
     */
    public function test_should_return_approximate_location(GeoPositionDto $geoPosition, $apiResponseStatusCode, $apiResponseContent, $expectedLocationName)
    {
        $responseBodyMock = $this->prophesize('Psr\Http\Message\StreamInterface');
        $responseBodyMock->getContents()->willReturn($apiResponseContent);

        $responseMock = $this->prophesize('Psr\Http\Message\ResponseInterface');
        $responseMock->getStatusCode()->willReturn($apiResponseStatusCode);
        $responseMock->getBody()->willReturn($responseBodyMock->reveal());

        $this->httpClient
            ->request('GET', Argument::type('string'), Argument::any())
            ->willReturn($responseMock->reveal());

        $testObject = new GoogleMapsApi($this->httpClient->reveal());

        $location = $testObject->getApproximateAddress($geoPosition);

        $this->assertEquals($geoPosition->getLatitude(), $location->getLatitude());
        $this->assertEquals($geoPosition->getLongitude(), $location->getLongitude());
        $this->assertEquals($expectedLocationName, $location->getLocationName());
    }

    public function googleMapsApiProperResponses()
    {
        return [
            'many_approximate_results' => [
                new GeoPositionDto(1, 2),
                200,
                json_encode([
                    'status' => 'OK',
                    'results' => [
                        ['formatted_address' => 'Nothing Else Matters'],
                        ['formatted_address' => 'Fade in Black'],
                    ]
                ]),
                'Nothing Else Matters'
            ],
            'single_approximate_result' => [
                new GeoPositionDto(1, 2),
                200,
                json_encode([
                    'status' => 'OK',
                    'results' => [
                        ['formatted_address' => 'Fade in Black'],
                    ]
                ]),
                'Fade in Black'
            ],
            'no_approximate_result' => [
                new GeoPositionDto(1, 2),
                200,
                json_encode([
                    'status' => 'ZERO_RESULTS',
                    'results' => []
                ]),
                'Reverse geocoding for given position failed'
            ],
        ];
    }

    /**
     * @dataProvider googleMapsApiErrorResponses
     * @expectedException Exception
     */
    public function test_should_throw_exception($geoPosition, $apiResponseStatusCode)
    {
        $responseMock = $this->prophesize('Psr\Http\Message\ResponseInterface');
        $responseMock->getStatusCode()->willReturn($apiResponseStatusCode);

        $this->httpClient
            ->request('GET', Argument::type('string'), Argument::any())
            ->willReturn($responseMock->reveal());

        $testObject = new GoogleMapsApi($this->httpClient->reveal());

        $testObject->getApproximateAddress($geoPosition);
    }

    public function googleMapsApiErrorResponses()
    {
        return [
            'many_approximate_results' => [
                new GeoPositionDto(1, 2),
                500,
            ],
        ];
    }
}
