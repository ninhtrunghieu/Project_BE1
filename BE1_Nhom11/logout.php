<?php
session_start(); // Bắt đầu session

// Xóa tất cả các session
session_unset();

// Hủy session
session_destroy();

// Chuyển hướng người dùng về trang chủ hoặc trang đăng nhập
header("Location: index.php"); // Bạn có thể thay đổi URL nếu muốn chuyển hướng đến một trang khác
exit();
?>
