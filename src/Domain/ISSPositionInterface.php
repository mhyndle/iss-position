<?php

namespace mhyndle\ISSPosition\Domain;

interface ISSPositionInterface
{
    public function getCurrentIssPosition(): GeoPositionDto;
}
