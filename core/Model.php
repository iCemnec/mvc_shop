<?php


namespace Core;

use App\Components\ErrorHandler;
use MongoDB\Driver\Exception\Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
use PDOException;
use Config;

abstract class Model
{
    use DB;

    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

//    protected static function getDB()
//    {
//        try {
//            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=' . Config::CHARSET;
//            $options = [
//                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//            ];
//            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD, $options);
//
//            return $db;
//        } catch (PDOException $e) {
//            $log = new Logger('DB');
//            $log->pushHandler(
//                new StreamHandler(
//                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
//                    Logger::ERROR
//                )
//            );
//            $log->error($e->getMessage());
//            $error = new ErrorHandler();
//            $error->exceptionHandler($e);
//            return false;
//        }
//    }

    public function show(int $id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT * FROM " . static::getTableName(). " WHERE `id` = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $result = $stmt->fetch();
            $db = null;

            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            $log = new Logger('Model');
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

    public function showAll()
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT * FROM " . static::getTableName());
            $stmt->execute();

            $result = $stmt->fetchAll();
            $db = null;

            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            $log = new Logger('Model');
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

    public function delete($id): bool
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("DELETE FROM " . static::getTableName() . " WHERE `id` = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $db = null;

            return true;
        } catch (PDOException $e) {
            $log = new Logger('Model');
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

    public function save(array $data): void
    {
        if (isset($data['id'])) {
            $this->update($data);
        } else {
            $this->create($data);
        }
    }

    abstract protected static function getTableName(): string;

    abstract public function create(array $data);

    abstract public function update(array $data);

}