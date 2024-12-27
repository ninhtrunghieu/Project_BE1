<?php
session_start(); // Đặt session_start() ở đầu file, trước bất kỳ phần HTML nào

include "header.php";
include "sidebar.php";

// Kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'db_be1';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Số lượng bản ghi mỗi trang
$records_per_page = 3;

// Lấy số trang hiện tại từ URL, mặc định là trang 1 nếu không có
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Kiểm tra xem có từ khóa tìm kiếm không
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Tạo câu lệnh SQL để đếm tổng số bản ghi
$totalQuery = "SELECT COUNT(*) FROM product_categories WHERE name LIKE :search";
$totalStmt = $pdo->prepare($totalQuery);
$totalStmt->bindValue(':search', '%' . $search . '%');
$totalStmt->execute();
$total_records = $totalStmt->fetchColumn();

// Tính toán số trang
$total_pages = ceil($total_records / $records_per_page);

// Lấy dữ liệu danh mục với phân trang và tìm kiếm, sắp xếp theo ngày
$query = "SELECT category_id, name, total_products FROM product_categories 
          WHERE name LIKE :search 
          ORDER BY created_at DESC 
          LIMIT :offset, :records_per_page";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':search', '%' . $search . '%');
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Xử lý yêu cầu xóa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $category_id = $_POST['delete_id'];

    // Câu lệnh SQL để xóa category theo ID
    $deleteQuery = "DELETE FROM product_categories WHERE category_id = :category_id";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

    if ($deleteStmt->execute()) {
        // Thêm thông báo thành công vào session
        $_SESSION['message'] = "Category deleted successfully.";
        // Chuyển hướng lại trang danh sách category sau khi xóa thành công
        header('Location: category.php');
        exit; // Đảm bảo không có code nào sau header()
    } else {
        $_SESSION['error'] = "Error deleting category.";
    }
}
?>

<div class="app-main">
    <div class="app-sidebar sidebar-shadow">
        <!-- Sidebar content here -->
    </div>

    <div class="app-main__outer">
        <!-- Main content here -->
        <div class="app-main__inner">
            <!-- Title Section -->
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                        </div>
                        <div>
                            Category
                            <div class="page-title-subheading">
                                View, create, update, delete and manage.
                            </div>
                        </div>
                    </div>

                    <div class="page-title-actions">
                        <a href="./category-create.php" class="btn-shadow btn-hover-shine mr-3 btn btn-primary">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-plus fa-w-20"></i>
                            </span>
                            Create
                        </a>
                    </div>
                </div>
            </div>

            <!-- Hiển thị thông báo nếu có -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['message']; ?></div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Table Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <form method="get" action="">
                                <div class="input-group">
                                    <input type="search" name="search" id="search" placeholder="Search everything"
                                        class="form-control" value="<?php echo htmlspecialchars($search); ?>">
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
                                        <th>Name</th>
                                        <th class="text-center">Total Products</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <td class="text-center text-muted">
                                                <?php echo htmlspecialchars($category['category_id']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($category['name']); ?></td>
                                            <td class="text-center">
                                                <?php echo htmlspecialchars($category['total_products']); ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="./category-edit.php?id=<?php echo $category['category_id']; ?>"
                                                    data-toggle="tooltip" title="Edit" data-placement="bottom"
                                                    class="btn btn-outline-warning border-0 btn-sm">
                                                    <span class="btn-icon-wrapper opacity-8">
                                                        <i class="fa fa-edit fa-w-20"></i>
                                                    </span>
                                                </a>
                                                <form class="d-inline" action="" method="post">
                                                    <!-- Hidden input để gửi ID category cần xóa -->
                                                    <input type="hidden" name="delete_id"
                                                        value="<?php echo $category['category_id']; ?>">
                                                    <button class="btn btn-hover-shine btn-outline-danger border-0 btn-sm"
                                                        type="submit" data-toggle="tooltip" title="Delete"
                                                        data-placement="bottom"
                                                        onclick="return confirm('Do you really want to delete this item?')">
                                                        <span class="btn-icon-wrapper opacity-8">
                                                            <i class="fa fa-trash fa-w-20"></i>
                                                        </span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-block card-footer">
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                                <ul class="pagination">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Previous</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Next</a>
                                        </li>
                                    <?php endif; ?>
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
