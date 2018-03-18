<?php

namespace mhyndle\ISSPosition\Domain;

interface ISSLocationInterface
{
    public function getCurrentISSLocation(): LocationDto;
}
