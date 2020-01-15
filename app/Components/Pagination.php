<?php


namespace App\Components;


use Core\DB;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
use PDOException;

class Pagination
{
    use DB;

    private $db, $table, $total_records, $limit = 5;

    public function __construct($table)
    {
//        try {
            $this->db = static::getDB();

            $this->table = $table;
            $this->set_total_records();
//
//            $stmt = $db->prepare("SELECT * FROM " . static::getTableName());
//            $stmt->execute();
//
//            $result = $stmt->fetchAll();
//            $db = null;
//
//            return !empty($result) ? $result : false;
//        } catch (PDOException $e) {
//            $log = new Logger('Model');
//            $log->pushHandler(
//                new StreamHandler(
//                    LOG_PATH . 'mono-log-' . date('Y-m-d') . '.log',
//                    Logger::ERROR
//                )
//            );
//            $log->error($e->getMessage());
//            $error = new ErrorHandler();
//            $error->exceptionHandler($e);
//            return false;
//        }
    }

    public function set_total_records()
    {
        $stmt = $this->db->prepare("SELECT id FROM :table");
        $stmt->bindParam(':table', $this->table);
        $stmt->execute();

        $this->total_records = $stmt->rowCount();
    }

    public function current_page()
    {
        return isset($_GET['page']) ? (int)$_GET['page'] : 1;
    }

    public function get_data()
    {
        $start = 0;

        if($this->current_page() > 1){
            $start = ($this->current_page() * $this->limit) - $this->limit;
        }

        $stmt = $this->db->prepare("SELECT * FROM :table LIMIT $start, :limit");
        $stmt->bindParam(':table', $this->table);
        $stmt->bindParam(':limit', $this->limit);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function get_pagination_number()
    {
        return ceil($this->total_records / $this->limit);
    }

}