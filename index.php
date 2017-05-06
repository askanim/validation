<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require 'vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

$container = $app->getContainer();
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer(__DIR__ . '/template');
};
$container['csrf'] = function ($container) {
    return new \Slim\Csrf\Guard;
};
// settings error 404

$container['notFoundHandler'] = function ($container) {
    return function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response) use ($container) {
        return $container['view']->render($response->withStatus(404), 'site/404.html', [

        ]);
    };
};
// require file routers
require_once __DIR__ . '/application/Router.php';

// start


session_start();
$app->run();






