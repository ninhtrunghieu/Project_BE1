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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $brand_id = isset($_POST['brand_id']) ? intval($_POST['brand_id']) : null;
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : null;

    // Kiểm tra `brand_id` hợp lệ
    $brandCheckQuery = "SELECT * FROM brands WHERE brand_id = $brand_id";
    if ($brand_id === null || $conn->query($brandCheckQuery)->num_rows === 0) {
        die("Thương hiệu không tồn tại hoặc không hợp lệ.");
    }

    // Kiểm tra `category_id` hợp lệ
    $categoryCheckQuery = "SELECT * FROM product_categories WHERE category_id = $category_id";
    if ($category_id === null || $conn->query($categoryCheckQuery)->num_rows === 0) {
        die("Danh mục sản phẩm không tồn tại hoặc không hợp lệ.");
    }

    // Xử lý file ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imageTmpName = $image['tmp_name'];
        $imageSize = $image['size'];

        // Kiểm tra định dạng file
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            die("File không hợp lệ. Chỉ cho phép các định dạng jpg, jpeg, png, gif.");
        }

        // Kiểm tra kích thước file
        if ($imageSize > 2000000) {
            die("File kích thước vượt quá giới hạn (2MB).");
        }

        // Tạo tên file duy nhất
        $imageName = uniqid('', true) . '.' . $ext;

        // Đường dẫn lưu ảnh vào thư mục
        $imageDestination = '../img/home/' . $imageName; // Đường dẫn thực tế trong hệ thống tệp

        // Di chuyển file từ thư mục tạm thời đến thư mục lưu trữ
        if (move_uploaded_file($imageTmpName, $imageDestination)) {
            // Đường dẫn công khai để hiển thị ảnh
            $imageUrl = 'img/home/' . $imageName; // Đường dẫn sẽ được sử dụng trong HTML

            // Kiểm tra nếu các giá trị khác đã được cung cấp
            if (empty($name) || empty($description) || empty($price) || empty($category_id) || empty($brand_id)) {
                die("Thiếu thông tin sản phẩm.");
            }

            // Chèn dữ liệu vào cơ sở dữ liệu
            $sql = "INSERT INTO products (name, description, price, image_url, category_id, brand_id) 
                    VALUES ('$name', '$description', '$price', '$imageUrl', '$category_id', '$brand_id')";

            // Thực thi câu lệnh SQL
            if ($conn->query($sql) === TRUE) {
                // Hiển thị thông báo thành công và chuyển hướng về trang product.php
                echo "<script type='text/javascript'>
                        alert('Sản phẩm đã được thêm thành công!');
                        window.location.href = 'product.php';
                      </script>";
            } else {
                echo "Lỗi: " . $conn->error; // In lỗi nếu có vấn đề trong câu lệnh SQL
            }
        } else {
            echo "Không thể tải file lên.";
        }
    } else {
        echo "Không có file nào được chọn hoặc có lỗi xảy ra.";
    }
    echo "Đường dẫn ảnh: " . $imageUrl;

}

// Truy vấn bảng `brands`
$brandQuery = "SELECT * FROM brands";
$brands = $conn->query($brandQuery);

// Truy vấn bảng `product_categories`
$categoryQuery = "SELECT * FROM product_categories";
$categories = $conn->query($categoryQuery);
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
                            Product
                            <div class="page-title-subheading">
                                View, create, update, delete and manage.
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
                                <!-- Dropdown cho Brand -->
                                <div class="position-relative row form-group">
                                    <label for="brand_id" class="col-md-3 text-md-right col-form-label">Brand</label>
                                    <div class="col-md-9 col-xl-8">
                                        <select required name="brand_id" id="brand_id" class="form-control">
                                            <option value="">-- Brand --</option>
                                            <?php
                                            if ($brands->num_rows > 0) {
                                                while ($brand = $brands->fetch_assoc()) {
                                                    echo '<option value="' . $brand['brand_id'] . '">' . $brand['name'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No brands available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Dropdown cho Category -->
                                <div class="position-relative row form-group">
                                    <label for="product_id" class="col-md-3 text-md-right col-form-label">Category</label>
                                    <div class="col-md-9 col-xl-8">
                                        <select required name="category_id" id="category_id" class="form-control">
                                            <option value="">-- Category --</option>
                                            <?php
                                            if ($categories->num_rows > 0) {
                                                while ($category = $categories->fetch_assoc()) {
                                                    echo '<option value="' . $category['category_id'] . '">' . $category['name'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No categories available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="name" class="col-md-3 text-md-right col-form-label">Name</label>
                                    <div class="col-md-9 col-xl-8">
                                        <input required name="name" id="name" placeholder="Name" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="description" class="col-md-3 text-md-right col-form-label">Description</label>
                                    <div class="col-md-9 col-xl-8">
                                        <input required name="description" id="description" placeholder="Description" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="price" class="col-md-3 text-md-right col-form-label">Price</label>
                                    <div class="col-md-9 col-xl-8">
                                        <input required name="price" id="price" placeholder="Price" type="text" class="form-control">
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="image" class="col-md-3 text-md-right col-form-label">Image</label>
                                    <div class="col-md-9 col-xl-8">
                                        <input required name="image" id="image" type="file" class="form-control" accept="image/*">
                                    </div>
                                </div>

                                <div class="position-relative row form-group mb-1">
                                    <div class="col-md-9 col-xl-8 offset-md-2">
                                        <a href="product.php" class="border-0 btn btn-outline-danger mr-1">
                                            <span class="btn-icon-wrapper pr-1 opacity-8">
                                                <i class="fa fa-times fa-w-20"></i>
                                            </span>
                                            <span>Cancel</span>
                                        </a>

                                        <button type="submit" class="btn-shadow btn-hover-shine btn btn-primary">
                                            <span class="btn-icon-wrapper pr-2 opacity-8">
                                                <i class="fa fa-download fa-w-20"></i>
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
        <?php include "footer.php"; ?>
    </div>
</div>
