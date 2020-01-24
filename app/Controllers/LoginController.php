<?php


namespace App\Controllers;

use App\Components\Session;
use Core\View;
use App\Components\Auth;

class LoginController
{
    public $auth;
    public $session;

    public function __construct()
    {
        $this->auth = new Auth();
//        $this->session = new Session();
        $this->session = $this->auth->session;
    }

    public function index()
    {
        if ($this->auth->isAuth()) {
            $login = $this->session->get('login');
            View::render('login/welcome.php', compact('login'));
        } else {
            View::render('login/index.php');
        }
    }

    public function show()
    {
//        if ($this->auth->isAuth()) {
//            $login = $this->session->get('login');
//            View::render('login/welcome.php', compact('login'));
//        }
//
//        if (!empty($_POST['login']) && !empty($_POST['pass'])) {
//
//            $login = trim(htmlspecialchars($_POST['login']));
//            $pass = trim(htmlspecialchars($_POST['pass']));
//
//            $this->auth->authorization($login, $pass);
//            View::render('login/welcome.php', compact('login'));
//        }



    }

}