<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_be1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy product_id từ URL
$product_id = isset($_GET['product_id']) ? (int) $_GET['product_id'] : 0;

if ($product_id > 0) {
    // Truy vấn lấy thông tin sản phẩm
    $productQuery = "SELECT * FROM products WHERE product_id = $product_id";
    $productResult = $conn->query($productQuery);
    $product = $productResult->fetch_assoc();
} else {
    echo "Invalid product ID.";
    exit;
}

// Truy vấn bảng `brands`
$brandQuery = "SELECT * FROM brands";
$brands = $conn->query($brandQuery);

// Truy vấn bảng `product_categories`
$categoryQuery = "SELECT * FROM product_categories";
$categories = $conn->query($categoryQuery);

// Xử lý cập nhật sản phẩm khi người dùng gửi form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu từ form
    $brand_id = $_POST['brand_id'];
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Kiểm tra nếu có file ảnh được upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name']; // Tên file ảnh
        $target_dir = "../img/home/";  // Đảm bảo thư mục này tồn tại

        // Kiểm tra nếu file đã được chọn
        if ($image) {
            $target_file = $target_dir . basename($image); // Tạo đường dẫn file đích

            // Di chuyển file từ thư mục tạm thời đến thư mục đích
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Nếu tải ảnh lên thành công, sử dụng đường dẫn mới
                $image_url = 'img/home/' . basename($image);
            } else {
                echo "Không thể tải ảnh lên.";
                exit;
            }
        }
    } else {
        // Nếu không có ảnh mới, giữ lại ảnh cũ từ cơ sở dữ liệu
        $image_url = $product['image_url'];
    }

    // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
    $updateQuery = "UPDATE products SET brand_id = '$brand_id', category_id = '$category_id', name = '$name', description = '$description', price = '$price', image_url = '$image_url' WHERE product_id = $product_id";

    if ($conn->query($updateQuery)) {
        echo "Sản phẩm đã được cập nhật thành công!";
    } else {
        echo "Lỗi cập nhật sản phẩm: " . $conn->error;
    }

}
?>

<?php
include "header.php";
include "sidebar.php";
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
                            Edit Product
                            <div class="page-title-subheading">
                                Edit product details below.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">

                                <!-- Brand Dropdown -->
                                <div class="position-relative row form-group">
                                    <label for="brand_id" class="col-md-3 text-md-right col-form-label">Brand</label>
                                    <div class="col-md-9 col-xl-8">
                                        <select required name="brand_id" id="brand_id" class="form-control">
                                            <option value="">-- Brand --</option>
                                            <?php
                                            if ($brands->num_rows > 0) {
                                                while ($brand = $brands->fetch_assoc()) {
                                                    $selected = $brand['brand_id'] == $product['brand_id'] ? 'selected' : '';
                                                    echo '<option value="' . $brand['brand_id'] . '" ' . $selected . '>' . $brand['name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Category Dropdown -->
                                <div class="position-relative row form-group">
                                    <label for="category_id"
                                        class="col-md-3 text-md-right col-form-label">Category</label>
                                    <div class="col-md-9 col-xl-8">
                                        <select required name="category_id" id="category_id" class="form-control">
                                            <option value="">-- Category --</option>
                                            <?php
                                            if ($categories->num_rows > 0) {
                                                while ($category = $categories->fetch_assoc()) {
                                                    $selected = $category['category_id'] == $product['category_id'] ? 'selected' : '';
                                                    echo '<option value="' . $category['category_id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Product Name -->
                                <div class="position-relative row form-group">
                                    <label for="name" class="col-md-3 text-md-right col-form-label">Name</label>
                                    <div class="col-md-9 col-xl-8">
                                        <input required name="name" id="name" placeholder="Name" type="text"
                                            class="form-control" value="<?= $product['name'] ?>">
                                    </div>
                                </div>

                                <!-- Product Description -->
                                <div class="position-relative row form-group">
                                    <label for="description"
                                        class="col-md-3 text-md-right col-form-label">Description</label>
                                    <div class="col-md-9 col-xl-8">
                                        <input required name="description" id="description" placeholder="Description"
                                            type="text" class="form-control" value="<?= $product['description'] ?>">
                                    </div>
                                </div>

                                <!-- Product Price -->
                                <div class="position-relative row form-group">
                                    <label for="price" class="col-md-3 text-md-right col-form-label">Price</label>
                                    <div class="col-md-9 col-xl-8">
                                        <input required name="price" id="price" placeholder="Price" type="text"
                                            class="form-control" value="<?= $product['price'] ?>">
                                    </div>
                                </div>

                                <!-- Product Image -->
                                <div class="position-relative row form-group">
                                    <label for="image" class="col-md-3 text-md-right col-form-label">Image</label>
                                    <div class="col-md-9 col-xl-8">
                                        <input name="image" id="image" type="file" class="form-control"
                                            accept="image/*">

                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="position-relative row form-group mb-1">
                                    <div class="col-md-9 col-xl-8 offset-md-2">
                                        <button type="submit" class="btn-shadow btn-hover-shine btn btn-primary">
                                            <span class="btn-icon-wrapper pr-2 opacity-8">
                                                <i class="fa fa-save fa-w-20"></i>
                                            </span>
                                            <span>Save</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main -->

        <?php include "footer.php"; ?>
    </div>
</div>

<?php
$conn->close();
?>