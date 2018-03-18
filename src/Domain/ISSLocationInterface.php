<?php

namespace mhyndle\ISSPosition\Domain;

interface ISSLocationInterface
{
    /**
     * @return LocationDto
     */
    public function getCurrentISSLocation(): LocationDto;
}
