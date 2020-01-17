<?php


namespace Core;

use App\Components\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;

abstract class Model
{
    use DB;

    public function show(array $data)
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT * FROM " . static::getTableName(). " WHERE `id` = :id");
            $stmt->bindParam(':id', $data['id']);
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