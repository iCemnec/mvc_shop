<?php


namespace App\Models;


use Core\Model;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;

class User extends Model
{
    public function __construct()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `users` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_type` ENUM('admin', 'manager', 'customer', 'reseller') DEFAULT 'customer',
                `first_name` varchar(255) NOT NULL,
                `last_name` varchar(255) NOT NULL,
                `email` varchar(255) NOT NULL,
                `phone` varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $db = static::getDB();
            $db->query($sql);
            $db = null;
        } catch (PDOException $e) {
            $log = new Logger('UserModel');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::ERROR
                )
            );
            $log->error($e->getMessage());
            if (DEBUG) {
                echo "There is some problem with create table users " . $e->getMessage();
            }
        }
    }

    public static function create($first_name, $last_name, $email, $phone, $password, $user_type)
    {
        try {
            $db = static::getDB();

            $date = date("Y-m-d H:i:s");
            $stmt = $db->prepare(
                "INSERT INTO `users` (
                            first_name, 
                            last_name, 
                            email, 
                            phone, 
                            password, 
                            user_type, 
                            created_at, 
                            updated_at
                            ) 
                        VALUES (
                            :first_name, 
                            :last_name, 
                            :email, 
                            :phone, 
                            :password, 
                            :created_at, 
                            :updated_at
                        )");
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':user_type', $user_type);
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
            if (DEBUG) {
                echo "There is some problem with create user " . $e->getMessage();
            }
        }
    }

    public function update($data)
    {
        try {
            $db = static::getDB();

            $date = date("Y-m-d H:i:s");
            $stmt = $db->prepare(
                "UPDATE `users` SET 
                first_name = :first_name, 
                last_name = :last_name, 
                email = :email, 
                phone = :phone, 
                updated_at = :updated_at
                WHERE `id` = :user_id"
            );
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
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
            if (DEBUG) {
                echo "There is some problem with update user " . $e->getMessage();
            }
        }
    }

    public function show($user_id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $result = $stmt->fetch();
            $db = null;

            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            $log = new Logger('UserModel');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::ERROR
                )
            );
            $log->error($e->getMessage());
            if (DEBUG) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function showAll($limit = 9)
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT * FROM `users` LIMIT :limit");
            $stmt->bindParam(':limit', $limit);
            $stmt->execute();

            $result = $stmt->fetchAll();
            $db = null;

            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            $log = new Logger('UserModel');
            $log->pushHandler(
                new StreamHandler(
                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
                    Logger::ERROR
                )
            );
            $log->error($e->getMessage());
            if (DEBUG) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function delete($user_id)
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("DELETE FROM `users` WHERE `id` = :user_id");
            $stmt->bindParam(':user_id', $user_id);
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
            if (DEBUG) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

}