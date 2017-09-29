<?php

namespace App\Blog;

use App\Blog\Actions\CategoryCrudActions;
use App\Blog\Actions\CategoryShowAction;
use App\Blog\Actions\PostCrudActions;
use App\Blog\Actions\PostIndexAction;
use App\Blog\Actions\PostShowAction;
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
        $router->get($prefix . "{slug:[a-z\-0-9]+}-{id:[0-9]+}", Postshowaction::class, 'blog.show');
        $router->get($prefix . "/category/{slug:[a-z\-0-9]+}", CategoryShowAction::class, 'blog.category');

        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');
            $router->crud("$prefix/posts", PostCrudActions::class, "blog.admin");
            $router->crud("$prefix/categories", CategoryCrudActions::class, "blog.category.admin");
        }
    }
}
