<?php
// app/models/Item.php
namespace App\Models;

class Item {

    // Lấy tất cả sản phẩm
    public static function getAllItem() {
        $db = DB::getInstance();
        $sql = "SELECT * FROM items";  // Giả sử bảng có tên 'items'
        $result = $db->query($sql);
        return $result->fetchAll();
    }

    // Lấy thông tin sản phẩm theo ID
    public static function getById($id) {
        $db = DB::getInstance();
        $sql = "SELECT * FROM items WHERE id = :id";
        $result = $db->query($sql, ['id' => $id]);
        return $result->fetch();
    }

    // Lấy sản phẩm theo danh mục
    public static function getByCategory($categoryId) {
        $db = DB::getInstance();
        $sql = "SELECT * FROM items WHERE category_id = :category_id";
        $result = $db->query($sql, ['category_id' => $categoryId]);
        return $result->fetchAll();
    }
}
