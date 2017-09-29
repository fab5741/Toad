<?php

namespace Tests\Framework\Renderer;

use DI\ContainerBuilder;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router;
use Framework\Twig\RouterTwigExtension;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Twig_Environment;

class TwigRendererTest extends TestCase
{
    /**
     * @var Renderer
     */
    private $renderer;

    public function setUp()
    {
        $factory = new TwigRendererFactory;
        $builder = new ContainerBuilder();
        $builder->addDefinitions(["ENV" => "dev"]);
        $builder->addDefinitions(["views.path" => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views']);
        $builder->addDefinitions(["twig.extensions" => ["test" => new RouterTwigExtension(new Router())]]);
        $container = $builder->build();
        $this->renderer = $factory($container);
    }

    public function testRenderTheRightPath()
    {
        $this->renderer->addPath(__Dir__ . '/views');
        $content = $this->renderer->render('demo');
        $this->assertEquals($content, "Salut les gens");
    }

    public function testRenderTheDefaultPath()
    {
        $this->renderer->addPath(__Dir__ . '/views');
        $content = $this->renderer->render('demo');
        $this->assertEquals($content, "Salut les gens");
    }

    public function testRenderWithParams()
    {
        $content = $this->renderer->render('demoParams', ['nom' => "Marc"]);
        $this->assertEquals($content, "salut Marc");
    }

    public function testGlobalParameters()
    {
        $this->renderer->addGlobal('nom', 'Marc');
        $content = $this->renderer->render('demoParams');
        $this->assertEquals($content, "salut Marc");
    }

    public function testGetTwig()
    {
        $this->assertInstanceOf(Twig_Environment::class, $this->renderer->getTwig());
    }
}
