<?php


namespace Core;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
use PDOException;
use Config;

abstract class Model
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
            if (DEBUG) {
                echo "There is some problem with connection: " . $e->getMessage();
            }
        }
    }
}