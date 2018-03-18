<?php

namespace mhyndle\ISSPosition\Domain;

use PHPUnit\Framework\TestCase;

class ISSLocationTest extends TestCase
{
    /**
     * @var ISSPositionInterface
     */
    private $issPositionService;

    /**
     * @var ReverseGeocodingInterface
     */
    private $reverseGeocodingService;

    protected function setUp()
    {
        parent::setUp();

        $this->issPositionService = $this->prophesize(ISSPositionInterface::class);
        $this->reverseGeocodingService = $this->prophesize(ReverseGeocodingInterface::class);
    }

    public function test_should_return_location()
    {
        $geoPositionMock = new GeoPositionDto(13, 1987);

        $this->issPositionService->getCurrentIssPosition()->willReturn($geoPositionMock);

        $locationDtoMock = new LocationDto(13, 1987, 'Master of Puppets');
        $this->reverseGeocodingService->getApproximateAddress($geoPositionMock)->willReturn($locationDtoMock);

        $testedObject = new ISSLocation($this->issPositionService->reveal(), $this->reverseGeocodingService->reveal());
        $address = $testedObject->getCurrentISSLocation();

        $this->assertEquals(13, $address->getLatitude());
        $this->assertEquals(1987, $address->getLongitude());
        $this->assertEquals('Master of Puppets', $address->getLocationName());
    }
}