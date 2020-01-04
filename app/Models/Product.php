<?php


namespace App\Models;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Product
{
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
        }

    }
}