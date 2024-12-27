<?php
include "header.php";
include "sidebar.php";

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "db_be1");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $product_id = $_POST['product_id'];
    $description = $_POST['description'];
    $attribute_name = $_POST['attribute_name'];
    $attribute_value = $_POST['attribute_value'];
    $url_image = $_POST['url_image'];

    // Insert dữ liệu vào bảng product_details
    $sql = "INSERT INTO product_details (product_id, description, attribute_name, attribute_value, url_image) 
            VALUES ('$product_id', '$description', '$attribute_name', '$attribute_value', '$url_image')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New product detail added successfully!'); window.location.href='details.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

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
                            Details
                            <div class="page-title-subheading">
                                View, create, update, delete and manage.
                            </div>
                        </div>
                    </div>

                    <div class="page-title-actions">
                        <a href="./details-create.php" class="btn-shadow btn-hover-shine mr-3 btn btn-primary">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-plus fa-w-20"></i>
                            </span>
                            Create
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="product_id">Product ID</label>
                                    <input type="text" name="product_id" id="product_id" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"
                                        required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="attribute_name">Attribute Name</label>
                                    <input type="text" name="attribute_name" id="attribute_name" class="form-control"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="attribute_value">Attribute Value</label>
                                    <input type="text" name="attribute_value" id="attribute_value" class="form-control"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="url_image">Image URL</label>
                                    <input type="text" name="url_image" id="url_image" class="form-control">
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                    <a href="details.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include "footer.php"; ?>
    </div>
</div>

<?php
// Đóng kết nối
$conn->close();
?>