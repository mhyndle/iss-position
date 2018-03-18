<?php

namespace mhyndle\ISSPosition\Application\Controller;

use mhyndle\ISSPosition\Domain\ISSLocationInterface;
use Twig_Environment;

class IndexController
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var ISSLocationInterface
     */
    private $issLocation;

    public function __construct(Twig_Environment $twig, ISSLocationInterface $issLocation)
    {
        $this->twig = $twig;
        $this->issLocation = $issLocation;
    }

    public function __invoke()
    {
        echo $this->twig->render(
            'index.twig',
            [
            'issLocation' => $this->issLocation->getCurrentISSLocation(),
            ]
        );
    }
}