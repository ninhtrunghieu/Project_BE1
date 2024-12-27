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

// Kiểm tra nếu người dùng đã thêm sản phẩm vào giỏ hàng
$sql = "SELECT * FROM cart WHERE user_id = 1"; // Thay user_id bằng giá trị thực tế nếu dùng hệ thống đăng nhập
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán.";
    exit();
}

// Khởi tạo biến tổng tiền
$total_amount = 0;

// Tính tổng tiền từ giỏ hàng
while ($row = $result->fetch_assoc()) {
    $total_amount += $row['product_price'] * $row['quantity']; // Tính tổng tiền
}

// Xử lý thông tin thanh toán
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $customer_email = $conn->real_escape_string($_POST['customer_email']);
    $customer_address = $conn->real_escape_string($_POST['diachi']); // Đảm bảo tên trường khớp với biểu mẫu

    // Lưu thông tin đơn hàng vào bảng orders
    $sql = "INSERT INTO orders (user_id, customer_name, customer_email, customer_address, total_amount) 
            VALUES (1, '$customer_name', '$customer_email', '$customer_address', $total_amount)";

    if ($conn->query($sql) === TRUE) {
        // Xóa giỏ hàng sau khi thanh toán thành công
        $conn->query("DELETE FROM cart WHERE user_id = 1");
        echo "Thanh toán thành công! Cảm ơn bạn đã mua hàng.";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- ================ start banner area ================= -->	
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Product Checkout</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ================ end banner area ================= -->

<!--================Checkout Area =================-->
<section class="checkout_area section-margin--small">
    <div class="container">
        <div class="returning_customer">
            <div class="check_title">
                <h2>Khách hàng quay lại?<a href="#">Bấm vào đây để đăng nhập</a></h2>
            </div>
            <p>Nếu bạn đã mua hàng với chúng tôi trước đây, vui lòng nhập thông tin chi tiết của bạn vào các ô bên dưới. Nếu bạn là người mới
            khách hàng, vui lòng chuyển sang phần Thanh toán & Vận chuyển.</p>
            <form class="row contact_form" action="#" method="post" novalidate="novalidate">
                <div class="col-md-6 form-group p_star">
                    <input type="text" class="form-control" placeholder="Username or Email*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Username or Email*'" id="name" name="name">
                </div>
                <div class="col-md-6 form-group p_star">
                    <input type="password" class="form-control" placeholder="Password*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Password*'" ```php
id="password" name="password">
                </div>
                <div class="col-md-12 form-group">
                    <button type="submit" value="submit" class ="button button-login">login</button>
                    <div class="cre at_account">
                        <input type="checkbox" id="f-option" name="selector">
                        <label for="f-option">Remember me</label>
                    </div>
                    <a class="lost_pass" href="#">Quên mật khẩu?</a>
                </div>
            </form>
        </div>
        <div class="cupon_area">
            <div class="check_title">
                <h2>Có phiếu giảm giá? <a href="#">Bấm vào đây để nhập mã của bạn</a></h2>
            </div>
            <input type="text" placeholder="Enter coupon code">
            <a class="button button-coupon" href="#">Áp dụng phiếu giảm giá</a>
        </div>
        <div class="billing_details">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Chi tiết thanh toán</h3>
                    <form class="row contact_form" action="" method="post" novalidate="novalidate">
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="add1" name="customer_name" placeholder="Họ và Tên" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="number" name="phone" placeholder="Phone number" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="email" class="form-control" id="email" name="customer_email" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="add1" name="diachi" placeholder="Địa Chỉ" required>
                        </div>
                        <div class="col-md-12 form-group mb-0">
                            <div class="creat_account">
                                <h3>Chi tiết vận chuyển</h3>
                                <input type="checkbox" id="f-option3" name="different_address">
                                <label for="f-option3">Gửi đến một địa chỉ khác?</label>
                            </div>
                            <textarea class="form-control" name="order_notes" id="message" rows="1" placeholder="Order Notes"></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="button button-paypal">Tiếp tục với Paypal</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Đơn hàng của bạn</h2>
                        <ul class="list">
                            <li><a href="#"><h4>Sản phẩm <span>Tổng cộng</span></h4></a></li>
                            <?php
                            // Hiển thị thông tin sản phẩm trong giỏ hàng
                            while ($row = $result->fetch_assoc()) {
                                $total_amount += $row['product_price'] * $row['quantity']; // Tính tổng tiền
                                echo '<li><a href="#">' . $row['product_name'] . ' <span class="middle">x ' . $row['quantity'] . '</span> <span class="last">$' . ($row['product_price'] * $row['quantity']) . '</span></a></li>';
                            }
                            ?>
                        </ul>
                        <ul class="list list_2">
                            <li><a href="#">Tổng Tiền<span>$<?php echo number_format($total_amount, 2); ?></span></a></li>
                            <li><a href="#">Vận chuyển <span>Tỷ giá cố định: $2</span></a></li>
                            <li><a href="#">Tổng cộng <span>$<?php echo number_format($total_amount + 2, 2); ?></span></a></li>
                        </ul>
                        <div class="payment_item active">
                            <div class="radion_btn">
                                <input type="radio" id="f-option6" name="payment_method" value="paypal" checked>
                                <label for="f-option6">Paypal </label>
                                <img src="img/product/card.jpg" alt="">
                                <div class="check"></div>
                            </div>
                            <p>Thanh toán qua PayPal; bạn có thể thanh toán bằng thẻ tín dụng nếu bạn không có tài khoản PayPal.</p>
                        </div>
                        <div class="creat_account">
                            <input type="checkbox" id="f-option4" name="terms_conditions" required>
                            <label for="f-option4">Tôi đã đọc và chấp nhận</label>
                            <a href="#">điều khoản và điều kiện*</a>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="button button-paypal">Tiếp tục với Paypal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Checkout Area =================-->

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