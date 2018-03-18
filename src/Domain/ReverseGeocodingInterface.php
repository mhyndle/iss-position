<?php

namespace mhyndle\ISSPosition\Domain;

interface ReverseGeocodingInterface
{
    public function getApproximateAddress(GeoPositionDto $geoposition): LocationDto;
}