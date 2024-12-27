<?php


// Kiểm tra nếu người dùng nhấn vào biểu tượng giỏ hàng
if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart']; // Lấy ID sản phẩm từ URL

    // Kiểm tra nếu giỏ hàng chưa tồn tại trong session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array(); // Tạo giỏ hàng mới nếu chưa có
    }

    // Thêm sản phẩm vào giỏ hàng
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += 1; // Nếu có rồi thì tăng số lượng
    } else {
        $_SESSION['cart'][$product_id] = 1; // Nếu chưa có thì thêm mới
    }

    // Chuyển hướng lại trang để tránh nhấn F5 và gửi lại yêu cầu
    header('Location: cart.php');
    exit();
}

// Kết nối tới cơ sở dữ liệu
$servername = "localhost";  // Tên máy chủ (hoặc localhost nếu bạn đang làm việc trên máy cục bộ)
$username = "root";         // Tên người dùng MySQL
$password = "";             // Mật khẩu MySQL
$dbname = "db_be1"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Phân trang
$limit = 8; // Số sản phẩm trên mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Lấy số trang hiện tại
$offset = ($page - 1) * $limit; // Tính toán offset

// Lấy tổng số sản phẩm
$total_sql = "SELECT COUNT(*) as total FROM products";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit); // Tính số trang

// Lấy dữ liệu sản phẩm từ cơ sở dữ liệu với phân trang
$sql = "SELECT p.product_id, p.name, p.price, p.image_url, c.name AS category_name
        FROM products p
        INNER JOIN product_categories c ON p.category_id = c.category_id
        ORDER BY p.created_at DESC
        LIMIT $limit OFFSET $offset"; // Giới hạn số sản phẩm và offset
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Thay đổi đường dẫn tới file CSS của bạn -->
</head>
<body>

