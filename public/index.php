<?php

use Framework\App;
use Framework\Middlewares\NotFoundMiddleware;
use GuzzleHttp\Psr7\ServerRequest;

chdir(dirname(__DIR__));

require './vendor/autoload.php';

$app = (new App('./config/config.php'))
    ->pipe(NotFoundMiddleware::class);

if (php_sapi_name() !== "cli") {
    $response = $app->run(ServerRequest::fromGlobals());
    Http\Response\send($response);
}
