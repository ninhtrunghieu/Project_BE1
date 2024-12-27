<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "db_be1");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy từ khóa tìm kiếm nếu có
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Xử lý xóa nếu có yêu cầu
if (isset($_POST['delete'])) {
    // Lấy brand_id từ form
    $brand_id = $_POST['brand_id'];

    // Câu lệnh SQL để xóa brand
    $sql = "DELETE FROM brands WHERE brand_id = ?";

    // Sử dụng prepared statement để tránh SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $brand_id);

    // Thực thi câu lệnh xóa
    if ($stmt->execute()) {
        echo "<script>alert('Brand deleted successfully!'); window.location='brand.php';</script>";
    } else {
        echo "<script>alert('Error deleting brand: " . $conn->error . "');</script>";
    }

    // Đóng statement
    $stmt->close();
}

// Xử lý phân trang
$limit = 5;  // Số bản ghi trên mỗi trang
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Trang hiện tại
$offset = ($page - 1) * $limit;  // Vị trí bắt đầu

// Query để lấy tổng số bản ghi với điều kiện tìm kiếm
$where_clause = '';
if ($search) {
    $where_clause = "WHERE name LIKE ?";
}

// Cập nhật câu lệnh SQL để lấy tổng số bản ghi
$sql = "SELECT COUNT(*) AS total FROM brands $where_clause";
$stmt = $conn->prepare($sql);

if ($search) {
    $search_term = "%$search%";
    $stmt->bind_param("s", $search_term);
}

$stmt->execute();
$total_result = $stmt->get_result();  // Lấy kết quả của câu lệnh truy vấn tổng số

// Kiểm tra kết quả và tính số bản ghi
if ($total_result) {
    $total_rows = $total_result->fetch_assoc()['total'];
    $total_pages = ceil($total_rows / $limit); // Tính số trang
} else {
    $total_rows = 0;
    $total_pages = 1;
}

// Query để lấy danh sách các brand với phân trang và tìm kiếm
$sql = "SELECT brand_id, name, product_count FROM brands $where_clause LIMIT ?, ?";
$stmt = $conn->prepare($sql);

if ($search) {
    $stmt->bind_param("ssi", $search_term, $offset, $limit);
} else {
    $stmt->bind_param("ii", $offset, $limit);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<!-- Các phần HTML còn lại không thay đổi -->


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
                            Brand
                            <div class="page-title-subheading">
                                View, create, update, delete and manage.
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                        <a href="./brand-create.php" class="btn-shadow btn-hover-shine mr-3 btn btn-primary">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-plus fa-w-20"></i>
                            </span>
                            Add New Brand
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <form>
                                <div class="input-group">
                                    <input type="search" name="search" id="search" placeholder="Search everything"
                                        class="form-control">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i>&nbsp;Search
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
                                        <th>Name</th>
                                        <th class="text-center">Product Count</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td class='text-center'>" . $row['brand_id'] . "</td>";
                                            echo "<td>" . $row['name'] . "</td>";
                                            echo "<td class='text-center'>" . $row['product_count'] . "</td>";
                                            echo "<td class='text-center'>
                                                        <a href='./brand-edit.php?id=" . $row['brand_id'] . "' class='btn btn-outline-warning border-0 btn-sm' data-toggle='tooltip' title='Edit'>
                                                            <i class='fa fa-edit'></i>
                                                        </a>
                                                        <form class='d-inline' action='' method='post'>
                                                            <input type='hidden' name='brand_id' value='" . $row['brand_id'] . "' />
                                                            <button class='btn btn-hover-shine btn-outline-danger border-0 btn-sm' type='submit' name='delete' data-toggle='tooltip' title='Delete' onclick=\"return confirm('Do you really want to delete this item?')\">
                                                                <i class='fa fa-trash'></i>
                                                            </button>
                                                        </form>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>No brands found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-block card-footer">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-start">
                                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?>"
                                            aria-label="Previous">Previous
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <li class="page-item <?php echo $page == $total_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo min($total_pages, $page + 1); ?>"
                                            aria-label="Next">Next
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
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