<?php


namespace App\Models;


use App\Components\ErrorHandler;
use Core\Model;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
use PDOException;

class Genre extends Model
{

    protected static function getTableName(): string
    {
        return 'genres';
    }

    public function create(array $data)
    {
        try {
            $db = static::getDB();

            $date = date("Y-m-d H:i:s");
            $stmt = $db->prepare(
                "INSERT INTO " . static::getTableName() . " (
                            title, 
                            user_id, 
                            created_at, 
                            updated_at
                            ) 
                        VALUES (
                            :title, 
                            :user_id, 
                            :created_at, 
                            :updated_at
                        )"
            );
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':created_at', $date);
            $stmt->bindParam(':updated_at', $date);

            $stmt->execute();
            $id = $db->lastInsertId();
            $db = null;

            return $id;
        } catch (PDOException $e) {
            $log = new Logger('GenreModel');
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
                title = :title,
                user_id = :user_id,
                updated_at = :updated_at
                WHERE id = :genre_id;"
            );
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_STR);
            $stmt->bindParam(':updated_at', $date);
            $stmt->bindParam(':genre_id', $data['id'], PDO::PARAM_INT);

            $stmt->execute();
            $db = null;

            return true;
        } catch (PDOException $e) {
            $log = new Logger('GenreModel');
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

    public function showGenresByBookId(array $data)
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT g.id, g.title 
                FROM " . static::getTableName() . " AS g 
                JOIN book_genre AS bg ON g.id=bg.genre_id
                WHERE bg.book_id=:id;");
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll();
            $db = null;

            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            $log = new Logger('GenreModel');
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