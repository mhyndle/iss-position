<?php

namespace mhyndle\ISSPosition\Domain;

use PHPUnit\Framework\TestCase;

class GeoPositionDtoTest extends TestCase
{
    public function test_should_return_location()
    {
        $testedObject = new GeoPositionDto(13, 1987);

        $this->assertEquals(13, $testedObject->getLatitude());
        $this->assertEquals(1987, $testedObject->getLongitude());
    }
}
