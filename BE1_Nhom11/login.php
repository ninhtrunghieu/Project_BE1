<?php

ob_start();
session_start();
require "header.php";
?>
<?php
// Kết nối cơ sở dữ liệu
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

// Xử lý form đăng nhập
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra thông tin người dùng
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && md5($password, $user['password'])) {
        // Lưu thông tin vào session
        $_SESSION['user_id'] = $user['id'];
		$_SESSION['full_name'] = $user['fullname'];  // Lưu tên đầy đủ vào session
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Điều hướng theo phân quyền
        if ($user['role'] === 'admin') {
            header("Location: ./admin");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Sai tên đăng nhập hoặc mật khẩu.";
    }
}

?>

  
  <!-- ================ start banner area ================= -->	
  <section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Login / Register</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login/Register</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
	<!-- ================ end banner area ================= -->
  
  <!--================Login Box Area =================-->
  <section class="login_box_area section-margin">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <div class="hover">
                        <h4>New to our website?</h4>
                        <p>There are advances being made in science and technology everyday, and a good example of this is the</p>
                        <a class="button button-account" href="register.php">Create an Account</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Log in to enter</h3>
                    <form class="row login_form" method="POST" action="" id="contactForm">
                        <?php if (!empty($error)): ?>
                            <div class="col-md-12 form-group">
                                <p style="color: red;"><?php echo $error; ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="f-option2" name="selector">
                                <label for="f-option2">Keep me logged in</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="button button-login w-100">Log In</button>
                            <a href="#">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
	<!--================End Login Box Area =================-->







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