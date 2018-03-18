<?php

namespace mhyndle\ISSPosition\Infrastructure;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use GuzzleHttp\ClientInterface as HttpClientInterface;

class ISSPositionApiTest extends TestCase
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
     * @dataProvider issPositionServiceProperResponse
     */
    public function test_should_return_iss_position($apiResponseStatusCode, $apiResponseContent, $expectedLatitude, $expectedLongitude)
    {
        $responseBodyMock = $this->prophesize('Psr\Http\Message\StreamInterface');
        $responseBodyMock->getContents()->willReturn($apiResponseContent);

        $responseMock = $this->prophesize('Psr\Http\Message\ResponseInterface');
        $responseMock->getStatusCode()->willReturn($apiResponseStatusCode);
        $responseMock->getBody()->willReturn($responseBodyMock->reveal());

        $this->httpClient
            ->request('GET', ISSPositionApi::ISS_POSITION_DATA_URL, Argument::any())
            ->willReturn($responseMock->reveal());

        $testObject = new ISSPositionApi($this->httpClient->reveal());

        $geoPosition = $testObject->getCurrentIssPosition();

        $this->assertEquals($expectedLatitude, $geoPosition->getLatitude());
        $this->assertEquals($expectedLongitude, $geoPosition->getLongitude());
    }

    public function issPositionServiceProperResponse()
    {
        return [
            [
                200,
                json_encode([
                    'latitude' => 13,
                    'longitude' => 1987,
                ]),
                13,
                1987
            ],
        ];
    }

    /**
     * @dataProvider issPositionServiceErrorResponse
     * @expectedException Exception
     */
    public function test_should_throw_exception($apiResponseStatusCode)
    {
        $responseMock = $this->prophesize('Psr\Http\Message\ResponseInterface');
        $responseMock->getStatusCode()->willReturn($apiResponseStatusCode);

        $this->httpClient
            ->request('GET', ISSPositionApi::ISS_POSITION_DATA_URL, Argument::any())
            ->willReturn($responseMock->reveal());

        $testObject = new ISSPositionApi($this->httpClient->reveal());

        $testObject->getCurrentIssPosition();
    }

    public function issPositionServiceErrorResponse()
    {
        return [
            [500]
        ];
    }
}
