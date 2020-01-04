<?php


namespace App\Controllers;

use Core\Controller;
use App\Models\Product;
use Core\View;
use Exception;

class HomeController extends Controller
{
    public function index()
    {
        $products = new Product;
        $products = $products->getProducts();

        View::render('products/index.php', $products);
    }
}