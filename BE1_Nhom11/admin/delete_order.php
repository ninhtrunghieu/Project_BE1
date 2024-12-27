<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_be1";

// Kết nối database
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra xem có ID đơn hàng được gửi đến không
if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']); // Lấy ID đơn hàng từ URL

    // Xóa đơn hàng
    $sql = "DELETE FROM orders WHERE id = $order_id";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng về trang quản lý đơn hàng với thông báo thành công
        header("Location: order.php?message=Đơn hàng đã được xóa thành công.");
    } else {
        // Chuyển hướng về trang quản lý đơn hàng với thông báo lỗi
        header("Location: order.php?error=Lỗi khi xóa đơn hàng.");
    }
} else {
    // Nếu không có ID, chuyển hướng về trang quản lý đơn hàng với thông báo lỗi
    header("Location: order.php?error=Không tìm thấy đơn hàng.");
}

$conn->close();
?>