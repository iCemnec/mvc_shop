<?php


namespace Core;


class Controller
{
    protected $route_params = [];
    protected $validation = true;
    protected $data = [];

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }
}