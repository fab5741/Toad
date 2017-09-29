<?php

namespace Tests\Framework;

use Framework\App;
use Framework\Middlewares\NotFoundMiddleware;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class AppTest extends TestCase
{
    private $app;

    public function setUp()
    {
        $this->app = (new App('./config/config.php'))
            ->pipe(NotFoundMiddleware::class);
    }

    public function testAppWithDefinition()
    {
        $app = (new App('./config/config.php'))
            ->pipe(NotFoundMiddleware::class);
        $this->assertInstanceOf(ResponseInterface::class, $app->run(ServerRequest::fromGlobals()));
    }

    public function testAppWithoutDefinition()
    {
        $app = (new App('./config/config.php'))
            ->pipe(NotFoundMiddleware::class);
        $this->assertInstanceOf(ResponseInterface::class, $app->run(ServerRequest::fromGlobals()));
    }

    public function testRun()
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->app->run(ServerRequest::fromGlobals()));
    }

    public function testAddModule()
    {
        $this->assertInstanceOf(App::class, $this->app->addModule("testModule"));
        $this->assertEquals($this->app->getModules()[0], "testModule");
    }

//    TODO : Make this works
//    public function testProcessNoMiddleWareException()
//    {
//        $this->expectException(NoMiddleWareException::class, (new App('./config/config.php'))->run(ServerRequest::fromGlobals()));
//        $this->expectedExceptionMessage("Aucun midlleware n' intercepté cette requête");
//    }
}
