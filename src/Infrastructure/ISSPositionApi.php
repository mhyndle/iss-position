<?php
namespace mhyndle\ISSPosition\Infrastructure;

use mhyndle\ISSPosition\Domain\GeoPositionDto;
use mhyndle\ISSPosition\Domain\ISSPositionInterface;
use GuzzleHttp\ClientInterface as HttpClientInterface;

class ISSPositionApi implements ISSPositionInterface
{
    const ISS_POSITION_DATA_URL = 'https://api.wheretheiss.at/v1/satellites/25544';

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return GeoPositionDto
     */
    public function getCurrentIssPosition(): GeoPositionDto
    {
        $apiResponse = $this->callApi();

        return new GeoPositionDto($apiResponse['latitude'], $apiResponse['longitude']);
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function callApi(): array
    {
        $response = $this->httpClient->request('GET', self::ISS_POSITION_DATA_URL);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("ISS position cannot be obtained");
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
