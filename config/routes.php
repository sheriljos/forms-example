<?php
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\NotFoundException;
use Zend\Diactoros\ServerRequestFactory;


// Allow from any origin
// This is to avoid any CORS issues in local development, still need to see what happens when i deploy
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
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
    /**
     * Genral
     */
    $router->map('GET', '/', 'app\Application\Dashboard\Controller\DashboardController::index');
    $router->map('GET', '/logbooks', 'app\Application\Logbook\Controller\LogbookController::get');


    $response = $router->dispatch($request);
    (new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
} catch (Exception $exception) {
    die('THere seems to be some routing issues NEIL');
}
