<?php
/**
 * Created by PhpStorm.
 * User: Леонид
 * Date: 15.04.2017
 * Time: 17:59
 */

namespace Application\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Psr\Container\ContainerInterface;

class Error
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $this->container->get('view');
    }
    public function error404(Request $request, Response $response) {

        $this->view->render($response, 'site/404.html',[

            ]
        );

        return $request;
    }
}