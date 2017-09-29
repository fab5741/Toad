<?php

namespace App\Blog;

use App\Blog\Actions\PostIndexAction;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Container\ContainerInterface;

/**
 * Blog module, Register views and routes for the module
 *
 * Class BlogModule
 * @package App\Blog
 */
class BlogModule extends Module
{

    const DEFINITIONS = __DIR__ . "/config.php";

    public function __construct(ContainerInterface $container)
    {
        $container->get(RendererInterface::class)->addPath('blog', __DIR__ . '/views');
        $router = $container->get(Router::class);
        $prefix = $container->get('blog.prefix');
        $router->get($prefix, PostIndexAction::class, 'blog.index');
    }
}
