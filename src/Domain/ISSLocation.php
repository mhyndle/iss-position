<?php

namespace mhyndle\ISSPosition\Domain;

class ISSLocation implements ISSLocationInterface
{
    /**
     * @var ISSPositionInterface
     */
    private $issPositionService;

    /**
     * @var ReverseGeocodingInterface
     */
    private $reverseGeocodingService;

    public function __construct(ISSPositionInterface $issPositionService, ReverseGeocodingInterface $reverseGeocodingService)
    {
        $this->issPositionService = $issPositionService;
        $this->reverseGeocodingService = $reverseGeocodingService;
    }

    /**
     * @return LocationDto
     */
    public function getCurrentISSLocation(): LocationDto
    {
        $issPosition = $this->issPositionService->getCurrentIssPosition();
        return $this->reverseGeocodingService->getApproximateAddress($issPosition);
    }
}
