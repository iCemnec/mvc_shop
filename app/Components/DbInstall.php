<?php

namespace App\Components;

use Core\Model;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDOException;

class DbInstall
{
    public function __construct()
    {
        try {
            $sql = "
                CREATE TABLE IF NOT EXISTS `roles` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
                CREATE TABLE IF NOT EXISTS `users` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `role_id` int(11) UNSIGNED NOT NULL,
                `first_name` varchar(60) NOT NULL,
                `last_name` varchar(60) NOT NULL,
                `email` varchar(30) NOT NULL,
                `phone` varchar(30) NOT NULL,
                `password` varchar(255) NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `publishers` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `books` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `isbn` varchar(30) NOT NULL,
                `title` varchar(255) NOT NULL,
                `pub_year` int(4) NOT NULL,
                `description` text DEFAULT NULL,
                `quantity` int(11) UNSIGNED NOT NULL,
                `image_path` varchar(255) DEFAULT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `publisher_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
                FOREIGN KEY (`publisher_id`) REFERENCES `publishers`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
                CREATE TABLE IF NOT EXISTS `authors` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `first_name` varchar(60) NOT NULL,
                `last_name` varchar(60) NOT NULL,
                `description` text DEFAULT NULL,
                `image_path` varchar(255) DEFAULT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `author_book` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `book_id` int(11) UNSIGNED NOT NULL,
                `author_id` int(11) UNSIGNED NOT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`book_id`) REFERENCES `books`(`id`),
                FOREIGN KEY (`author_id`) REFERENCES `authors`(`id`),
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `genres` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `book_genre` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `book_id` int(11) UNSIGNED NOT NULL,
                `genre_id` int(11) UNSIGNED NOT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`book_id`) REFERENCES `books`(`id`),
                FOREIGN KEY (`genre_id`) REFERENCES `genres`(`id`),
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `price_types` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `currencies` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `code_currency` varchar(3) NOT NULL,
                `value` float(20) NOT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `prices` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `price` float(20) NOT NULL,
                `book_id` int(11) UNSIGNED NOT NULL,
                `price_type_id` int(11) UNSIGNED NOT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`book_id`) REFERENCES `books`(`id`),
                FOREIGN KEY (`price_type_id`) REFERENCES `price_types`(`id`),
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `order_statuses` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `status` varchar(255) NOT NULL,
                `user_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `orders` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` int(11) UNSIGNED NOT NULL,
                `full_price` float(20) NOT NULL,
                `delivery_address` varchar(255) NOT NULL,
                `notes` text DEFAULT NULL,
                `order_status_id` int(11) UNSIGNED NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
                FOREIGN KEY (`order_status_id`) REFERENCES `order_statuses`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                CREATE TABLE IF NOT EXISTS `book_order` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `book_id` int(11) UNSIGNED NOT NULL,
                `order_id` int(11) UNSIGNED NOT NULL,
                `quantity` int(11) UNSIGNED NOT NULL,
                `current_price` float(20) NOT NULL,
                `created_at` timestamp NOT NULL,
                `updated_at` timestamp NOT NULL,
                PRIMARY KEY (`id`), 
                FOREIGN KEY (`book_id`) REFERENCES `books`(`id`),
                FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                ";

            $db = static::getDB();
            $db->query($sql);
            $db = null;
        } catch (PDOException $e) {
            $log = new Logger('DbInstall');
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