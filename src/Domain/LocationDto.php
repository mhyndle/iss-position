<?php

namespace mhyndle\ISSPosition\Domain;

class LocationDto
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var string
     */
    private $locationName;

    public function __construct(float $latitude, float $longitude, string $locationName)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->locationName = $locationName;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function getLocationName(): string
    {
        return $this->locationName;
    }
}