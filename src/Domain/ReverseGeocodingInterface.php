<?php

namespace mhyndle\ISSPosition\Domain;

interface ReverseGeocodingInterface
{
    /**
     * @param GeoPositionDto $geoposition
     * @return LocationDto
     */
    public function getApproximateAddress(GeoPositionDto $geoposition): LocationDto;
}