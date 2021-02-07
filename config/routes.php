<?php

use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\NotFoundException;

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

$router = (new League\Route\Router)->setStrategy($strategy);

try {
    $router->map('GET', '/', 'app\Application\Dashboard\Controller\DashboardController::index');
    $router->map('GET', '/logbooks', 'app\Application\Logbook\Controller\LogbookController::get');
    $router->map('GET', '/logbooks/create', 'app\Application\Logbook\Controller\LogbookFormController::create');
    $router->map('POST', '/logbooks/create', 'app\Application\Logbook\Controller\LogbookFormController::create');
    $router->map('GET', '/login', 'app\Application\Auth\Controller\AuthenticationController::login');
    $router->map('POST', '/login', 'app\Application\Auth\Controller\AuthenticationController::login');

    $response = $router->dispatch($request);
    (new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
} catch (Exception $exception) {
    die('THere seems to be some routing issues NEIL');
}
