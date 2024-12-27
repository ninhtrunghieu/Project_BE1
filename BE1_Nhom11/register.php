<?php
ob_start();
session_start(); // Khởi tạo session
require "header.php";

// Kết nối cơ sở dữ liệu và xử lý form
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_be1";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Kiểm tra xem form đã được gửi hay chưa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $fullname = $_POST['fullname'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Kiểm tra xem mật khẩu có khớp không
    if ($password !== $confirmPassword) {
        $error = "Mật khẩu không khớp.";
    } else {
        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Kiểm tra xem tên người dùng đã tồn tại chưa
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $name]);
        if ($stmt->rowCount() > 0) {
            $error = "Tên người dùng đã được sử dụng.";
        }

        // Kiểm tra xem email đã tồn tại chưa
        if (!isset($error)) {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->rowCount() > 0) {
                $error = "Email đã được sử dụng.";
            }
        }

        if (!isset($error)) {
            // Thêm người dùng vào cơ sở dữ liệu
            $stmt = $pdo->prepare("INSERT INTO users (fullname, username, email, password, role) 
            VALUES (:fullname, :username, :email, :password, 'user')");
            $stmt->execute([
                'fullname' => $fullname,
                'username' => $name,
                'email' => $email,
                'password' => $hashedPassword
            ]);

            // Đăng nhập người dùng mới sau khi đăng ký thành công
            $_SESSION['fullname'] = $fullname;
            $_SESSION['username'] = $name;
            $_SESSION['role'] = 'user';
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!-- Form đăng ký -->
<section class="login_box_area section-margin">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <div class="hover">
                        <h4>Already have an account?</h4>
                        <p>There are advances being made in science and technology every day, and a good example of this is the</p>
                        <a class="button button-account" href="login.php">Login Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner register_form_inner">
                    <h3>Create an account</h3>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form class="row login_form" action="" method="POST" id="register_form">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Username" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="button button-register w-100">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

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
