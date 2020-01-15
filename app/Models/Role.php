<?php


namespace App\Models;


use App\Components\ErrorHandler;
use Core\Model;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;

class Role extends Model
{

    protected static function getTableName(): string
    {
        return 'roles';
    }

    public function create(array $data)
    {
        try {
            $db = static::getDB();

            $date = date("Y-m-d H:i:s");
            $stmt = $db->prepare(
                "INSERT INTO " . static::getTableName() . " (
                            title, 
                            created_at, 
                            updated_at
                            ) 
                        VALUES (
                            :title, 
                            :created_at, 
                            :updated_at
                        )");
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':created_at', $date);
            $stmt->bindParam(':updated_at', $date);

            $stmt->execute();
            $id = $db->lastInsertId();
            $db = null;

            return $id;
        } catch (PDOException $e) {
            $log = new Logger('RoleModel');
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


    public function update(array $data)
    {
        // TODO: Implement update() method.
    }
}