<?php

namespace mhyndle\ISSPosition\Infrastructure;

use mhyndle\ISSPosition\Domain\GeoPositionDto;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use mhyndle\ISSPosition\Domain\LocationDto;
use mhyndle\ISSPosition\Domain\ReverseGeocodingInterface;

class GoogleMapsApi implements ReverseGeocodingInterface
{
    const GOOGLE_MAPS_API_URL = 'https://maps.googleapis.com/maps/api/geocode/json';
    const API_KEY = 'AIzaSyCy__iHTWt0k8zv6G-LuGv8QUS87jOhm6k';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getApproximateAddress(GeoPositionDto $geoPosition): LocationDto
    {
        $apiResponse = $this->callApi($geoPosition);
        $locationName = 'Reverse geocoding for given position failed';

        if ($apiResponse['status'] == 'OK' && !empty($apiResponse['results'])) {
            $locationName = $apiResponse['results'][0]['formatted_address'];
        }

        return new LocationDto($geoPosition->getLatitude(), $geoPosition->getLongitude(), $locationName);
    }

    private function callApi(GeoPositionDto $geoPosition): array
    {
        $queryParams = [
            'latlng=' . $geoPosition->getLatitude() . ',' . $geoPosition->getLongitude(),
            'location_type=APPROXIMATE',
            'key=' . self::API_KEY,

        ];
        $uri = self::GOOGLE_MAPS_API_URL . '?' . implode('&', $queryParams);
        $params = [
            'verify' => false
        ];
        $response = $this->httpClient->request('GET', $uri, $params);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("ISS position cannot be obtained");
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
