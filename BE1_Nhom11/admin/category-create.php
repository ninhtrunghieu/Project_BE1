<?php
ob_start();
session_start(); // Đặt session_start() ở đầu file
include "header.php";
include "sidebar.php";
// Kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'db_be1';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Xử lý yêu cầu thêm danh mục
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $total_products = $_POST['total_products'];

    // Câu lệnh SQL để thêm danh mục
    $insertQuery = "INSERT INTO product_categories (name, total_products) VALUES (:name, :total_products)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
    $insertStmt->bindParam(':total_products', $total_products, PDO::PARAM_INT);

    if ($insertStmt->execute()) {
        $_SESSION['message'] = "Category created successfully.";
        header('Location: category.php');
        exit; // Đảm bảo không có code nào sau header()
    } else {
        $_SESSION['error'] = "Error creating category.";
    }
}
?>


<div class="app-main">
    <div class="app-sidebar sidebar-shadow">
        <!-- Sidebar content here -->
    </div>

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                        </div>
                        <div>
                            Create Category
                            <div class="page-title-subheading">
                                Add a new category to the system.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hiển thị thông báo nếu có -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['message']; ?></div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Form Thêm Danh Mục -->
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">Create a New Category</div>
                        <div class="card-body">
                            <form action="category-create.php" method="post">
                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="total_products">Total Products</label>
                                    <input type="number" name="total_products" id="total_products" class="form-control"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Category</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


    <?php include "footer.php"; ?>
</div>