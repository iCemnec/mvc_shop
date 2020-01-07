<?php


namespace App\Components;

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function exceptionHandler($e) {
        if (DEBUG) {
            echo ('<div class="red">Error: ' . $e->getMessage() . '</div>');
            echo ('<div>File: ' . $e->getFile() . ' on line ' . $e->getLine() . '</div>');
        }
    }

}