<main class="site-main">

    <!--================ Hero banner start =================-->
    <section class="hero-banner">
        <div class="container">
            <div class="row no-gutters align-items-center pt-60px">
                <div class="col-5 d-none d-sm-block">
                    <div class="hero-banner__img">
                        <img class="img-fluid" src="img/home/hero-banner.png" alt="">
                    </div>
                </div>
                <div class="col-sm-7 col-lg-6 offset-lg-1 pl-4 pl-md-5 pl-lg-0">
                    <div class="hero-banner__content">
                        <h4>Shop is fun</h4>
                        <h1>Browse Our Premium Product</h1>
                        <p>Us which over of signs divide dominion deep fill bring they're meat beho upon own earth without morning
                            over third. Their male dry. They are great appear whose land fly grass.</p>
                        <a class="button button-hero" href="#">Browse Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ Hero banner end =================-->

    <!-- ================ trending product section start ================= -->
    <section class="section-margin calc-60px">
    <div class="container">
        <div class="section-intro pb-60px">
            <p>Popular Item in the market </p>
            <h2>New <span class="section-intro__style">Product</span></h2>
        </div>
        <div class="row">
            <?php
            // Lấy dữ liệu sản phẩm từ cơ sở dữ liệu với phân trang
            $sql = "SELECT p.product_id, p.name, p.price, p.image_url, c.name AS category_name
                    FROM products p
                    INNER JOIN product_categories c ON p.category_id = c.category_id
                    ORDER BY p.created_at DESC
                    LIMIT $limit OFFSET $offset"; // Giới hạn số sản phẩm và offset
            $result = $conn->query($sql);

            // Kiểm tra nếu có sản phẩm trong cơ sở dữ liệu
            if ($result->num_rows > 0) {
                // Lặp qua từng sản phẩm và hiển thị
                while ($row = $result->fetch_assoc()) {
                    // Lấy thông tin sản phẩm
                    $name = $row['name'];
                    $category = $row['category_name'];
                    $image_url = $row['image_url'];
                    $price = number_format($row['price'], 2); // Định dạng giá tiền
                    $product_id = $row['product_id']; // ID sản phẩm để làm đường dẫn
                    ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card text-center card-product">
                            <div class="card-product__img">
                                <img class="card-img" src="<?php echo $image_url; ?>" alt="<?php echo $name; ?>">
                                <ul class="card-product__imgOverlay">
                                    <li><button><i class="ti-search"></i></button></li>
                                    <li><a href="?add_to_cart=<?php echo $product_id; ?>"><button><i class="ti-shopping-cart"></i></button></a></li>
                                    <li><button><i class="ti-heart"></i></button></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <p><?php echo $category; ?></p>
                                <h4 class="card-product__title"><a
                                        href="single-product.php?product_id=<?php echo $product_id; ?>"><?php echo $name; ?></a></h4>
                                <p class="card-product__price">$<?php echo $price; ?></ </p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Không có sản phẩm nào.</p>";
            }
            ?>
        </div>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">&laquo; Trang trước</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Trang sau &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</section>
    <!-- ================ trending product section end ================= -->

    <!-- ================ offer section start ================= -->
    <section class="offer" id="parallax-1" data-anchor-target="#parallax-1" data-300-top="background-position: 20px 30px"
        data-top-bottom="background-position: 0 20px">
        <div class="container">
            <div class="row">
                <div class="col-xl-5">
                    <div class="offer__content text-center">
                        <h3>Up To 50% Off</h3>
                        <h4>Winter Sale</h4>
                        <p>Him she'd let them sixth saw light</p>
                        <a class="button button--active mt-3 mt-xl-4" href="#">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ offer section end ================= -->

    <!-- ================ Best Selling item carousel ================= -->
    <section class="section-margin calc-60px">
        <div class="container">
            <div class="section-intro pb-60px">
                <p>Popular Item in the market</p>
                <h2><span class="section-intro__style">Laptop</span></h2>
            </div>
            <div class="owl-carousel owl-theme" id="bestSellerCarousel">
                <?php
                // Lấy tất cả sản phẩm thuộc danh mục Laptop (category_id = 2)
                $sql = "SELECT * FROM products WHERE category_id = 2";
                $result = $conn->query($sql);

                // Kiểm tra nếu có dữ liệu trả về
                if ($result->num_rows > 0) {
                    // Lặp qua tất cả các sản phẩm
                    while ($row = $result->fetch_assoc()) {
                        $product_id = $row['product_id'];
                        $product_name = $row['name'];
                        $product_description = $row['description'];
                        $product_price = number_format($row['price'], 2); // Định dạng giá
                        $product_image = $row['image_url'];

                        // Hiển thị sản phẩm vào HTML
                        echo '<div class="card text-center card-product">
                            <div class="card-product__img">
                                <img class="img-fluid" src="' . $product_image . '" alt="">
                                <ul class="card-product__imgOverlay">
                                    <li><button><i class="ti-search"></i></button></li>
                                    <li><button><i class="ti-shopping-cart"></i></button></li>
                                    <li><button><i class="ti-heart"></i></button></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <p>' . $product_description . '</p>
                                <h4 class="card-product__title"><a href="single-product.php?product_id=' . $product_id . '">' . $product_name . '</a></h4>
                                <p class="card-product__price">$' . $product_price . '</p>
                            </div>
                        </div>';
                    }
                } else {
                    echo "No products found.";
                }
                ?>
            </div>
        </div>
    </section>
    <!-- ================ Best Selling item carousel end ================= -->

    <!-- ================ Blog section start ================= -->
    <section class="blog">
        <div class="container">
            <div class="section-intro pb-60px">
                <p>Popular Item in the market</p>
                <h2>Latest <span class="section-intro__style">News</span></h2>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="card card-blog">
                        <div class="card-blog__img">
                            <img class="card-img rounded-0" src="img/blog/blog1.png" alt="">
                        </div>
                        <div class="card-body">
                            <ul class="card-blog__info">
                                <li><a href="#">By Admin</a></li>
                                <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
                            </ul>
                            <h4 class="card-blog__title"><a href="single-blog.html">The Richland Center Shopping News and weekly shopper</a></h4>
                            <p>Let one fifth I bring fly to divided face for bearing divide unto seed. Winged divided light forth.</p>
                            <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="card card-blog">
                        <div class="card-blog__img">
                            <img class="card-img rounded-0" src="img/blog/blog2.png" alt="">
                        </div>
                        <div class="card-body">
                            <ul class="card-blog__info">
                                <li><a href="#">By Admin</a></li>
                                <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
                            </ul>
                            <h4 class="card-blog__title"><a href="single-blog.html">The Shopping News also offers top-quality printing services</a></h4>
                            <p>Let one fifth I bring fly to divided face for bearing divide unto seed. Winged divided light forth.</p>
                            <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="card card-blog">
                        <div class="card-blog__img">
                            <img class="card-img rounded-0" src="img/blog /blog/blog3.png" alt="">
                        </div>
                        <div class="card-body">
                            <ul class="card-blog__info">
                                <li><a href="#">By Admin</a></li>
                                <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
                            </ul>
                            <h4 class="card-blog__title"><a href="single-blog.html">Professional design staff and efficient equipment you’ll find we offer</a></h4>
                            <p>Let one fifth I bring fly to divided face for bearing divide unto seed. Winged divided light forth.</p>
                            <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ Blog section end ================= -->

    <!-- ================ Subscribe section start ================= -->
    <section class="subscribe-position">
        <div class="container">
            <div class="subscribe text-center">
                <h3 class="subscribe__title">Get Update From Anywhere</h3>
                <p>Bearing Void gathering light light his evening unto don't afraid</p>
                <div id="mc_embed_signup">
                    <form target="_blank"
                          action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                          method="get" class="subscribe-form form-inline mt-5 pt-1">
                        <div class="form-group ml-sm-auto">
                            <input class="form-control mb-1" type="email" name="EMAIL" placeholder="Enter your email"
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address '">
                            <div class="info"></div>
                        </div>
                        <button class="button button-subscribe mr-auto mb-1" type="submit">Subscribe Now</button>
                        <div style="position: absolute; left: -5000px;">
                            <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ Subscribe section end ================= -->

</main>

</body>
</html>