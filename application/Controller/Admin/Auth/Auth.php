<?php
/**
 * Created by PhpStorm.
 * User: Леонид
 * Date: 15.04.2017
 * Time: 16:50
 */

namespace Application\Controller\Admin\Auth;

use Application\Model\Users\User;
use Application\Model\Users\Users;

use Application\System\Facade\Validate\Validate;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Psr\Container\ContainerInterface;

class Auth
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        //  CSRF
        $this->csrf = $this->container->get('csrf');
        $this->nameKey = $this->csrf->getTokenNameKey();
        $this->valueKey = $this->csrf->getTokenValueKey();
        // END CSRF
    }

    public function authLogin(Request $request, Response $response)
    {
        $result = [];
        $tokenName = $request->getAttribute($this->nameKey);
        $tokenValue = $request->getAttribute($this->valueKey);
        $csrf = $this->arrayCsrf($tokenName, $tokenValue);
        // Get Post Request;
        $post_data = $request->getParsedBody();

        // Users verify
        // create @var $error
        $error = false;
        $user = Users::getUserByEmail($post_data['login_email']);
        if ($user === Null) {
            $error = true;
        } else {
            if (password_verify($post_data['password_login'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                User::setCurrentUser(new User($user['id']));
                $result['success'] = true;
            } else {
                $error = true;
            }
        }
        // check @var $error
       if($error === true) {
           $result['error'] = ['login' => false];
           $result['csrf'] = $csrf;
       }
        // end check
        // return Response
        $newResponse = $response->withJson($result);
        return $newResponse;
    }

    public function authRegister(Request $request, Response $response)
    {
        // Get Post Request;
        $post_data = $request->getParsedBody();
        $array_form = [
            'string' => [
                'name' => $post_data['name']
            ],
            'email' => [
                'email' => $post_data['email']
            ],
            'password' => [
                0 => ['password' => $post_data['password']],
                1 => ['password_confirm' => $post_data['password_confirm']
                ]
            ]
        ];

        $result = [];
        //  CSRF
        $tokenName = $request->getAttribute($this->nameKey);
        $tokenValue = $request->getAttribute($this->valueKey);
        $csrf = $this->arrayCsrf($tokenName, $tokenValue);
        // END CSRF
        $result['csrf'] = $csrf;
        // GET VALIDATE PARAM
        $validate = new Validate();
        $val_error = $validate->validateUser($array_form);


        if ($val_error === false) {
            $result['error'] = $validate->getError();
        } elseif ($val_error === true) {
            if (Users::checkEmail($post_data['email']) === 1) {
                $result['error'] = ['email' => false];
            } else {
                Users::addUser($post_data['email'], $post_data['password'], $post_data['name']);
                $result['success'] = true;
            }
        }
        $newResponse = $response->withJson($result);
        return $newResponse;
    }

    public function arrayCsrf($name, $value)
    {
        return [
            'keys' => [
                'name' => $this->nameKey,
                'value' => $this->valueKey
            ],
            'name' => $name,
            'value' => $value

        ];
    }
}