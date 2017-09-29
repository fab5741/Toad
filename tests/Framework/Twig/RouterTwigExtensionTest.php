<?php

namespace Tests\Framework\Twig;

use Framework\Router;
use Framework\Twig\RouterTwigExtension;
use PHPUnit\Framework\TestCase;
use Twig_SimpleFunction;

class RouterTwigExtensionTest extends TestCase
{
    public function setUp()
    {
        $_SERVER['REQUEST_URI'] = "posts";
    }

    public function testGetFunctions()
    {
        $twig = (new RouterTwigExtension(New Router()));
        $this->assertInstanceof(Twig_SimpleFunction::class, $twig->getFunctions()[0]);
        $this->assertInstanceof(Twig_SimpleFunction::class, $twig->getFunctions()[1]);
    }

    public function testPathFor()
    {
        $router = new Router();
        $twig = (new RouterTwigExtension($router));
        $router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $path = "post.show";
        $params = [
            "slug" => "test",
            "id" => 1,
        ];
        $this->assertEquals($router->generateUri($path, $params), $twig->pathFor($path, $params));
    }

//    TODO : Find a way to mock uri from external Path
//    public function testIsSubPath()
//    {
//        $router = new Router();
//        $twig = (new RouterTwigExtension($router));
//        $router->get('/blog/', function () {
//            return 'hello';
//        }, 'posts');
//
//        $router->get('/blog/posts', function () {
//            return 'hello';
//        }, 'posts.show');
//
//        $router->get('/tests', function () {
//            return 'hello';
//        }, 'tests');
//
//        $this->visit('/home')
//            ->see('Welcome')
//            ->seePageIs('/home');
//
//        $this->assertTrue($twig->is_subPath("posts.show"));
//        $this->assertFalse($twig->is_subPath("tests"));
//    }
}
