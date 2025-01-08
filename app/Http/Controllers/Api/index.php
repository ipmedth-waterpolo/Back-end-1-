<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell
 */

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Dit zou de correcte locatie moeten zijn voor je Laravel-app.
$publicDirectory = __DIR__;
if ($uri !== '/' && file_exists($publicDirectory . $uri)) {
    return false;
}

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';



$kernel = $app->make(Kernel::class);
$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
