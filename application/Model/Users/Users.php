<?php
/**
 * Created by PhpStorm.
 * User: strim
 * Date: 22.04.2017
 * Time: 20:47
 */

namespace Application\Model\Users;


use Application\System\Model\DB;

class Users
{

    static protected $checkEmail;

    static public function addUser($email, $password, $name, $phone = '')
    {
        if (empty($email) or empty($password) or empty($name)) {
            return false;
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO admin_users (name, email, password)' .
            ' VALUES (:name, :email, :password)';
        $sth = DB::connect()->prepare($sql);
        $arrayParam = [
            ':name' => $name,
            ':email' => $email,
            ':password' => $password
        ];
        $sth->execute($arrayParam);
        return DB::connect()->lastInsertId();
    }

    static public function getUserByEmail($email)
    {
        if (!isset(static::$cacheUsersEmail[$email])) {
            $sql = 'SELECT * FROM admin_users WHERE email=:email';
            $sth = DB::connect()->prepare($sql);
            $arrayParam = [
                ':email' => $email
            ];
            $sth->execute($arrayParam);
            static::$cacheUsersEmail[$email] = $sth->fetch(\PDO::FETCH_ASSOC);
            static::$cacheUsers[static::$cacheUsersEmail[$email]['id']] =  static::$cacheUsersEmail[$email];
        }
        return static::$cacheUsersEmail[$email];
    }

    static private $cacheUsers = [];
    static private $cacheUsersEmail = [];

    static public function getUser($id)
    {
        if (!isset(static::$cacheUsers[$id])) {
            $sql = 'SELECT * FROM admin_users WHERE id=:id';
            $sth = DB::connect()->prepare($sql);
            $arrayParam = [
                ':id' => $id
            ];
            $sth->execute($arrayParam);
            static::$cacheUsers[$id] = $sth->fetch(\PDO::FETCH_ASSOC);
            static::$cacheUsersEmail[static::$cacheUsers[$id]['email']] = static::$cacheUsers[$id];
        }
        return static::$cacheUsers[$id];
    }

    static public function checkEmail($email)
    {
        if (static::$checkEmail === Null) {
            $sql = 'SELECT * FROM admin_users WHERE email=:email';
            $sth = DB::connect()->prepare($sql);
            $arrayParam = [
                ':email' => $email
            ];
            $sth->execute($arrayParam);
            static::$checkEmail = $sth->fetch(\PDO::FETCH_ASSOC);
        }
        return static::$checkEmail;

    }

}