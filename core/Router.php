<?php


namespace Core;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function add($route, $params = [])
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace(
            '/\//',
            '\\/',
            $route
        );
        // Convert variables e.g. {controller}
        $route = preg_replace(
            '/\{([a-z]+)\}/',
            '(?P<\1>[a-z-]+)',
            $route
        );
        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace(
            '/\{([a-z]+):([^\}]+)\}/',
            '(?P<\1>\2)',
            $route
        );
        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    public function match($url)
    {
        $url = trim($url, '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * @param $url
     * @return bool|int
     */
    public function dispatch($url)
    {
        try {
            $result = [];
            $url = trim($url, '/');
            if ($this->match($url)) {
                $result['controller'] = $this->params['controller'];
                $result['controller'] = $this->getNamespaceController() . $result['controller'];
                $controller = $result['controller'];
                unset($this->params['controller']);

                if (class_exists($result['controller'])) {
                    $result['action'] = $this->params['action'];
                    $action = $this->params['action'];
                    unset($this->params['action']);

                    if (method_exists($result['controller'], $result['action'])) {
                        $result['params'] = $this->params;
                        $obj = new $controller($result['params']);
                        $obj->$action($this->params);
                    } else {
                        throw new Exception("Method {$result['action']} not found");
                    }
                } else {
                    throw new Exception("Controller class {$result['controller']} not found");
                }
            } else {
                throw new Exception('No matches');
            }
        } catch (Exception $e) {
            $log = new Logger('Router');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::ERROR
                )
            );
        }
    }

    protected function getNamespaceController()
    {
        return 'App\Controllers\\';
    }
}