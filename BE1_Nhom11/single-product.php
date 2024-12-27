<?php
session_start();
include "header.php";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_be1";

// Tạo kết nối PDO
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu sản phẩm được gửi từ form
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id']; // Lấy ID sản phẩm
    $product_name = $_POST['product_name']; // Lấy tên sản phẩm
    $product_price = $_POST['product_price']; // Lấy giá sản phẩm
    $quantity = $_POST['quantity']; // Lấy số lượng sản phẩm

    // Kiểm tra nếu giỏ hàng đã tồn tại trong session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array(); // Nếu chưa có giỏ hàng, khởi tạo mảng giỏ hàng
    }

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$product_id])) {
        // Nếu có, tăng số lượng sản phẩm
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // Nếu chưa có, thêm sản phẩm vào giỏ hàng
        $_SESSION['cart'][$product_id] = array(
            'product_name' => $product_name,
            'product_price' => $product_price,
            'quantity' => $quantity
        );
    }

    // Chuyển hướng đến giỏ hàng sau khi thêm sản phẩm
    header('Location: cart.php');
    exit();
}

// Đảm bảo sản phẩm được thêm vào giỏ hàng
// (Dòng print_r($_SESSION['cart']); nên được xóa để không in mảng ra ngoài)
?>



<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="blog">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Mua sắm đơn</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mua sắm đơn</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- ================ end banner area ================= -->


<!--================Single Product Area =================-->
<?php
// Lấy product_id từ URL
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : 0;

if ($product_id > 0) {
    // Truy vấn thông tin sản phẩm từ bảng products
    $sql_product = "SELECT * FROM products WHERE product_id = $product_id";
    $result_product = $conn->query($sql_product);

    if ($result_product->num_rows > 0) {
        // Lấy thông tin sản phẩm
        $product = $result_product->fetch_assoc();

        // Truy vấn các thuộc tính của sản phẩm từ bảng product_details
        $sql_details = "SELECT * FROM product_details WHERE product_id = $product_id";
        $result_details = $conn->query($sql_details);

        // Lưu thông tin chi tiết sản phẩm vào mảng
        $details = [];
        if ($result_details->num_rows > 0) {
            while ($row = $result_details->fetch_assoc()) {
                $details[] = $row;
            }
        }
    } else {
        echo "Sản phẩm không tồn tại!";
    }
} else {
    echo "Không có sản phẩm nào được chọn!";
}

$conn->close();
?>
<div class="product_image_area">
    <div class="container">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="owl-carousel owl-theme s_Product_carousel">
                    <div class="single-prd-item">
                        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>"
                            class="img-fluid">
                    </div>
                    <!-- <div class="single-prd-item">
                            <img class="img-fluid" src="img/category/s-p1.jpg" alt="">
                        </div>
                        <div class="single-prd-item">
                            <img class="img-fluid" src="img/category/s-p1.jpg" alt="">
                        </div> -->
                </div>
            </div>


            <!-- HTML để hiển thị chi tiết sản phẩm -->
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    
                    <h3><?php echo $product['name']; ?></h3>
                    <h2><?php echo "$" . number_format($product['price'], 2); ?></h2>
                    <ul class="list">
                        <?php foreach ($details as $detail) { ?>
                            <li>
                                <a class="active" href="#"><span><?php echo $detail['attribute_name']; ?></span> :
                                    <?php echo $detail['attribute_value']; ?></a>
                            </li>
                        <?php } 
                        ?>
                    </ul>
                    <p><?php echo $product['description']; ?></p>

                    <!-- Form để gửi dữ liệu sản phẩm -->
                    <form action="cart.php" method="POST">
                        <div class="product_count">
                            <label for="qty">Số lượng:</label>
                            <input type="text" name="qty" id="sst" size="2" maxlength="12" value="1" title="Quantity:"
                                class="input-text qty" style="margin-right: 30px;">
                            <button onclick="increaseQuantity();" class="increase items-count" type="button"><i
                                    class="ti-angle-up"></i></button>
                            
                            <button onclick="decreaseQuantity();" class="reduced items-count" type="button"><i
                                    class="ti-angle-down"></i></button>
                                 
                        </div>

                        <!-- Thêm thông tin sản phẩm vào giỏ hàng -->
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">

                        <!-- Nút gửi form -->
                        <button class="button primary-btn" type="submit" name="action" value="add_to_cart">Add to
                        Cart</button>  
                        
                        
                    </form>

                    <div class="card_area d-flex align-items-center">
                        <a class="icon_btn" href="#"><i class="lnr lnr-heart"></i></a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!--================End Single Product Area =================-->

