<?php
/**
 * Created by PhpStorm.
 * User: strim
 * Date: 22.04.2017
 * Time: 17:56
 */

namespace Application\System\Model;


class DB
{
    private static $db;

    /**
     * @return \PDO
     */
    static public function connect()
    {
        if (static::$db === Null) {
            $dsn = "mysql:host=localhost;port=3306;dbname=localName";
            static::$db = new \PDO($dsn, 'localName', 'password');
        }
        return static::$db;
    }

}