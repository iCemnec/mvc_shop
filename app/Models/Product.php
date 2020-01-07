<?php


namespace App\Models;

use App\Components\ErrorHandler;
use Core\Model;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;

class Product extends Model
{

    public function __construct()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `products` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL,
                `description` text DEFAULT NULL,
                `quantity` int(11) UNSIGNED NOT NULL,
                `image_path` varchar(255) DEFAULT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `category_id` int(11) UNSIGNED NOT NULL,
                `brend_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
                FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
                FOREIGN KEY (`brend_id`) REFERENCES `brends`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

            $db = static::getDB();
            $db->query($sql);
            $db = null;
        } catch (PDOException $e) {
            $log = new Logger('ProductModel');
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

    public function getProducts()
    {
        try {
            if (file_exists(DIR_DATA . 'product_list.php')) {
                return include DIR_DATA . 'product_list.php';
            }
            throw new Exception("Products not found.");
        } catch (Exception $e) {
            $log = new Logger('Product');
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

    /**
     * @param int $id
     * @return bool|int|mixed
     */
    public function getProductById(int $id)
    {
        $products = $this->getProducts();

        try {
            foreach ($products as $product) {
                if ($product['id'] == $id) {
                    return $product;
                }
            }
            throw new Exception("This product id = {$id} was not found.");
        } catch (Exception $e) {
            $log = new Logger('Product');
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
}