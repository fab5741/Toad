<?php

use Framework\App;
use Framework\Middlewares\DispatcherMiddleware;
use Framework\Middlewares\NotFoundMiddleware;
use Framework\Middlewares\RouterMiddleware;
use GuzzleHttp\Psr7\ServerRequest;

chdir(dirname(__DIR__));

require './vendor/autoload.php';

$app = (new App('./config/config.php'))
    ->addModule(\App\Blog\BlogModule::class)
    ->pipe(RouterMiddleware::class)
    ->pipe(DispatcherMiddleware::class)
    ->pipe(NotFoundMiddleware::class);

if (php_sapi_name() !== "cli") {
    $response = $app->run(ServerRequest::fromGlobals());
    Http\Response\send($response);
}
