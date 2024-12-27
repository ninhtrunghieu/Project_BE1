<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Thay bằng tên người dùng MySQL của bạn
$password = "";      // Thay bằng mật khẩu MySQL của bạn nếu có
$dbname = "db_be1";  // Thay bằng tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu có yêu cầu xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_product_id'])) {
    $product_id_to_delete = $_POST['delete_product_id'];

    // Lấy thông tin của sản phẩm cần xóa, bao gồm đường dẫn ảnh
    $deleteQuery = "SELECT image_url FROM products WHERE product_id = $product_id_to_delete";
    $deleteResult = $conn->query($deleteQuery);
    if ($deleteResult->num_rows > 0) {
        $row = $deleteResult->fetch_assoc();
        $image_url = $row['image_url'];

        // Nếu sản phẩm có ảnh, xóa ảnh khỏi thư mục
        if ($image_url && file_exists('../' . $image_url)) {
            unlink('../' . $image_url);  // Xóa ảnh
        }

        // Xóa sản phẩm khỏi cơ sở dữ liệu
        $deleteQuery = "DELETE FROM products WHERE product_id = $product_id_to_delete";
        if ($conn->query($deleteQuery) === TRUE) {
            echo "<script>alert('Sản phẩm đã được xóa thành công!'); window.location.href = 'product.php';</script>";
        } else {
            echo "Lỗi khi xóa sản phẩm: " . $conn->error;
        }
    } else {
        echo "Không tìm thấy sản phẩm để xóa.";
    }
}

// Lấy từ khóa tìm kiếm từ form
$search_query = isset($_GET['search']) ? $_GET['search'] : '';


// Phân trang: lấy số trang hiện tại
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Số trang hiện tại
$limit = 8;  // Số sản phẩm mỗi trang
$offset = ($page - 1) * $limit;  // Tính vị trí bắt đầu cho truy vấn SQL

// Truy vấn để lấy dữ liệu sản phẩm, nếu có từ khóa tìm kiếm thì tìm theo tên sản phẩm
$sql = "SELECT product_id, name, description, price, image_url, category_id, brand_id, created_at 
        FROM products 
        WHERE name LIKE '%$search_query%' OR description LIKE '%$search_query%' 
        ORDER BY created_at DESC 
        LIMIT $limit OFFSET $offset"; // Sắp xếp sản phẩm từ mới đến cũ
$result = $conn->query($sql);

// Truy vấn để đếm tổng số sản phẩm (để tính số trang) cho tìm kiếm
$total_sql = "SELECT COUNT(*) as total FROM products WHERE name LIKE '%$search_query%' OR description LIKE '%$search_query%'";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];  // Tổng số sản phẩm
$total_pages = ceil($total_products / $limit);  // Tính số trang
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

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

                <div class="page-title-actions">
                    <a href="./product-create.php" class="btn-shadow btn-hover-shine mr-3 btn btn-primary">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fa fa-plus fa-w-20"></i>
                        </span>
                        Create
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <form method="get">
                            <div class="input-group">
                                <input type="search" name="search" id="search" value="<?= htmlspecialchars($search_query) ?>" placeholder="Search everything" class="form-control">
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>&nbsp; Search
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Name / Brand</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Featured</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    // Duyệt qua từng sản phẩm
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td class='text-center text-muted'>#" . $row['product_id'] . "</td>";
                                        echo "<td>";
                                        echo "<div class='widget-content p-0'>";
                                        echo "<div class='widget-content-wrapper'>";
                                        echo "<div class='widget-content-left mr-3'>";
                                        echo "<div class='widget-content-left'>";

                                        // Kiểm tra nếu đường dẫn ảnh hợp lệ
                                        if (isset($row['image_url']) && !empty($row['image_url'])) {
                                            // Thêm đường dẫn ../img/home/ vào trước đường dẫn ảnh từ cơ sở dữ liệu
                                            $image_path = "../" . $row['image_url'];
                                            if (file_exists($image_path)) {
                                                echo "<img style='height: 60px;' src='" . $image_path . "' alt='Product Image'>";
                                            } else {
                                                echo "<img style='height: 60px;' src='../img/home/default.jpg' alt='No Image Available'>";
                                            }
                                        } else {
                                            echo "<img style='height: 60px;' src='../img/home/default.jpg' alt='No Image Available'>";
                                        }

                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='widget-content-left flex2'>";
                                        echo "<div class='widget-heading'>" . $row['name'] . "</div>";
                                        echo "<div class='widget-subheading opacity-7'>" . $row['description'] . "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "<td class='text-center'>$" . $row['price'] . "</td>";
                                        echo "<td class='text-center'>25</td>";  // Bạn có thể thay bằng số lượng thực tế
                                        echo "<td class='text-center'>";
                                        echo "<div class='badge badge-success mt-2'>True</div>";  // Bạn có thể thay logic nếu có trường Featured
                                        echo "</td>";
                                        echo "<td class='text-center'>";
                                        echo "<a href='./product-edit.php?product_id=" . $row['product_id'] . "' class='btn btn-outline-warning border-0 btn-sm'>Edit</a>";
                                        echo "<form class='d-inline' action='' method='post'>";
                                        echo "<input type='hidden' name='delete_product_id' value='" . $row['product_id'] . "'>";
                                        echo "<button class='btn btn-hover-shine btn-outline-danger border-0 btn-sm' type='submit' onclick=\"return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')\">Delete</button>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No products found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Phân trang -->
                    <div class="d-block card-footer">
                        <nav role="navigation" aria-label="Pagination Navigation"
                            class="flex items-center justify-between">
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700 leading-5">
                                        Showing
                                        <span class="font-medium"><?= (($page - 1) * $limit) + 1 ?></span>
                                        to
                                        <span class="font-medium"><?= min($page * $limit, $total_products) ?></span>
                                        of
                                        <span class="font-medium"><?= $total_products ?></span>
                                        results
                                    </p>
                                </div>

                                <div>
                                    <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                        <!-- Previous Pagination Button -->
                                        <a href="?page=<?= max($page - 1, 1) ?><?php if ($search_query) echo "&search=" . urlencode($search_query); ?>"
                                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5">«</a>
                                        <!-- Current Page -->
                                        <span aria-current="page">
                                            <span
                                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5"><?= $page ?></span>
                                        </span>
                                        <!-- Next Pagination Button -->
                                        <a href="?page=<?= min($page + 1, $total_pages) ?><?php if ($search_query) echo "&search=" . urlencode($search_query); ?>"
                                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5">»</a>
                                    </span>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>

<?php
// Đóng kết nối
$conn->close();
?>
