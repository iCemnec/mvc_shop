<?php


namespace App\Models;


use App\Components\ErrorHandler;
use Core\Model;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
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
                            auth_token, 
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
                            :auth_token, 
                            :created_at, 
                            :updated_at
                        )");
            $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
            $stmt->bindParam(':role_id', $data['role_id'], PDO::PARAM_INT);
            $stmt->bindParam(':auth_token', $data['auth_token'], PDO::PARAM_STR);
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
                role_id = :role_id, 
                updated_at = :updated_at
                WHERE id = :user_id;"
            );
            $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
            $stmt->bindParam(':role_id', $data['role_id'], PDO::PARAM_INT);
            $stmt->bindParam(':updated_at', $date);
            $stmt->bindParam(':user_id', $data['id'], PDO::PARAM_INT);

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

    public static function checkUserData(string $email, string $password) {
        try {
            $db = static::getDB();

            $stmt = $db->prepare(
                "SELECT * FROM " . static::getTableName().
                " WHERE email = :email;"
            );
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch();
            $db = null;

            if (!empty($result) && password_verify($password, $result['password'])) {
                return $result;
            } else {
                return false;
            }

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

    public function checkUserPassword(int $id, string $password) : bool
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare(
                "SELECT password FROM " . static::getTableName().
                " WHERE id = :id;"
            );
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            $db = null;

            return (!empty($result) && password_verify($password, $result)) ? true : false;

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