<?php

namespace Tests\Framework\Renderer;

use DI\ContainerBuilder;
use Framework\Renderer\TwigRenderer;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router;
use Framework\Twig\RouterTwigExtension;
use PHPUnit\Framework\TestCase;

class TwigRendererFactoryTest extends TestCase
{
    /**
     * Test if TwigRendererFactory construct well
     */
    public function testFactory()
    {
        $factory = new TwigRendererFactory;
        $builder = new ContainerBuilder();
        $builder->addDefinitions(["ENV" => "dev"]);
        $builder->addDefinitions(["views.path" => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views']);
        $builder->addDefinitions(["twig.extensions" => ["test" => new RouterTwigExtension(new Router())]]);
        $container = $builder->build();
        $this->assertInstanceOf(Twigrenderer::class, $factory($container));
    }

}
