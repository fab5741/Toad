<?php

use Framework\Mail\MailInterface;
use Framework\Mail\TestMail;
use Framework\Middleware\CsrfMiddleware;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router;
use Framework\Router\RouterFactory;
use Framework\Session\PHPSession;
use Framework\Session\SessionInterface;
use Framework\Twig\CsrfExtension;
use Framework\Twig\FlashExtension;
use Framework\Twig\FormExtension;
use Framework\Twig\PagerFantaExtension;
use Framework\Twig\RouterTwigExtension;
use Framework\Twig\TextExtension;
use Framework\Twig\TimeExtension;

return [
    'ENV' => DI\env('ENV', 'production'),
    'database.host' => 'localhost',
    'database.user' => 'root',
    'database.pass' => '',
    'database.name' => 'test',
    'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '/views',
    'twig.extensions' => [
        Di\get(RouterTwigExtension::class),
        Di\get(PagerFantaExtension::class),
        Di\get(TextExtension::class),
        Di\get(TimeExtension::class),
        Di\get(FlashExtension::class),
        Di\get(FormExtension::class),
        Di\get(CsrfExtension::class),
    ],
    SessionInterface::class => DI\Object(PHPSession::class),
    MailInterface::class => DI\Object(TestMail::class),
    CsrfMiddleware::class => DI\Object()->constructor(Di\get(SessionInterface::class)),
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