<!--================Product Description Area =================-->
<section class="product_description_area">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">miêu tả</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">Đặc điểm kỹ thuật</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                    aria-controls="contact" aria-selected="false">Comments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab"
                    aria-controls="review" aria-selected="false">Reviews</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                <p>Beryl Cook is one of Britain’s most talented and amusing artists .Beryl’s pictures feature women of
                    all shapes
                    and sizes enjoying themselves .Born between the two world wars, Beryl Cook eventually left Kendrick
                    School in
                    Reading at the age of 15, where she went to secretarial school and then into an insurance office.
                    After moving to
                    London and then Hampton, she eventually married her next door neighbour from Reading, John Cook. He
                    was an
                    officer in the Merchant Navy and after he left the sea in 1956, they bought a pub for a year before
                    John took a
                    job in Southern Rhodesia with a motor company. Beryl bought their young son a box of watercolours,
                    and when
                    showing him how to use it, she decided that she herself quite enjoyed painting. John subsequently
                    bought her a
                    child’s painting set for her birthday and it was with this that she produced her first significant
                    work, a
                    half-length portrait of a dark-skinned lady with a vacant expression and large drooping breasts. It
                    was aptly
                    named ‘Hangover’ by Beryl’s husband and</p>
                <p>It is often frustrating to attempt to plan meals that are designed for one. Despite this fact, we are
                    seeing
                    more and more recipe books and Internet websites that are dedicated to the act of cooking for one.
                    Divorce and
                    the death of spouses or grown children leaving for college are all reasons that someone accustomed
                    to cooking for
                    more than one would suddenly need to learn how to adjust all the cooking practices utilized before
                    into a
                    streamlined plan of cooking that is more efficient for one person creating less</p>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <h5>Width</h5>
                                </td>
                                <td>
                                    <h5>128mm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Height</h5>
                                </td>
                                <td>
                                    <h5>508mm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Depth</h5>
                                </td>
                                <td>
                                    <h5>85mm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Weight</h5>
                                </td>
                                <td>
                                    <h5>52gm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Quality checking</h5>
                                </td>
                                <td>
                                    <h5>yes</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Freshness Duration</h5>
                                </td>
                                <td>
                                    <h5>03days</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>When packeting</h5>
                                </td>
                                <td>
                                    <h5>Without touch of hand</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Each Box contains</h5>
                                </td>
                                <td>
                                    <h5>60pcs</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="comment_list">
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="img/product/review-1.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <h5>12th Feb, 2018 at 05:56 pm</h5>
                                        <a class="reply_btn" href="#">Reply</a>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                    laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                            <div class="review_item reply">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="img/product/review-2.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <h5>12th Feb, 2018 at 05:56 pm</h5>
                                        <a class="reply_btn" href="#">Reply</a>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                    laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="img/product/review-3.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <h5>12th Feb, 2018 at 05:56 pm</h5>
                                        <a class="reply_btn" href="#">Reply</a>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                    laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Đăng bình luận</h4>
                            <form class="row contact_form" action="contact_process.php" method="post" id="contactForm"
                                novalidate="novalidate">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Your Full name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="number" name="number"
                                            placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" id="message" rows="1"
                                            placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" value="submit" class="btn primary-btn">Submit Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row total_rate">
                            <div class="col-6">
                                <div class="box_total">
                                    <h5>Tổng thể</h5>
                                    <h4>4.0</h4>
                                    <h6>(03 Đánh giá)</h6>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="rating_list">
                                    <h3>Dựa trên 3 đánh giá</h3>
                                    <ul class="list">
                                        <li><a href="#">5 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">4 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">3 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">2 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i> 01</a></li>
                                        <li><a href="#">1 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                    class="fa fa-star"></i> 01</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="review_list">
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="img/product/review-1.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                    laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="img/product/review-2.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                    laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="img/product/review-3.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et
                                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                    laboris nisi ut aliquip ex ea
                                    commodo</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Thêm đánh giá</h4>
                            <p>Đánh giá của bạn:</p>
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p>Nổi bật</p>
                            <form action="#/" class="form-contact form-review mt-3">
                                <div class="form-group">
                                    <input class="form-control" name="name" type="text" placeholder="Enter your name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="email" type="email"
                                        placeholder="Enter email address" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="subject" type="text" placeholder="Enter Subject">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control different-control w-100" name="textarea" id="textarea"
                                        cols="30" rows="5" placeholder="Enter Message"></textarea>
                                </div>
                                <div class="form-group text-center text-md-right mt-3">
                                    <button type="submit" class="button button--active button-review">Submit
                                        Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Product Description Area =================-->

<!--================ Start related Product area =================-->
<section class="related-product-area section-margin--small mt-0">
    <div class="container">
        <div class="section-intro pb-60px">
            <p>Mặt hàng phổ biến trên thị trường</p>
            <h2>Trên <span class="section-intro__style">Sản phẩm</span></h2>
        </div>
        <div class="row mt-30">
            <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
                <div class="single-search-product-wrapper">
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-1.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-2.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-3.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
                <div class="single-search-product-wrapper">
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-4.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-5.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-6.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
                <div class="single-search-product-wrapper">
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-7.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-8.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-9.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
                <div class="single-search-product-wrapper">
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-1.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-2.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                    <div class="single-search-product d-flex">
                        <a href="#"><img src="img/product/product-sm-3.png" alt=""></a>
                        <div class="desc">
                            <a href="#" class="title">Gray Coffee Cup</a>
                            <div class="price">$170.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================ end related Product area =================-->

<?php
require "footer.php";
?>

<script src="vendors/jquery/jquery-3.2.1.min.js"></script>
<script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>
<script src="vendors/skrollr.min.js"></script>
<script src="vendors/owl-carousel/owl.carousel.min.js"></script>
<script src="vendors/nice-select/jquery.nice-select.min.js"></script>
<script src="vendors/jquery.ajaxchimp.min.js"></script>
<script src="vendors/mail-script.js"></script>
<script src="js/main.js"></script>
<script>
    function increaseQuantity() {
    var qty = document.getElementById("sst");
    var currentValue = parseInt(qty.value);
    if (!isNaN(currentValue)) {
        qty.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    var qty = document.getElementById("sst");
    var currentValue = parseInt(qty.value);
    if (!isNaN(currentValue) && currentValue > 1) {
        qty.value = currentValue - 1;
    }
}

</script>