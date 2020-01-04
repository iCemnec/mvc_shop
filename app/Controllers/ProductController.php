<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Controller;
use Core\View;

class ProductController extends Controller
{
    protected $product;

    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->product = new Product;
    }

    public function index()
    {
        $products = $this->product->getProducts();

        View::render('products/index.php', $products);
    }

}