<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "db_be1");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy `detail_id` từ URL
$detail_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra nếu `detail_id` hợp lệ
if ($detail_id > 0) {
    // Xóa bản ghi trong cơ sở dữ liệu
    $delete_sql = "DELETE FROM product_details WHERE detail_id = $detail_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Detail deleted successfully!'); window.location.href='details.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "<script>alert('Invalid detail ID!'); window.location.href='details.php';</script>";
}

// Đóng kết nối
$conn->close();
?>