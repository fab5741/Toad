<?php

namespace Framework\Modules\Contact;

use Framework\Module;
use Framework\Modules\Contact\Actions\IndexAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Container\ContainerInterface;

class ContactModule extends Module
{

    const DEFINITIONS = __DIR__ . "/config.php";

    public function __construct(ContainerInterface $container)
    {
        $container->get(RendererInterface::class)->addPath('contact', __DIR__ . '/views');
        $router = $container->get(Router::class);
        $prefix = $container->get('contact.prefix');
        $router->get($prefix, IndexAction::class, 'contact.index');
        $router->post($prefix, IndexAction::class);
    }
}
