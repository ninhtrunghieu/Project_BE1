<?php
class User
{
    private $conn;
    private $table_name = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả người dùng
    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Tìm kiếm người dùng theo tên hoặc email
    public function searchUsers($searchTerm)
    {
        $query = "SELECT * FROM users WHERE fullname LIKE ? OR email LIKE ?";
        $stmt = $this->conn->prepare($query);
        $searchTermWithWildcard = '%' . $searchTerm . '%';
        $stmt->bind_param('ss', $searchTermWithWildcard, $searchTermWithWildcard);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Phương thức xóa người dùng
    public function deleteUser($id)
    {
        // Chuẩn bị câu truy vấn SQL để xóa người dùng
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // Chuẩn bị câu truy vấn
        $stmt = $this->conn->prepare($query);

        // Ràng buộc tham số với kiểu 'i' (integer) cho id
        $stmt->bind_param('i', $id);

        // Thực thi câu truy vấn và trả về kết quả
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}
?>