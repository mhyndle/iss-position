<?php

namespace mhyndle\ISSPosition\Application\Controller;

use mhyndle\ISSPosition\Domain\LocationDto;
use PHPUnit\Framework\TestCase;

use Twig_Environment;
use mhyndle\ISSPosition\Domain\ISSLocationInterface;

class IndexControllerTest extends TestCase
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var ISSLocationInterface
     */
    private $issLocation;

    protected function setUp()
    {
        parent::setUp();

        $this->twig = $this->prophesize(Twig_Environment::class);
        $this->issLocation = $this->prophesize(ISSLocationInterface::class);
    }

    public function test_should_render_view()
    {
        $renderedContent = 'ISS';
        $issLocationDtoMock = new LocationDto(41, 512, 'Sim sala bim');
        $this->issLocation->getCurrentISSLocation()->willReturn($issLocationDtoMock);

        $this->twig
            ->render('index.twig', ['issLocation' => $issLocationDtoMock])
            ->willReturn($renderedContent);

        $controller = new IndexController($this->twig->reveal(), $this->issLocation->reveal());

        $controller();

        $this->expectOutputString($renderedContent);
    }
}
