<?php
include "header.php";
include "sidebar.php";
// Kiểm tra thông báo
$message = '';
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
} elseif (isset($_GET['error'])) {
    $message = '<span style="color: red;">' . htmlspecialchars($_GET['error']) . '</span>';
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_be1";

// Kết nối database
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý tìm kiếm
$search = '';
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
}

// Phân trang
$limit = 5; // Số bản ghi trên mỗi trang
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Lấy tổng số bản ghi
$total_sql = "SELECT COUNT(*) as total FROM orders WHERE customer_name LIKE '%$search%' OR customer_email LIKE '%$search%'";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_orders = $total_row['total'];
$total_pages = ceil($total_orders / $limit);

// Lấy dữ liệu đơn hàng với phân trang
$sql = "SELECT * FROM orders WHERE customer_name LIKE '%$search%' ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<div class="app-main">
    <div class="app-sidebar sidebar-shadow">
        <!-- Sidebar content -->
    </div>

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                        </div>
                        <div>
                            Order Management
                            <div class="page-title-subheading">
                                View, create, update, delete and manage orders.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($message): ?>
                <div class="alert alert-info">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <form>
                                <div class="input-group">
                                    <input type="search" name="search" id="search" placeholder="Search orders"
                                        class="form-control" value="<?php echo htmlspecialchars($search); ?>">
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
                                        <th>Customer / Products</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td class="text-center text-muted">#' . $row['id'] . '</td>';
                                            echo '<td>';
                                            echo '<div class="widget-content p-0">';
                                            echo '<div class="widget-content-wrapper">';
                                            echo '<div class="widget-content-left mr-3">';
                                            echo '<div class="widget-content-left">';
                                            echo '<img style="height: 60px;" src="assets/images/_default-product.jpg" alt="">';
                                            echo '</div></div>';
                                            echo '<div class="widget-content-left flex2">';
                                            echo '<div class="widget-heading">' . htmlspecialchars($row['customer_name']) . '</div>';
                                            echo '<div class ="widget-subheading opacity-7">Order ID: ' . htmlspecialchars($row['id']) . '</div>';
                                            echo '</div></div></div>';
                                            echo '</td>';
                                            echo '<td class="text-center">' . htmlspecialchars($row['customer_address']) . '</td>';
                                            echo '<td class="text-center">$' . number_format($row['total_amount'], 2) . '</td>';
                                            echo '<td class="text-center">';
                                            echo '<form action="update_order_status.php" method="post" style="display:inline;">';
                                            echo '<input type="hidden" name="order_id" value="' . $row['id'] . '">';
                                            echo '<select name="status" onchange="this.form.submit()">';
                                            echo '<option value="pending"' . ($row['status'] == 'pending' ? ' selected' : '') . '>Đang xử lý</option>';
                                            echo '<option value="completed"' . ($row['status'] == 'completed' ? ' selected' : '') . '>Đang giao</option>';
                                            echo '<option value="canceled"' . ($row['status'] == 'canceled' ? ' selected' : '') . '>Đã hoàn thành</option>';
                                            echo '</select>';
                                            echo '</form>';
                                            echo '</td>';
                                            echo '<td class="text-center">';
                                            echo '<a href="delete_order.php?id=' . $row['id'] . '" class="btn btn-hover-shine btn-outline-danger border-0 btn-sm" onclick="return confirm(\'Bạn có chắc chắn muốn xóa đơn hàng này không?\');">Xóa</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="6" class="text-center">No orders found.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-block card-footer">
                            <nav role="navigation" aria-label="Pagination Navigation"
                                class="flex items-center justify-between">
                                <div class="flex justify-between flex-1 sm:hidden">
                                    <?php if ($page > 1): ?>
                                        <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>"
                                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">«
                                            Previous</a>
                                    <?php else: ?>
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">«
                                            Previous</span>
                                    <?php endif; ?>
                                    <?php if ($page < $total_pages): ?>
                                        <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>"
                                            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">Next
                                            »</a>
                                    <?php endif; ?>
                                </div>
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700 leading-5">Showing <span
                                                class="font-medium"><?php echo $offset + 1; ?></span> to <span
                                                class="font-medium"><?php echo min($offset + $limit, $total_orders); ?></span>
                                            of <span class="font-medium"><?php echo $total_orders; ?></span> results</p>
                                    </div>
                                    <div>
                                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                                <?php if ($i == $page): ?>
                                                    <span
                                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5"><?php echo $i; ?></span>
                                                <?php else: ?>
                                                    <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"
                                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"><?php echo $i; ?></a>
                                                <?php endif; ?>
                                            <?php endfor; ?>
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