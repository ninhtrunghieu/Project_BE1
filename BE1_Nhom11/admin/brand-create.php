<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "db_be1");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý thêm brand nếu có yêu cầu
if (isset($_POST['add'])) {
    // Lấy thông tin brand từ form
    $name = $_POST['name'];
    $product_count = $_POST['product_count'];

    // Câu lệnh SQL để thêm brand
    $sql = "INSERT INTO brands (name, product_count) VALUES (?, ?)";

    // Sử dụng prepared statement để tránh SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $product_count);

    // Thực thi câu lệnh thêm
    if ($stmt->execute()) {
        echo "<script>alert('Brand added successfully!'); window.location='brand.php';</script>";
    } else {
        echo "<script>alert('Error adding brand: " . $conn->error . "');</script>";
    }

    // Đóng statement
    $stmt->close();
}

?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<div class="app-main">
    <div class="app-main__outer">
        <div class="app-main__inner">

            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                        </div>
                        <div>
                            Add Brand
                            <div class="page-title-subheading">
                                Create a new brand by filling in the details below.
                            </div>
                        </div>
                    </div>

                    <div class="page-title-actions">
                        <a href="brand-list.php" class="btn-shadow btn-hover-shine mr-3 btn btn-primary">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-arrow-left fa-w-20"></i>
                            </span>
                            Back to list
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">Add New Brand</div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="name">Brand Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_count">Product Count</label>
                                    <input type="number" id="product_count" name="product_count" class="form-control" required>
                                </div>
                                <button type="submit" name="add" class="btn btn-primary">Add Brand</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
<?php include "footer.php"; ?>
