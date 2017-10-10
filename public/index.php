<?php

/**
 * Toad - Modulary PHP Framework
 *
 * @package  Toad
 * @author   Fabrice Palermo <contact@fabrice-palermo.fr>
 */

define('TOAD_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/
require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Set chdir to root
|--------------------------------------------------------------------------
*/

chdir(dirname(__DIR__));

/*
|--------------------------------------------------------------------------
| Declare Modules and middlewares
|--------------------------------------------------------------------------
|
| Declare modules and middlewares we cant to use in our APP
|
*/

use App\Modules\Home\HomeModule;
use Framework\Middleware\CsrfMiddleware;
use Framework\Middleware\DispatcherMiddleware;
use Framework\Middleware\MethodMiddleware;
use Framework\Middleware\NotFoundMiddleware;
use Framework\Middleware\RouterMiddleware;
use Framework\Middleware\TrailingSlashMiddleware;
use Framework\Modules\Contact\ContactModule;
use Middlewares\Whoops;

$app = (new Framework\App('./config/config.php'))
    ->addModule(HomeModule::class)
    ->addModule(ContactModule::class)
    ->pipe(Whoops::class)
    ->pipe(TrailingSlashMiddleware::class)
    ->pipe(MethodMiddleware::class)
    ->pipe(CsrfMiddleware::class)
    ->pipe(RouterMiddleware::class)
    ->pipe(DispatcherMiddleware::class)
    ->pipe(NotFoundMiddleware::class);

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

if (php_sapi_name() !== "cli") {
    $response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
    Http\Response\send($response);
}
