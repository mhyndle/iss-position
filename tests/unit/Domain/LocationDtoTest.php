<?php

namespace mhyndle\ISSPosition\Domain;

use PHPUnit\Framework\TestCase;

class LocationDtoTest extends TestCase
{
    public function test_should_return_location()
    {
        $testedObject = new LocationDto(13, 1987, 'S&M');

        $this->assertEquals(13, $testedObject->getLatitude());
        $this->assertEquals(1987, $testedObject->getLongitude());
        $this->assertEquals('S&M', $testedObject->getLocationName());
    }
}
