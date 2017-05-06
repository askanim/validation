<?php
/**
 * Created by PhpStorm.
 * User: strim
 * Date: 22.04.2017
 * Time: 20:10
 */

namespace Application\Controller\Admin;

use Application\Model\Users\Users;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Psr\Container\ContainerInterface;
class Main
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        // get container->view
        $this->view = $this->container->get('view');
    }
    public function mainAdmin(Request $request, Response $response) {

        // Получим данные о текущем пользователе

        $user = Users::getUser($_SESSION['user_id']);
       
        $this->view->render($response, 'site/admin/admin.php',[
                'user' => $user
            ]
        );
        return $response;
    }
}