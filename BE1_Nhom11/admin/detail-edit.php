<?php
include "header.php";
include "sidebar.php";

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "db_be1");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy `detail_id` từ URL
$detail_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra nếu có POST request để cập nhật dữ liệu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $description = $_POST['description'];
    $attribute_name = $_POST['attribute_name'];
    $attribute_value = $_POST['attribute_value'];
    $url_image = $_POST['url_image'];

    // Cập nhật dữ liệu vào cơ sở dữ liệu
    $update_sql = "UPDATE product_details SET 
                    product_id = '$product_id', 
                    description = '$description', 
                    attribute_name = '$attribute_name', 
                    attribute_value = '$attribute_value', 
                    url_image = '$url_image' 
                    WHERE detail_id = $detail_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Detail updated successfully!'); window.location.href='details.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Lấy dữ liệu chi tiết sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM product_details WHERE detail_id = $detail_id";
$result = $conn->query($sql);

// Kiểm tra nếu dữ liệu tồn tại
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<script>alert('Detail not found!'); window.location.href='details.php';</script>";
    exit;
}
?>

<div class="app-main">
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <h5>Edit Product Detail</h5>
            </div>

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form method="POST" action="">
                                <!-- Hiển thị ảnh hiện tại -->
                                <div class="form-group">
                                    <label>Current Image</label>
                                    <div>
                                        <img src="<?= $row['url_image']; ?>" alt="Product Image" class="img-thumbnail"
                                            style="max-width: 200px;">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="product_id">Product ID</label>
                                    <input type="text" name="product_id" id="product_id" class="form-control"
                                        value="<?= $row['product_id']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"
                                        required><?= $row['description']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="attribute_name">Attribute Name</label>
                                    <input type="text" name="attribute_name" id="attribute_name" class="form-control"
                                        value="<?= $row['attribute_name']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="attribute_value">Attribute Value</label>
                                    <input type="text" name="attribute_value" id="attribute_value" class="form-control"
                                        value="<?= $row['attribute_value']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="url_image">Image URL</label>
                                    <input type="text" name="url_image" id="url_image" class="form-control"
                                        value="<?= $row['url_image']; ?>">
                                </div>


                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
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