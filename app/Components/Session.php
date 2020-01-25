<?php

namespace App\Components;

use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Session
{
    private $name;
    protected $sessionPath = ROOT . '/storage/sessions';

    public function __construct()
    {
        $this->setSavePath($this->sessionPath);
        $this->start();
    }


    /**
     * @return bool
     */
    public function start()
    {
        try {
            if (self::sessionExists()) {
                throw new Exception('Can not start the session. The session has already started.');
            }
            return session_start();
        } catch (Exception $e) {
            $log = new Logger('Session');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }

    /**
     * @param string $path
     * @return string
     */
    public function setSavePath(string $path)
    {
        try {
            if (self::sessionExists()) {
                throw new Exception('Can not set the session path. The session has already started.');
            }
            return session_save_path($path);
        } catch (Exception $e) {
            $log = new Logger('Session');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }

    /**
     * @param string $name
     * @return string
     */
    public function setName(string $name)
    {
        try {
            if (self::sessionExists()) {
                throw new Exception('Can not set the session name. The session has already started.');
            }
            $this->name = $name;
            return session_name($name);
        } catch (Exception $e) {
            $log = new Logger('Session');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        try {
            if (self::sessionExists()) {
                return session_name();
            }
            throw new Exception('Can not get the session name. The session has not started yet.');
        } catch (Exception $e) {
            $log = new Logger('Session');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }

    /**
     * @return bool
     */
    public static function sessionExists() : bool
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return true;
        }
        return false;
    }

    /**
     * @return bool|int
     */
    public static function sessionDelete()
    {
        try {
            if (self::sessionExists()) {
                $_SESSION = [];
                session_unset();
                session_destroy();
                return true;
            }
            throw new Exception('Can not delete the session. The session has not started yet.');
        } catch (Exception $e) {
            $log = new Logger('Session');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }

    /**
     * @param string $name
     * @param string $value
     * @return string
     */
    public static function set(string $name, string $value) : string
    {
        try {
            if (self::sessionExists()) {
                return $_SESSION[$name] = $value;
            }
            throw new Exception('Can not set the value for this name. The session has not started yet.');
        } catch (Exception $e) {
            $log = new Logger('Session');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }


    /**
     * @param string $name
     * @return mixed
     */
    public static function get(string $name)
    {
        try {
            if (self::sessionExists() && self::exists($name)) {
                return $_SESSION[$name];
            }
            throw new Exception('Can not get the value for this name. This name is not exists.');
        } catch (Exception $e) {
            $log = new Logger('Session');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function exists(string $name) : bool
    {
        if (isset($_SESSION[$name])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delete(string $name) : bool
    {
        try {
            if (self::exists($name)) {
                unset($_SESSION[$name]);
                return true;
            }
            throw new Exception('Can not get the value for this name. This name is not exists.');
        } catch (Exception $e) {
            $log = new Logger('Session');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::WARNING
                )
            );
            $log->warning($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
        }
    }

    /**
     * @return bool
     */
    public function cookieExists() : bool
    {
        if (count($_COOKIE) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function logOut() : array
    {
        return $_SESSION = [];
    }

}