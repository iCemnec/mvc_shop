<?php


namespace App\Controllers;


use App\Models\User;
use Core\Controller;

class UserController extends Controller
{
    protected $user;

    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->user = new User();
    }

}