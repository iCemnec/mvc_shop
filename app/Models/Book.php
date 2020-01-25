<?php


namespace App\Models;

use App\Components\ErrorHandler;
use Core\Model;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;

class Book extends Model
{

    protected static function getTableName(): string
    {
        return 'books';
    }

    public function create(array $data)
    {
        try {
            $db = static::getDB();

            $date = date("Y-m-d H:i:s");
            $stmt = $db->prepare(
                "INSERT INTO " . static::getTableName() . " (
                            isbn, 
                            title, 
                            pub_year, 
                            description, 
                            quantity, 
                            image_path, 
                            user_id, 
                            publisher_id, 
                            created_at, 
                            updated_at
                            ) 
                        VALUES (
                            :isbn, 
                            :title, 
                            :pub_year, 
                            :description, 
                            :quantity, 
                            :image_path, 
                            :user_id, 
                            :publisher_id, 
                            :created_at, 
                            :updated_at
                        )");
            $stmt->bindParam(':isbn', $data['isbn'], PDO::PARAM_STR);
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':pub_year', $data['pub_year'], PDO::PARAM_INT);
            $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $data['quantity'], PDO::PARAM_INT);
            $stmt->bindParam(':image_path', $data['image_path'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':publisher_id', $data['publisher_id'], PDO::PARAM_INT);
            $stmt->bindParam(':created_at', $date);
            $stmt->bindParam(':updated_at', $date);

            $stmt->execute();
            $id = $db->lastInsertId();
            $db = null;

            return $id;
        } catch (PDOException $e) {
            $log = new Logger('BookModel');
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
                isbn = :isbn, 
                title = :title, 
                pub_year = :pub_year, 
                description = :description, 
                quantity = :quantity, 
                image_path = :image_path, 
                user_id = :user_id, 
                publisher_id = :publisher_id, 
                updated_at = :updated_at
                WHERE id = :book_id"
            );
            $stmt->bindParam(':isbn', $data['isbn'], PDO::PARAM_STR);
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':pub_year', $data['pub_year'], PDO::PARAM_INT);
            $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $data['quantity'], PDO::PARAM_INT);
            $stmt->bindParam(':image_path', $data['image_path'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $data['id'], PDO::PARAM_INT);
            $stmt->bindParam(':publisher_id', $data['publisher_id'], PDO::PARAM_INT);
            $stmt->bindParam(':updated_at', $date);
            $stmt->bindParam(':book_id', $data['id'], PDO::PARAM_INT);

            $stmt->execute();
            $db = null;

            return true;
        } catch (PDOException $e) {
            $log = new Logger('BookModel');
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

    public function showNew()
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT b.id, b.title, b.pub_year, b.image_path, p.price,
                c.code_currency, ab.author_id, a.first_name, a.last_name 
                FROM " . static::getTableName() . " AS b JOIN prices AS p ON b.id=p.book_id 
                JOIN currencies AS c ON c.id=p.currency_id
                JOIN author_book AS ab ON b.id=ab.book_id 
                JOIN authors AS a ON a.id=ab.author_id
                WHERE p.price_type_id=1
                ORDER BY b.created_at DESC LIMIT 4;");
            $stmt->execute();

            $result = $stmt->fetchAll();
            $db = null;

            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            $log = new Logger('BookModel');
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

            $stmt = $db->prepare("SELECT DISTINCT b.id, b.title, b.pub_year, b.image_path,
                p.price, c.code_currency, ab.author_id, a.first_name, a.last_name
                FROM " . static::getTableName() . " AS b
                JOIN book_genre AS bg ON b.id=bg.book_id
                JOIN prices AS p ON b.id=p.book_id
                JOIN currencies AS c ON c.id=p.currency_id
                JOIN author_book AS ab ON b.id=ab.book_id
                JOIN authors AS a ON a.id=ab.author_id
                WHERE p.price_type_id=1;");

            $stmt->execute();

            $result = $stmt->fetchAll();
            $db = null;

            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            $log = new Logger('BookModel');
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

    public function showBooksByGenreId(array $data)
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT b.id, b.title, b.pub_year, b.image_path, 
                p.price, c.code_currency, ab.author_id, a.first_name, a.last_name 
                FROM " . static::getTableName() . " AS b 
                JOIN book_genre AS bg ON b.id=bg.book_id
                JOIN prices AS p ON b.id=p.book_id 
                JOIN currencies AS c ON c.id=p.currency_id
                JOIN author_book AS ab ON b.id=ab.book_id 
                JOIN authors AS a ON a.id=ab.author_id
                WHERE bg.genre_id=:genre_id AND p.price_type_id=1;");

            $stmt->bindParam(':genre_id', $data['id']);
            $stmt->execute();

            $result = $stmt->fetchAll();
            $db = null;

            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            $log = new Logger('BookModel');
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

    public function show(array $data)
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT b.*, 
                p.price, c.code_currency, ab.author_id, a.first_name, a.last_name 
                FROM " . static::getTableName() . " AS b 
                JOIN book_genre AS bg ON b.id=bg.book_id
                JOIN prices AS p ON b.id=p.book_id 
                JOIN currencies AS c ON c.id=p.currency_id
                JOIN author_book AS ab ON b.id=ab.book_id 
                JOIN authors AS a ON a.id=ab.author_id
                WHERE b.id=:id AND p.price_type_id=1;");
            $stmt->bindParam(':id', $data['id']);
            $stmt->execute();

            $result = $stmt->fetch();
            $db = null;

            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            $log = new Logger('BookModel');
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

    public function showBooksByAuthorId(array $data)
    {
        try {
            $db = static::getDB();

            $stmt = $db->prepare("SELECT DISTINCT b.id, b.title, b.pub_year, b.image_path, 
                p.price, c.code_currency, ab.author_id, a.first_name, a.last_name 
                FROM " . static::getTableName() . " AS b 
                JOIN book_genre AS bg ON b.id=bg.book_id
                JOIN prices AS p ON b.id=p.book_id 
                JOIN currencies AS c ON c.id=p.currency_id
                JOIN author_book AS ab ON b.id=ab.book_id 
                JOIN authors AS a ON a.id=ab.author_id
                WHERE ab.author_id=:author_id AND p.price_type_id=1;");

            $stmt->bindParam(':author_id', $data['id']);
            $stmt->execute();

            $result = $stmt->fetchAll();
            $db = null;

            return !empty($result) ? $result : false;
        } catch (PDOException $e) {
            $log = new Logger('BookModel');
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