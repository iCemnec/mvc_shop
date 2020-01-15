<?php


namespace Core;


use App\Components\ErrorHandler;
use Config;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
use PDOException;

trait DB
{
    protected static function getDB()
    {
        try {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=' . Config::CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD, $options);

            return $db;
        } catch (PDOException $e) {
            $log = new Logger('DB');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::ERROR
                )
            );
            $log->error($e->getMessage());
            $error = new ErrorHandler();
            $error->exceptionHandler($e);
            return false;
        }
    }

}