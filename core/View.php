<?php


namespace Core;

use App\Components\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Exception;

class View
{
    protected static $viewPath = '/app/Views/';

    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        try {
            $file = dirname(__DIR__) . static::$viewPath . $view;

            if (is_readable($file)) {
                require_once $file;
            } else {
                throw new Exception("File {$view} not found.");
            }
        } catch (Exception $e) {
            $log = new Logger('View');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::ERROR
                )
            );
            $log->error($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }
}