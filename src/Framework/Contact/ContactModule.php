<?php

namespace Modules\Contact;

use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Modules\Contact\Actions\ContactAction;
use Psr\Container\ContainerInterface;

/**
 * Class ContactModule
 */
class ContactModule extends Module
{
    const DEFINITIONS = __DIR__ . "/config.php";

    const MIGRATIONS = __DIR__ . "/db/migrations";

    const SEEDS = __DIR__ . '/db/seeds';

    public function __construct(ContainerInterface $container)
    {
        $container->get(RendererInterface::class)->addPath('contact', __DIR__ . '/views');
        $router = $container->get(Router::class);
        $prefix = $container->get('contact.prefix');
        $router->get($prefix, ContactAction::class, 'contact.index');
    }
}

