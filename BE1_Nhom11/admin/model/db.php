<?php
// Thông tin kết nối cơ sở dữ liệu
$host = "localhost";
$username = "root";
$password = "";
$dbname = "db_be1"; // Thay bằng tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>