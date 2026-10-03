<?php

declare(strict_types=1);

use App\ExceptionHandler;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Exceptions\MethodNotAllowedException;
use App\Http\Exceptions\NotFoundException;
use App\View\PhpRenderer;
use App\View\SmartyRenderer;
use App\View\TwigRenderer;
use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

// read and load .env file
Dotenv::createUnsafeImmutable(BASE_PATH)->load();

$config = require BASE_PATH . '/config/app.php';

// register error/exception handler
$view = match ($config['renderer']) {
    'php' => new PhpRenderer(),
    'twig' => new TwigRenderer(),
    default => new SmartyRenderer(),
};

$exceptionHandler = new ExceptionHandler($view, $config['env'] !== 'production');
$exceptionHandler->register();

// define route dispatcher
$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $routeCollector) {
    $routeCollector->addRoute('GET', '/', [CategoryController::class, 'index']);
    $routeCollector->addRoute('GET', '/categories', [CategoryController::class, 'index']);
    $routeCollector->addRoute('GET', '/categories/{id:\d+}', [CategoryController::class, 'show']);
    $routeCollector->addRoute('GET', '/posts/{id:\d+}', [PostController::class, 'show']);
});

// get request method and URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

if ($uri !== '/' && str_ends_with($uri, '/')) {
    $uri = rtrim($uri, '/');
}

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

// handle route
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        throw new NotFoundException();
    case Dispatcher::METHOD_NOT_ALLOWED:
        throw new MethodNotAllowedException();
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controllerClass, $action] = $handler;

        $controller = new $controllerClass($view);

        // cast integerish values to integer
        $params = array_map(
            fn($v) => ctype_digit((string) $v) ? (int) $v : $v,
            array_values($vars)
        );

        call_user_func_array([$controller, $action], $params);

        break;
}
