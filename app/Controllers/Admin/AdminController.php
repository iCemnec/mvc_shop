<?php


namespace App\Controllers\Admin;


use App\Components\Auth;
use Core\Controller;
use Core\View;


class AdminController extends Controller
{

    public function index()
    {
        if (Auth::checkAdmin()) {
            View::render('admin/dashboard.php');
        } else {
            View::render('admin/index.php');
        }

    }

}