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

// Kiểm tra xem có dữ liệu gửi đến không
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = intval($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);

    // Cập nhật trạng thái đơn hàng
    $sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: order.php?message=Trạng thái đơn hàng đã được cập nhật.");
    } else {
        header("Location: order.php?error=Lỗi khi cập nhật trạng thái đơn hàng.");
    }
}

$conn->close();
?>