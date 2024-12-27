<?php
ob_start();
session_start();
include "header.php";
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

// Kiểm tra nếu dữ liệu form được gửi
if (isset($_POST['action'])) {
    // Thêm sản phẩm vào giỏ hàng
    if ($_POST['action'] == 'add_to_cart') {
        if (!isset($_SESSION['last_post_id']) || $_SESSION['last_post_id'] !== md5(json_encode($_POST))) {
            $product_id = intval($_POST['product_id']);
            $product_name = $conn->real_escape_string($_POST['product_name']);
            $product_price = floatval($_POST['product_price']);
            $quantity = intval($_POST['qty']);

            // Thêm sản phẩm vào bảng `cart`
            $sql = "INSERT INTO cart (user_id, product_id, product_name, product_price, quantity) 
                    VALUES (1, $product_id, '$product_name', $product_price, $quantity)";
            if ($conn->query($sql) === TRUE) {
                echo "Sản phẩm đã được thêm vào giỏ hàng.";
            } else {
                echo "Lỗi: " . $sql . "<br>" . $conn->error;
            }

            // Lưu trạng thái xử lý form
            $_SESSION['last_post_id'] = md5(json_encode($_POST));
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    if ($_POST['action'] == 'remove_from_cart') {
        $cart_id = intval($_POST['cart_id']);

        // Xóa sản phẩm khỏi bảng `cart`
        $sql = "DELETE FROM cart WHERE id = $cart_id AND user_id = 1"; // Thay user_id bằng giá trị thực tế nếu dùng hệ thống đăng nhập
        if ($conn->query($sql) === TRUE) {
            echo "Sản phẩm đã được xóa khỏi giỏ hàng.";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!-- ================ start banner area ================= -->	
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Giỏ hàng</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ================ end banner area ================= -->

<!--================Cart Area =================-->
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng cộng</th>
                            <th scope="col">Hành động</th> <!-- Thêm cột Hành động -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $total = 0; // Tổng tiền
                        $sql = "SELECT * FROM cart WHERE user_id = 1"; // Thay user_id bằng giá trị thực tế nếu dùng hệ thống đăng nhập
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0):
                            while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <p><?= htmlspecialchars($row['product_name']); ?></p>
                                    </td>
                                    <td>
                                        <h5>$<?= number_format($row['product_price'], 2); ?></h5>
                                    </td>
                                    <td>
                                        <h5><?= intval($row ['quantity']); ?></h5>
                                    </td>
                                    <td>
                                        <h5>$<?= number_format($row['product_price'] * $row['quantity'], 2); ?></h5>
                                    </td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="action" value="remove_from_cart">
                                            <input type="hidden" name="cart_id" value="<?= $row['id']; ?>"> <!-- Giả sử bạn có cột id trong bảng cart -->
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                                $total += $row['product_price'] * $row['quantity']; // Tính tổng tiền
                            endwhile;
                        else: ?>
                            <tr>
                                <td colspan="5">Giỏ hàng trống</td>
                            </tr>
                        <?php endif; ?>
                           
                        <tr class="bottom_button">
                            <td>
                                <a class="button" href="#">Cập nhật giỏ hàng</a>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="cupon_text d-flex align-items-center">
                                    <input type="text" placeholder="Mã giảm giá">
                                    <a class="primary-btn" href="#" style="padding: 2px 15px 5px 15px">Áp dụng</a>
                                    <a class="button" href="#">Có mã giảm giá?</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <h5>Tổng phụ</h5>
                            </td>
                            <td>
                                <h5>$<?= number_format($total, 2); ?></h5>
                            </td>
                        </tr>
                        <tr class="shipping_area">
                            <td class="d-none d-md-block"></td>
                            <td></td>
                            <td>
                                <h5>Vận chuyển</h5>
                            </td>
                            <td>
                                <div class="shipping_box">
                                    <ul class="list">
                                        <li><a href="#">Tỷ giá cố định: $5.00</a></li>
                                        <li><a href="#">Miễn phí vận chuyển</a></li>
                                        <li><a href="#">Tỷ giá cố định: $10.00</a></li>
                                        <li class="active"><a href="#">Giao hàng tận nơi: $2.00</a></li>
                                    </ul>
                                    <h6>Tính toán vận chuyển<i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                    <select class="shipping_select">
                                        <option value="1">VIETNAM</option>
                                        <option value="2">USA</option>
                                        <option value="4">JAPAN</option>
                                    </select>
                                    <select class="shipping_select">
                                        <option value="1">Chọn một thành phố</option>
                                        <option value="2">Chọn một thành phố</option>
                                        <option value="4">Chọn một thành phố</option>
                                    </select>
                                    <input type="text" placeholder="Mã bưu điện">
                                    <a class="gray_btn" href="#">Cập nhật chi tiết</a>
                                </div>
                            </td>
                        </tr>
                        <tr class="out_button_area">
                            <td class="d-none-l"></td>
                            <td class=""></td>
                            <td></td>
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="gray_btn" href="#" style="padding: 0px 30px;">Tiếp tục mua sắm</a>
                                    <a class="primary-btn ml-2" href="checkout.php">Tiến hành thanh toán</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!--================End Cart Area =================-->

<script src="vendors/jquery/jquery-3.2.1.min.js"></script>
<script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>
<script src="vendors/skrollr.min.js"></script>
<script src="vendors/owl-carousel/owl.carousel.min.js"></script>
<script src="vendors/nice-select/jquery.nice-select.min.js"></script>
<script src="vendors/jquery.ajaxchimp.min.js"></script>
<script src="vendors/mail-script.js"></script>
<script src="js/main.js"></script>

<?php
require "footer.php";
?>