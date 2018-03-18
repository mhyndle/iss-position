<?php

use DI\ContainerBuilder;
use mhyndle\ISSPosition\Domain\ISSLocation;
use mhyndle\ISSPosition\Domain\ISSLocationInterface;
use mhyndle\ISSPosition\Domain\ISSPositionInterface;
use mhyndle\ISSPosition\Domain\ReverseGeocodingInterface;
use mhyndle\ISSPosition\Infrastructure\ISSPositionApi;
use mhyndle\ISSPosition\Infrastructure\GoogleMapsApi;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    // Set up HTTP Client
    GuzzleHttp\ClientInterface::class => function () {
        $client = new GuzzleHttp\Client(['verify'=> false]);
        return new $client;
    },

    // Bind classes to domain interfaces
    ISSPositionInterface::class => DI\autowire(ISSPositionApi::class),
    ReverseGeocodingInterface::class => DI\autowire(GoogleMapsApi::class),
    ISSLocationInterface::class => DI\create(ISSLocation::class)
        ->constructor(
            DI\get(ISSPositionInterface::class),
            DI\get(ReverseGeocodingInterface::class)
        ),

    // Configure Twig
    Twig_Environment::class => function () {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/Application/Views');
        return new Twig_Environment($loader);
    },
]);
$container = $containerBuilder->build();

return $container;