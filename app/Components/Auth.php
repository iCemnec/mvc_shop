<?php

namespace App\Components;

use Core\View;

class Auth extends Session
{
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
        }
        return false;
    }

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