<?php


namespace App\Models;


use App\Components\ErrorHandler;
use Core\Model;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;

class User extends Model
{

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function create(array $data)
    {
        try {
            $db = static::getDB();

            $date = date("Y-m-d H:i:s");
            $stmt = $db->prepare(
                "INSERT INTO " . static::getTableName() . " (
                            first_name, 
                            last_name, 
                            email, 
                            phone, 
                            password, 
                            role_id, 
                            created_at, 
                            updated_at
                            ) 
                        VALUES (
                            :first_name, 
                            :last_name, 
                            :email, 
                            :phone, 
                            :password, 
                            :role_id, 
                            :created_at, 
                            :updated_at
                        )");
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':role_id', $data['role_id']);
            $stmt->bindParam(':created_at', $date);
            $stmt->bindParam(':updated_at', $date);

            $stmt->execute();
            $id = $db->lastInsertId();
            $db = null;

            return $id;
        } catch (PDOException $e) {
            $log = new Logger('UserModel');
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
        try {
            $db = static::getDB();

            $date = date("Y-m-d H:i:s");
            $stmt = $db->prepare(
                "UPDATE " . static::getTableName() . " SET 
                first_name = :first_name, 
                last_name = :last_name, 
                email = :email, 
                phone = :phone, 
                updated_at = :updated_at
                WHERE id = :user_id"
            );
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':role_id', $data['role_id']);
            $stmt->bindParam(':updated_at', $date);
            $stmt->bindParam(':user_id', $data['id']);

            $stmt->execute();
            $db = null;

            return true;
        } catch (PDOException $e) {
            $log = new Logger('UserModel');
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