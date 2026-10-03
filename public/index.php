<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\View\PhpRenderer;
use App\View\SmartyRenderer;
use App\View\TwigRenderer;
use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

Dotenv::createUnsafeImmutable(BASE_PATH)->load();

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $routeCollector) {
    $routeCollector->addRoute('GET', '/', [CategoryController::class, 'index']);
    $routeCollector->addRoute('GET', '/categories', [CategoryController::class, 'index']);
    $routeCollector->addRoute('GET', '/categories/{id:\d+}', [CategoryController::class, 'show']);
    $routeCollector->addRoute('GET', '/posts/{id:\d+}', [PostController::class, 'show']);
});

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

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        // todo
        http_response_code(404);
        echo '404 Page Not Found';
        break;
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controllerClass, $action] = $handler;

        $config = require BASE_PATH . '/config/app.php';

        $renderer = match ($config['renderer']) {
            'php' => new PhpRenderer(),
            'twig' => new TwigRenderer(),
            default => new SmartyRenderer(),
        };

        $controller = new $controllerClass($renderer);

        // cast integerish values to ineger
        $params = array_map(
            fn($v) => ctype_digit((string) $v) ? (int) $v : $v,
            array_values($vars)
        );

        call_user_func_array([$controller, $action], $params);

        break;
}
