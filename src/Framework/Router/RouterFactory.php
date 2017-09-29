<?php

namespace Framework\router;

use Framework\Router;
use Psr\Container\ContainerInterface;

class RouterFactory
{

    public function __invoke(ContainerInterface $container): Router
    {
        $cache = null;
        if ($container->get('ENV') === 'production') {
            $cache = 'tmp/routes';
        }
        return new Router($cache);
    }
}
