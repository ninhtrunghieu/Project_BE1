<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
$isLoggedIn = isset($_SESSION['user_id']); // Giả sử bạn lưu ID người dùng trong session khi đăng nhập
$username = $isLoggedIn ? $_SESSION['full_name'] : null; // Lấy tên người dùng từ session nếu đã đăng nhập
?>
<?php
require "config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aroma Shop - Home</title>
  <link rel="icon" href="img/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="vendors/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="vendors/nice-select/nice-select.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Phân trang */
    .pagination {
      display: flex;
      justify-content: flex-end;
      /* Căn phải */
      width: 100%;
      /* Đảm bảo chiều rộng của phần tử chứa phân trang */
      margin-top: 30px;
      padding-right: 20px;
      /* Thêm khoảng cách giữa phân trang và rìa phải */
    }

    .pagination a,
    .pagination .current-page {
      padding: 8px 16px;
      margin: 0 5px;
      text-decoration: none;
      border: 1px solid #ddd;
      color: #333;
      background-color: #f9f9f9;
      border-radius: 5px;
      transition: background-color 0.3s, color 0.3s;
    }

    .pagination a:hover {
      background-color: #007bff;
      color: #fff;
    }

    .pagination .current-page {
      background-color: #007bff;
      color: white;
      font-weight: bold;
    }

    .pagination a:disabled {
      background-color: #ddd;
      color: #aaa;
      cursor: not-allowed;
    }

    /* Nút trước và sau bị làm mờ khi không thể bấm */
    .pagination a[disabled] {
      pointer-events: none;
      opacity: 0.5;
    }

    /* Cấu hình mặc định cho phần menu dropdown */
    .nav-item {
      position: relative;
    }

    .nav-item .dropdown-menu {
      display: none;
      opacity: 0;
      visibility: hidden;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 5px 0;
      /* Giảm khoảng cách padding để bảng nhỏ lại */
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      width: 150px;
      /* Giảm chiều rộng của bảng */
      transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
      text-align: center;
      /* Căn giữa chữ trong bảng */
    }

    /* Hiển thị dropdown khi hover vào icon người dùng */
    .nav-item:hover .dropdown-menu {
      display: block;
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    /* Cấu hình cho các mục trong dropdown */
    .nav-item .dropdown-menu li {
      list-style: none;
      text-align: center;
      /* Căn giữa các mục trong dropdown */
      margin: 0;
      /* Loại bỏ khoảng cách mặc định */
    }

    /* Cấu hình cho các liên kết trong dropdown */
    .nav-item .dropdown-menu li a {
      display: block;
      padding: 8px 10px;
      /* Giảm khoảng cách padding giữa các mục */
      text-decoration: none;
      color: #333;
      font-size: 14px;
      transition: background-color 0.3s ease, color 0.3s ease;
      border-radius: 4px;
      text-align: center;
      /* Căn giữa chữ trong các mục của dropdown */
    }

    /* Hiệu ứng hover cho các mục trong dropdown */
    .nav-item .dropdown-menu li a:hover {
      background-color: #f1f1f1;
      color: #007bff;
    }

    /* Ẩn dropdown khi không hover */
    .nav-item .dropdown-menu {
      display: none;
    }

    /* Hiển thị dropdown khi hover vào icon */
    .nav-item:hover .dropdown-menu {
      display: block;
    }

    /* Thêm hiệu ứng hover cho icon */
    .nav-item .nav-link i {
      margin-right: 5px;
    }


    /* Cấu hình để căn giữa navbar */
    .main_menu {
      display: flex;
      justify-content: center;
      /* Căn giữa navbar trong container */
      align-items: center;
      /* Căn giữa theo chiều dọc */
      width: 100%;
      /* Đảm bảo navbar chiếm hết chiều rộng của màn hình */
    }

    /* Cấu hình navbar để nó căn giữa trong .main_menu */
    .navbar {
      display: flex;
      justify-content: center;
      /* Căn giữa các mục trong navbar */
      width: 100%;
      /* Đảm bảo navbar chiếm hết chiều rộng của container */
    }

    /* Cấu hình cho menu_nav để các mục trong navbar không chiếm quá nhiều không gian */
    /* Cấu hình cho phần navbar chứa các icon */
    .nav-shop {
      display: flex;
      justify-content: center;
      /* Căn giữa các icon trong phần navbar */
      align-items: center;
      /* Căn giữa theo chiều dọc */
      gap: 5px;
      /* Điều chỉnh khoảng cách giữa các icon */
    }

    /* Cấu hình cho các icon */
    .nav-item button {
      margin: 0;
      /* Loại bỏ margin ngoài button */
      padding: 5px;
      /* Thêm padding nhỏ để icon không bị quá sát nhau */
      border: none;
      /* Loại bỏ viền của button */
      background: transparent;
      /* Loại bỏ nền của button */
    }

    /* Cấu hình cho icon người dùng */
    .nav-item i {
      margin: 0;
      /* Loại bỏ margin của icon */
      font-size: 20px;
      /* Đảm bảo kích thước icon đồng đều */
    }

    /* Đảm bảo khoảng cách giữa icon tìm kiếm, giỏ hàng và người dùng không quá xa */
    .nav-shop__circle {
      position: absolute;
      top: -5px;
      right: -5px;
      background-color: red;
      color: white;
      font-size: 12px;
      padding: 2px 6px;
      border-radius: 50%;
      font-weight: bold;
    }

    /* Cấu hình cho form tìm kiếm */
    .search-form {
      display: flex;
      align-items: center;
      position: relative;
    }

    .search-input {
      padding: 6px;
      font-size: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      width: 150px;
      margin-right: 10px;
    }

    .search-input:focus {
      outline: none;
      border-color: #007bff;
    }

    .search-form button {
      background-color: transparent;
      border: none;
      cursor: pointer;
    }

    .search-form button i {
      font-size: 18px;
      color: #007bff;
    }

    /* Container cho phân trang */
    .pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 30px;
    }

    /* Mỗi nút phân trang */
    .pagination a {
      padding: 10px 15px;
      margin: 0 5px;
      border: 1px solid #ddd;
      border-radius: 5px;
      color: #555;
      text-decoration: none;
      font-size: 16px;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Nút phân trang khi được hover */
    .pagination a:hover {
      background-color: #f4f4f4;
      color: #007bff;
    }

    /* Nút phân trang đang được chọn */
    .pagination .active {
      background-color: #007bff;
      color: white;
      font-weight: bold;
      border-color: #007bff;
    }

    /* Nút Next và Previous */
    .pagination .prev,
    .pagination .next {
      font-size: 18px;
      font-weight: bold;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border-radius: 5px;
      border: none;
      margin: 0 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    /* Hover hiệu ứng cho nút Next và Previous */
    .pagination .prev:hover,
    .pagination .next:hover {
      background-color: #0056b3;
    }

    /* Tránh hiển thị nút next và previous nếu không có trang để di chuyển */
    .pagination .disabled {
      pointer-events: none;
      opacity: 0.5;
    }
  </style>
</head>

<body>
  <!--================ Start Header Menu Area =================-->
  <header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand logo_h" href="index.php"><img src="img/logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <li class="nav-item active"><a class="nav-link" href="index.php">Trang Chủ</a></li>
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Shop</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="category.php">Danh mục Shop</a></li>
                </ul>
              </li>
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Blog</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                  <li class="nav-item"><a class="nav-link" href="single-blog.php">Chi tiết blog</a></li>
                </ul>
              </li>
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Trang</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                  <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                  <li class="nav-item"><a class="nav-link" href="tracking-order.php">Theo dõi</a></li>
                </ul>
              </li>
              <li class="nav-item"><a class="nav-link" href="contact.php">Liên hệ</a></li>
            </ul>

            <ul class="nav-shop">
              <li class="nav-item">
              <form method="GET" action="category.php">
    <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <!-- Giữ lại các tham số lọc -->
    <input type="hidden" name="category" value="<?php echo isset($_GET['category']) ? $_GET['category'] : ''; ?>">
    <input type="hidden" name="brand" value="<?php echo isset($_GET['brand']) ? $_GET['brand'] : ''; ?>">
    <button type="submit">Tìm kiếm</button>
</form>

              </li>
              <li class="nav-item"><button><i class="ti-shopping-cart"></i><span
                    class="nav-shop__circle">3</span></button></li>
              <li class="nav-item">
                <?php if ($isLoggedIn): ?>
                  <a href="#" class="nav-link"><i class="fa-solid fa-user"></i>
                    <?php echo htmlspecialchars($username); ?></a>
                  <ul class="dropdown-menu">
                    <li><a class="nav-link" href="cart.php">Xem giỏ hàng</a></li>
                    <li><a class="nav-link" href="wishlist.php">Danh sách yêu thích</a></li>
                    <li><a class="nav-link" href="logout.php">Đăng xuất</a></li>
                  </ul>
                <?php else: ?>
                  <a class="nav-link" href=""><i class="fa-solid fa-user"></i> </a>
                  <ul class="dropdown-menu">
                    <li><a class="nav-link" href="login.php">Đăng nhập</a></li>
                    <li><a class="nav-link" href="register.php">Đăng ký</a></li>
                  </ul>
                <?php endif; ?>
              </li>
            </ul>


          </div>
        </div>
      </nav>
    </div>
  </header>