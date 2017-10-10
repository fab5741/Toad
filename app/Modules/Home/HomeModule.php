<?php

namespace App\Modules\Home;

use App\Modules\Home\Actions\IndexAction;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Router;
use Framework\Twig\MenuTwigExtension;
use Psr\Container\ContainerInterface;

class HomeModule extends Module
{
    const DEFINITIONS = __DIR__ . "/config.php";

    public function __construct(
        RendererInterface $renderer,
        ContainerInterface $container,
        MenuTwigExtension $menuTwigExtension
    ) {
        $container->get(RendererInterface::class)->addPath('home', __DIR__ . '/views');
        $router = $container->get(Router::class);
        $prefix = $container->get('home.prefix');
        $router->get($prefix, IndexAction::class, 'home.index');

        if ($renderer instanceof TwigRenderer) {
            $renderer->getTwig()->addExtension($menuTwigExtension);
        }
    }
}
