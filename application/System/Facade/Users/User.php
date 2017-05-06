<?php
/**
 * Created by PhpStorm.
 * User: Леонид
 * Date: 02.05.2017
 * Time: 12:02
 */

namespace Application\System\Facade\Users;


use Application\Model\Users\Users;

class User
{
    public static $userIdSession = null;
    public function __construct()
    {
        if (static::$userIdSession === null) {
            static::$userIdSession = $_SESSION['user_id'];
        }
    }

    public function getUser() {
        return Users::getUser(static::$userIdSession)  ;
    }
}