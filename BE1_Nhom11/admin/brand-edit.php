<?php
include "header.php";
include "sidebar.php";

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "db_be1");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy ID của thương hiệu từ URL
$brand_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Nếu người dùng gửi form để cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $product_count = $_POST['product_count'];

    // Cập nhật thông tin thương hiệu
    $sql = "UPDATE brands SET name = ?, product_count = ? WHERE brand_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $name, $product_count, $brand_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Brand updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating brand.');</script>";
    }
}

// Lấy thông tin thương hiệu cần sửa
$sql = "SELECT brand_id, name, product_count FROM brands WHERE brand_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $brand_id);
$stmt->execute();
$result = $stmt->get_result();
$brand = $result->fetch_assoc();

if (!$brand) {
    echo "<script>alert('Brand not found!');</script>";
    exit;
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
                            Edit Brand
                            <div class="page-title-subheading">
                                Modify the details of the brand.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <h5>Edit Brand</h5>
                        </div>
                        <div class="card-body">
                            <form action="brand-edit.php?id=<?php echo $brand['brand_id']; ?>" method="POST">
                                <div class="form-group">
                                    <label for="name">Brand Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $brand['name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_count">Product Count</label>
                                    <input type="number" class="form-control" name="product_count" id="product_count" value="<?php echo $brand['product_count']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Brand</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
<?php include "footer.php"; ?>
</div>

<?php
// Đóng kết nối
$conn->close();
?>
