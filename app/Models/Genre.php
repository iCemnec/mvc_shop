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
        // TODO: Implement create() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
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