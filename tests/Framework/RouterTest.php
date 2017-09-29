<?php
/**
 * Created by IntelliJ IDEA.
 * User: fab5741
 * Date: 29/09/17
 * Time: 12:10
 */

namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    /**
     * Set a working router before each functions
     */
    public function setUp()
    {
        $this->router = new Router();
    }

    /**
     * Test Simple GET Requests Routing
     */
    public function testGetMethod(? string $path = '/blog')
    {
        $request = new ServerRequest("GET", $path);
        $this->router->get($path, function () {
            return 'hello';
        }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals("blog", $route->getName());
        $this->assertEquals("hello", call_user_func_array($route->getCallBack(), [$request]));
    }

    /**
     * Test Simple POST Requests Routing
     */
    public function testPostMethod()
    {
        $request = new ServerRequest("POST", "/blog");
        $this->router->post('/blog', function () {
            return 'hello';
        }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals("blog", $route->getName());
        $this->assertEquals("hello", call_user_func_array($route->getCallBack(), [$request]));
    }

    /**
     * Test Simple DELETE Requests Routing
     */
    public function testDeleteMethod()
    {
        $request = new ServerRequest("DELETE", "/blog");
        $this->router->delete('/blog', function () {
            return 'hello';
        }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals("blog", $route->getName());
        $this->assertEquals("hello", call_user_func_array($route->getCallBack(), [$request]));
    }

    /**
     * Test when route dont match anything
     */
    public function testMatchNull()
    {
        $request = new ServerRequest("DELETE", "/blog");
        $this->assertNull($this->router->match($request));
    }

    /**
     * Add some parameters to Get
     */
    public function testGetWithParameters()
    {
        $request = new ServerRequest("GET", "/blog/mon-slug-8");
        $this->router->get('/blog/', function () {
            return 'hello';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $route = $this->router->match($request);
        $this->assertEquals("post.show", $route->getName());
        $this->assertEquals("hello", call_user_func_array($route->getCallBack(), [$request]));
        $this->assertEquals(["slug" => 'mon-slug', 'id' => '8'], $route->getParams());
        // Test invalid url
        $route = $this->router->match(new ServerRequest("GET", "/blog/mon_slug-8"));
        $this->assertEquals(null, $route);
    }

    /**
     * Test uri generation
     */
    public function testGenerateUri()
    {
        $this->router->get('/blog/', function () {
            return 'hello';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $uri = $this->router->generateUri("post.show", ['slug' => 'mon-article', 'id' => 18]);
        $this->assertEquals("/blog/mon-article-18", $uri);
    }

    /**
     * Uri generation with params
     */
    public function testGenerateUriWithParams()
    {
        $this->router->get('/blog/', function () {
            return 'hello';
        }, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
            return 'hello';
        }, 'post.show');
        $uri = $this->router->generateUri("post.show",
            ['slug' => 'mon-article', 'id' => 18],
            ['p' => 2]
        );
        $this->assertEquals("/blog/mon-article-18?p=2", $uri);
    }

    /**
     * Test crud routes auto generation
     */
    public function testCrud()
    {
        $this->router->crud("/blog", function () {
            return 'hello';
        }, 'posts');
        $request = new ServerRequest("GET", "/blog");
        $route = $this->router->match($request);
        $this->assertEquals("posts.index", $route->getName());
        $this->assertEquals("hello", call_user_func_array($route->getCallBack(), [$request]));

        $request = new ServerRequest("GET", "/blog/new");
        $route = $this->router->match($request);
        $this->assertEquals("posts.create", $route->getName());
        $this->assertEquals("hello", call_user_func_array($route->getCallBack(), [$request]));

        $request = new ServerRequest("POST", "/blog/new");
        $route = $this->router->match($request);
        $this->assertEquals("hello", call_user_func_array($route->getCallBack(), [$request]));

        $request = new ServerRequest("GET", "/blog/2");
        $route = $this->router->match($request);
        $this->assertEquals("posts.edit", $route->getName());
        $this->assertEquals("hello", call_user_func_array($route->getCallBack(), [$request]));

        $request = new ServerRequest("POST", "/blog/2");
        $route = $this->router->match($request);
        $this->assertEquals("hello", call_user_func_array($route->getCallBack(), [$request]));

        $request = new ServerRequest("DELETE", "/blog/2");
        $route = $this->router->match($request);
        $this->assertEquals("posts.delete", $route->getName());
        $this->assertEquals("hello", call_user_func_array($route->getCallBack(), [$request]));
    }

}
