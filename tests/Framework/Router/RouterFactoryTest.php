<?php

namespace Tests\Framework\Router;

use DI\ContainerBuilder;
use Framework\Router;
use Framework\Router\RouterFactory;
use PHPUnit\Framework\TestCase;

class RouterFactoryTest extends TestCase
{
    /**
     * Test if router construct well
     */
    public function testFactory()
    {
        $factory = new RouterFactory;
        $builder = new ContainerBuilder();
        $builder->addDefinitions(["ENV" => "dev"]);
        $container = $builder->build();
        $this->assertInstanceOf(Router::class, $factory($container));
    }

    /**
     * If we set env to production, cache is added to Router construction
     */
    public function testFactoryWithCache()
    {
        $factory = new RouterFactory;
        $builder = new ContainerBuilder();
        $builder->addDefinitions(["ENV" => "production"]);
        $container = $builder->build();
        $this->assertInstanceOf(Router::class, $factory($container));
    }
}
