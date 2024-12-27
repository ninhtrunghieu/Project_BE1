<?php
// Bao gồm các tệp cần thiết
include 'model/db.php';
include 'model/user.php';

// Khởi tạo đối tượng Database và kết nối
$db = new Database();
$conn = $db->getConnection();

// Khởi tạo đối tượng User
$userModel = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy ID người dùng từ form
    $id = $_POST['id'];

    // Gọi phương thức deleteUser để xóa người dùng
    if ($userModel->deleteUser($id)) {
        // Chuyển hướng đến trang user.php và thông báo thành công
        header("Location: user.php?message=Deleted successfully");
        exit();  // Dừng script sau khi redirect
    } else {
        echo "Xóa thất bại!";
    }
}
?>
