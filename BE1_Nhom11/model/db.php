<?php

// app/models/DB.php
namespace App\Models;

require_once 'config.php'; // Chỉ cần một lần yêu cầu config.php
use PDO;

class DB {

    private static $instance = null;
    private $connection;

    // Lấy kết nối cơ sở dữ liệu
    private function __construct() {
        try {
            // Sử dụng các hằng số từ config.php
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . PORT . ';charset=' . DB_CHARSET;
            $this->connection = new PDO($dsn, DB_USER, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Lấy instance của DB (singleton pattern)
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    // Truy vấn cơ sở dữ liệu
    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
