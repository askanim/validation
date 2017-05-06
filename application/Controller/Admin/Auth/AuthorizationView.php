<?php
/**
 * Created by PhpStorm.
 * User: Леонид
 * Date: 15.04.2017
 * Time: 16:47
 */

namespace Application\Controller\Admin\Auth;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Psr\Container\ContainerInterface;

class AuthorizationView
{
    /*
     *  Controller Authorization
     *  login and register
     *
     * */

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        //  CSRF
        $this->csrf = $this->container->get('csrf');
        $this->nameKey = $this->csrf->getTokenNameKey();
        $this->valueKey = $this->csrf->getTokenValueKey();
        // END CSRF

        // get container->view
        $this->view = $this->container->get('view');
    }

    public function login(Request $request, Response $response) {
    //  CSRF
        $tokenName = $request->getAttribute($this->nameKey);
        $tokenValue = $request->getAttribute($this->valueKey);

        $csrf = $this->arrayCsrf($tokenName, $tokenValue);
    // END CSRF

        $this->view->render($response, 'site/auth/login.php',[
                'csrf'   => $csrf
            ]
        );
        return $response;
    }
    public function register(Request $request, Response $response) {
    //  CSRF
        $tokenName = $request->getAttribute($this->nameKey);
        $tokenValue = $request->getAttribute($this->valueKey);

        $csrf = $this->arrayCsrf($tokenName, $tokenValue);
    // END CSRF

        $this->view->render($response, 'site/auth/register.php',[
                'csrf'   => $csrf
            ]
        );
        return $response;
    }

    /*
     * get csrf array
     *
     * @param $name var token name
     *
     * @param $value var token value
     *
     * */
    public function arrayCsrf($name, $value) {
        return [
                'keys' => [
                    'name'  => $this->nameKey,
                    'value' => $this->valueKey
                ],
                'name'  => $name,
                'value' => $value

        ];
    }
}