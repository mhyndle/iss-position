<?php

namespace mhyndle\ISSPosition\Domain;

interface ISSPositionInterface
{
    /**
     * @return GeoPositionDto
     */
    public function getCurrentIssPosition(): GeoPositionDto;
}
