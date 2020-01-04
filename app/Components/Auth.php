<?php

namespace App\Components;

use Core\View;

class Auth
{
    private $login = "user";
    private $pass = "pass";

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        new Session();
    }

    /**
     * @return bool|mixed
     */
    public function isAuth()
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
    public function authorization(string $login, string $pass) : bool
    {
        if ($this->login == $login && $this->pass == $pass) {
            $_SESSION['is_auth'] = true;
            $_SESSION['login'] = $login;
            View::render('login/welcome.php');
        } else {
            $_SESSION['is_auth'] = false;
            return false;
        }
    }

    /**
     * @return bool|mixed
     */
    public function getLogin()
    {
        if ($this->isAuth()) {
            return $_SESSION['login'];
        }
        return false;
    }

}