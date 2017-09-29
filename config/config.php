<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router;
use Framework\Router\RouterFactory;

return [
    'ENV' => DI\env('ENV', 'production'),
    'database.host' => 'localhost',
    'database.user' => 'root',
    'database.pass' => '',
    'database.name' => 'test',
    'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '/views',
    'twig.extensions' => [
    ],
    Router::class => Di\factory(RouterFactory::class),
    RendererInterface::class => Di\factory(TwigRendererFactory::class),
    PDO::class => function (\Psr\Container\ContainerInterface $c) {
        return new Pdo(
            "mysql:host=" . $c->get('database.host') . ';dbname=' . $c->get('database.name'),
            $c->get('database.user'),
            $c->get('database.pass'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
];
