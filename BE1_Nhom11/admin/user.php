<?php
// Bao gồm các tệp cần thiết
include 'model/db.php';
include 'model/userController.php';

// Khởi tạo UserController
$userController = new UserController($conn);

// Kiểm tra xem có yêu cầu xóa không
if (isset($_POST['id'])) {
    $userController->deleteUser($_POST['id']);
}

// Số bản ghi trên mỗi trang
$records_per_page = 3;

// Xác định trang hiện tại
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// Xử lý tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Lấy giá trị tìm kiếm từ URL

// Truy vấn lấy danh sách người dùng với phân trang và tìm kiếm
$sql = "SELECT id, fullname, email, level FROM users WHERE fullname LIKE '%$search%' OR email LIKE '%$search%' LIMIT $offset, $records_per_page";
$result = $conn->query($sql);

// Truy vấn đếm tổng số bản ghi trong bảng users
$sql_total = "SELECT COUNT(id) AS total FROM users WHERE fullname LIKE '%$search%' OR email LIKE '%$search%'";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];

// Tính toán tổng số trang
$total_pages = ceil($total_records / $records_per_page);
?>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<div class="app-main">
    <div class="app-sidebar sidebar-shadow">
        <!-- Sidebar content -->
    </div>

    <div class="app-main__outer">
        <!-- Main -->
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                        </div>
                        <div>
                            User
                            <div class="page-title-subheading">
                                View, create, update, delete and manage.
                            </div>
                        </div>
                    </div>
                    <div class="page-title-actions">
                        <a href="./user-create.php" class="btn-shadow btn-hover-shine mr-3 btn btn-primary">
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
                                    <input type="search" name="search" id="search" value="<?php echo htmlspecialchars($search); ?>"
                                           placeholder="Search everything" class="form-control">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i>&nbsp;
                                            Search
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
                                        <th>Full Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Level</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Kiểm tra nếu có kết quả truy vấn
                                    if ($result->num_rows > 0) {
                                        // Duyệt qua từng bản ghi trong cơ sở dữ liệu và hiển thị chúng
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td class='text-center'>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['fullname'] . "</td>";
                                            echo "<td class='text-center'>" . $row['email'] . "</td>";
                                            echo "<td class='text-center'>" . $row['level'] . "</td>";
                                            echo "<td class='text-center'>
                                                    <a href='./user-show.php?id=" . $row['id'] . "' class='btn btn-hover-shine btn-outline-primary border-0 btn-sm'>Details</a>
                                                    <a href='./user-edit.php?id=" . $row['id'] . "' class='btn btn-outline-warning border-0 btn-sm'>Edit</a>
                                                    <form class='d-inline' action='' method='post'>
                                                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                                                        <button class='btn btn-hover-shine btn-outline-danger border-0 btn-sm' type='submit' onclick='return confirm(\"Do you really want to delete this item?\")'>Delete</button>
                                                    </form>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No users found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-block card-footer">
                            <!-- Phân trang -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php if ($current_page > 1) { ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php } ?>

                                    <?php if ($current_page < $total_pages) { ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main -->

        <?php include "footer.php"; ?>
    </div>
</div>
