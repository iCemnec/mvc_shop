<?php

namespace App\Components;

use App\Models\User;
use Core\View;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Auth extends Session
{

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return bool|mixed
     */
    public static function isAuth()
    {
        if (isset($_SESSION['is_auth'])) {
            return $_SESSION['is_auth'];
        }
        return false;
    }

    /**
     * @return bool|mixed
     */
    public static function getLogin()
    {
        if (self::isAuth()) {
            return $_SESSION['username'];
        }
        return false;
    }

    /**
     * @return bool
     */
    public static function checkAdmin(): bool
    {
        try {
            if (Auth::isAuth()) {
                $id = Auth::get('user_id');
                $role = User::getRole($id);
                if ($role == 'admin') {
                    return true;
                }
                return false;
            } else {
                return false;
            }
        } catch (Exception $e) {
            $log = new Logger('Auth');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
            return false;
        }
    }


}