<?php


namespace App\Models;


use App\Components\ErrorHandler;
use Core\Model;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;

class Author extends Model
{

    protected static function getTableName(): string
    {
        return 'authors';
    }

    public function create($data)
    {
        try {
            $db = static::getDB();

            $date = date("Y-m-d H:i:s");
            $stmt = $db->prepare(
                "INSERT INTO " . static::getTableName() . " (
                            first_name, 
                            last_name, 
                            description, 
                            image_path, 
                            user_id, 
                            created_at, 
                            updated_at
                            ) 
                        VALUES (
                            :first_name, 
                            :last_name, 
                            :description, 
                            :image_path, 
                            :user_id, 
                            :created_at, 
                            :updated_at
                        )");
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':image_path', $data['image_path']);
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':created_at', $date);
            $stmt->bindParam(':updated_at', $date);

            $stmt->execute();
            $id = $db->lastInsertId();
            $db = null;

            return $id;
        } catch (PDOException $e) {
            $log = new Logger('AuthorModel');
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


    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

}