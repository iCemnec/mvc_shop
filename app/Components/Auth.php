<?php

namespace App\Components;

use Core\View;

class Auth extends Session
{
    private $login = "user";
    private $pass = "pass";
    public $session;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool|mixed
     */
    public static function isAuth()
    {
        if (isset($_SESSION['is_auth'])) {
            return $_SESSION['is_auth'];
        } else {
            return false;
        }
    }

    /**
     * @param string $login
     * @param string $pass
     * @return bool
     */
//    public function authorization(string $login, string $pass) : bool
//    {
//        if ($this->login == $login && $this->pass == $pass) {
//            $_SESSION['is_auth'] = true;
//            $_SESSION['username'] = $login;
//            View::render('login/welcome.php');
//        } else {
//            $_SESSION['is_auth'] = false;
//            return false;
//        }
//    }

    /**
     * @return bool|mixed
     */
    public static function getLogin()
    {
        if (self::isAuth()) {
            return $_SESSION['username'];
        }
        return false;
    }

}