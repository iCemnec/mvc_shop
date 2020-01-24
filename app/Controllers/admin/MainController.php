<?php


namespace App\Controllers\admin;


use Core\Controller;
use Core\View;

class MainController extends Controller
{
    public function index()
    {
        View::render('admin/dashboard.php');
    }

}