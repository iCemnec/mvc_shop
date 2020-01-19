<?php


namespace App\Controllers;


use Core\Controller;
use Core\View;

class CartController extends Controller
{
    public function index()
    {
        View::render('common/cart.php');
    }

}