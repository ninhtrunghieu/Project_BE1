<?php
include "header.php";
include "sidebar.php";

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "db_be1");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý xóa khi có POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_sql = "DELETE FROM product_details WHERE detail_id = $delete_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Detail deleted successfully!'); window.location.href='details.php';</script>";
    } else {
        echo "<script>alert('Error deleting detail: " . $conn->error . "');</script>";
    }
}

// Phân trang
$limit = 5;  // Số sản phẩm mỗi trang
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  // Lấy số trang từ URL, mặc định là 1
$offset = ($page - 1) * $limit;  // Tính toán offset

// Lấy tổng số sản phẩm
$sql_count = "SELECT COUNT(*) AS total FROM product_details";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total'];  // Tổng số sản phẩm
$total_pages = ceil($total_records / $limit);  // Tính số trang

// Lấy từ khóa tìm kiếm từ form
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Truy vấn dữ liệu từ bảng product_details với phân trang và tìm kiếm
$sql = "SELECT detail_id, product_id, description, attribute_name, attribute_value, url_image 
        FROM product_details 
        WHERE description LIKE '%$search%' OR attribute_name LIKE '%$search%' OR attribute_value LIKE '%$search%'
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
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
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <form method="get">
                                <div class="input-group">
                                    <input type="search" name="search" id="search" placeholder="Search everything"
                                        class="form-control" value="<?php echo htmlspecialchars($search); ?>">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i>&nbsp;Search
                                        </button>
                                    </span>
                                </div>
                            </form>

                            <div class="btn-actions-pane-right">
                                <div role="group" class="btn-group-sm btn-group">
                                    <button class="btn btn-focus">This week</button>
                                    <button class="active btn btn-focus">Anytime</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Detail ID</th>
                                        <th class="text-center">Product ID</th>
                                        <th>Description</th>
                                        <th>Attribute Name</th>
                                        <th>Attribute Value</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Kiểm tra dữ liệu và hiển thị
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td class='text-center'>" . $row['detail_id'] . "</td>";
                                            echo "<td class='text-center'>" . $row['product_id'] . "</td>";
                                            echo "<td>" . $row['description'] . "</td>";
                                            echo "<td>" . $row['attribute_name'] . "</td>";
                                            echo "<td>" . $row['attribute_value'] . "</td>";
                                            echo "<td class='text-center'>";
                                            if (!empty($row['url_image'])) {
                                                echo "<img style='height: 60px;' src='" . $row['url_image'] . "' alt='Image'>";
                                            } else {
                                                echo "<span class='badge badge-secondary'>No Image</span>";
                                            }
                                            echo "</td>";
                                            echo "<td class='text-center'>
                                                    <a href='./detail-edit.php?id=" . $row['detail_id'] . "' class='btn btn-outline-warning border-0 btn-sm' data-toggle='tooltip' title='Edit'>
                                                        <i class='fa fa-edit'></i>
                                                    </a>
                                                    <form class='d-inline' action='./details.php' method='post'>
                                                        <input type='hidden' name='delete_id' value='" . $row['detail_id'] . "'>
                                                        <button class='btn btn-hover-shine btn-outline-danger border-0 btn-sm' type='submit' data-toggle='tooltip' title='Delete' onclick=\"return confirm('Do you really want to delete this item?')\">
                                                            <i class='fa fa-trash'></i>
                                                        </button>
                                                    </form>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>No details found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <div class="card-footer">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo ($page - 1); ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                                    </li>

                                    <?php
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'>
                                                <a class='page-link' href='?page=$i&search=" . urlencode($search) . "'>$i</a>
                                              </li>";
                                    }
                                    ?>

                                    <li class="page-item <?php echo ($page == $total_pages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo ($page + 1); ?>&search=<?php echo urlencode($search); ?>">Next</a>
                                    </li>
                                </ul>
                            </nav>
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
