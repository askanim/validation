<?php
/**
 * Created by PhpStorm.
 * User: Леонид
 * Date: 14.04.2017
 * Time: 14:06
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Application\Controller as Controller;




    $app->get('/admin', Controller\Admin\Auth\AuthorizationView::class . ':login')->add($container->get('csrf'));
    $app->get('/register', Controller\Admin\Auth\AuthorizationView::class . ':register')->add($container->get('csrf'));
    $app->post('/login', Controller\Admin\Auth\Auth::class . ':authLogin')->add($container->get('csrf'));
    $app->post('/register', Controller\Admin\Auth\Auth::class . ':authRegister')->add($container->get('csrf'));


    $app->get('/404', Controller\Error::class . ':error404');


    $app->group('/admin', function () use ($app) {
        $app->get('/', Controller\Admin\Main::class . ':mainAdmin');
    })->add(function (Request $request, Response $response, $admin) {
        if(!isset($_SESSION['user_id'])) {

            return $response->withStatus(302)->withHeader('Location', '/admin');
        }
        $response = $admin($request, $response);
        return $response;
    });
