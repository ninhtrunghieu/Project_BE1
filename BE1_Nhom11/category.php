<?php

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

// Truy vấn lấy danh mục
$sql = "SELECT category_id, name, total_products FROM product_categories";
$result = $conn->query($sql);
?>


<?php
require "header.php";
?>
<!--================ End Header Menu Area =================-->

<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>Danh mục Shop</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh mục Shop</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ================ end banner area ================= -->


<!-- ================ category section start ================= -->
<section class="section-margin--small mb-5">
  <div class="container">
    <div class="row">
      <?php
      // Kiểm tra nếu các tham số category và brand có trong URL GET không
      $category_id = isset($_GET['category']) ? intval($_GET['category']) : null;
      $brand_id = isset($_GET['brand']) ? intval($_GET['brand']) : null;
      ?>

      <div class="col-xl-3 col-lg-4 col-md-5">
        <div class="sidebar-categories">
          <div class="head">Danh mục</div>
          <ul class="main-categories">
            <li class="common-filter">
              <form method="GET" action="category.php">
                <ul>
                  <?php
                  // Kiểm tra nếu $result đã được khai báo trước đó và có dữ liệu
                  if (isset($result) && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      // Kiểm tra nếu category_id hiện tại đã được chọn trong URL GET
                      $checked = ($category_id == $row['category_id']) ? 'checked' : '';
                      echo "<li class='filter-list'>";
                      echo "<input class='pixel-radio' type='radio' id='category_" . $row['category_id'] . "' name='category' value='" . $row['category_id'] . "' onchange='this.form.submit()' $checked>";
                      echo "<label for='category_" . $row['category_id'] . "'>";
                      echo $row['name'] . " <span>(" . $row['total_products'] . ")</span>";
                      echo "</label>";
                      echo "</li>";
                    }
                  } else {
                    echo "<li>Không có danh mục nào.</li>";
                  }
                  ?>
                </ul>
              </form>
            </li>
          </ul>
        </div>

        <div class="sidebar-filter">
          <div class="top-filter-head">Bộ lọc sản phẩm</div>
          <div class="common-filter">
            <div class="head">Thương hiệu</div>
            <form method="GET" action="category.php">
              <ul>
                <?php
                // Truy vấn thương hiệu
                $sql_brands = "SELECT brand_id, name, product_count FROM brands";
                $result_brands = mysqli_query($conn, $sql_brands);

                while ($row = $result_brands->fetch_assoc()) {
                  // Kiểm tra nếu brand_id hiện tại đã được chọn trong URL GET
                  $checked = ($brand_id == $row['brand_id']) ? 'checked' : '';
                  echo "<li class='filter-list'>";
                  echo "<input class='pixel-radio' type='radio' id='brand_" . $row['brand_id'] . "' name='brand' value='" . $row['brand_id'] . "' onchange='this.form.submit()' $checked>";
                  echo "<label for='brand_" . $row['brand_id'] . "'>";
                  echo $row['name'] . " <span>(" . $row['product_count'] . ")</span>";
                  echo "</label>";
                  echo "</li>";
                }
                ?>
              </ul>
            </form>
          </div>
        </div>
      </div>

    <div class="col-xl-9 col-lg-8 col-md-7">
      <!-- Start Filter Bar -->
      <div class="filter-bar d-flex flex-wrap align-items-center">
        <div class="sorting">
          <select>
            <option value="1">Sắp xếp mặc định</option>
            <option value="1">Sắp xếp mặc định</option>
            <option value="1">Sắp xếp mặc định</option>
          </select>
        </div>
        <div class="sorting mr-auto">
          <select>
            <option value="1">Show 12</option>
            <option value="1">Show 12</option>
            <option value="1">Show 12</option>
          </select>
        </div>
        <div>
          <div class="input-group filter-bar-search">
            <input type="text" placeholder="Search">
            <div class="input-group-append">
              <button type="button"><i class="ti-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Filter Bar -->
      <!-- Start Best Seller -->
      <section class="lattest-product-area pb-40 category-list">
        <div class="row">
          <?php
          // Lấy tham số lọc từ GET
          $category_id = isset($_GET['category']) ? intval($_GET['category']) : null;
          $brand_id = isset($_GET['brand']) ? intval($_GET['brand']) : null;
          $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
          
          $limit = 6;  // Số lượng sản phẩm trên mỗi trang
          $offset = ($page - 1) * $limit;  // Vị trí bắt đầu cho LIMIT
          
          // Truy vấn sản phẩm
          $sql = "SELECT product_id, name, description, price, image_url FROM products WHERE 1=1";
          if ($category_id) {
            $sql .= " AND category_id = ?";
          }
          if ($brand_id) {
            $sql .= " AND brand_id = ?";
          }
          $sql .= " LIMIT $offset, $limit";

          // Chuẩn bị và thực hiện truy vấn với prepared statements
          $stmt = $conn->prepare($sql);
          if ($category_id && $brand_id) {
            $stmt->bind_param("ii", $category_id, $brand_id);
          } elseif ($category_id) {
            $stmt->bind_param("i", $category_id);
          } elseif ($brand_id) {
            $stmt->bind_param("i", $brand_id);
          }
          $stmt->execute();
          $result = $stmt->get_result();

          // Hiển thị sản phẩm
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<div class='col-md-6 col-lg-4'>";
              echo "  <div class='card text-center card-product'>";
              echo "    <div class='card-product__img'>";
              echo "      <img class='card-img' src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
              echo "      <ul class='card-product__imgOverlay'>";
              echo "        <li><button><i class='ti-search'></i></button></li>";
              echo "        <li><button><i class='ti-shopping-cart'></i></button></li>";
              echo "        <li><button><i class='ti-heart'></i></button></li>";
              echo "      </ul>";
              echo "    </div>";
              echo "    <div class='card-body'>";
              echo "      <h4 class='card-product__title'><a href='single-product'>" . htmlspecialchars($row['name']) . "</a></h4>";
              echo "      <p>" . htmlspecialchars($row['description']) . "</p>";
              echo "      <p class='card-product__price'>$" . number_format($row['price'], 2) . "</p>";
              echo "    </div>";
              echo "  </div>";
              echo "</div>";
            }
          } else {
            echo "<p>Không tìm thấy sản phẩm nào.</p>";
          }

          // Tính toán tổng số sản phẩm và phân trang
          $sql_count = "SELECT COUNT(*) AS total FROM products WHERE 1=1";
          if ($category_id) {
            $sql_count .= " AND category_id = ?";
          }
          if ($brand_id) {
            $sql_count .= " AND brand_id = ?";
          }

          $stmt_count = $conn->prepare($sql_count);
          if ($category_id && $brand_id) {
            $stmt_count->bind_param("ii", $category_id, $brand_id);
          } elseif ($category_id) {
            $stmt_count->bind_param("i", $category_id);
          } elseif ($brand_id) {
            $stmt_count->bind_param("i", $brand_id);
          }
          $stmt_count->execute();
          $count_result = $stmt_count->get_result();
          $total_products = $count_result->fetch_assoc()['total'];

          $total_pages = ceil($total_products / $limit);

          // Hiển thị phân trang
          echo "<div class='pagination'>";
          if ($page > 1) {
            echo "<a href='?page=" . ($page - 1) . "&category=$category_id&brand=$brand_id'>&laquo; Trang trước</a>";
          } else {
            echo "<a href='#' class='disabled'>&laquo; Trang trước</a>";
          }
          for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
              echo "<span class='current-page'>$i</span>";
            } else {
              echo "<a href='?page=$i&category=$category_id&brand=$brand_id'>$i</a>";
            }
          }
          if ($page < $total_pages) {
            echo "<a href='?page=" . ($page + 1) . "&category=$category_id&brand=$brand_id'>Trang sau &raquo;</a>";
          } else {
            echo "<a href='#' class='disabled'>Trang sau &raquo;</a>";
          }
          echo "</div>";

          // Đóng kết nối
          $conn->close();
          ?>
        </div>
      </section>

      <!-- End Best Seller -->
    </div>
  </div>
  </div>
</section>
<!-- ================ category section end ================= -->

<!-- ================ top product area start ================= -->
<section class="related-product-area">
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
<!-- ================ top product area end ================= -->

<!-- ================ Subscribe section start ================= -->
<section class="subscribe-position">
  <div class="container">
    <div class="subscribe text-center">
      <h3 class="subscribe__title">Nhận cập nhật từ mọi nơi</h3>
      <p>Bearing Void gathering light light his eavening unto dont afraid</p>
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



<script src="vendors/jquery/jquery-3.2.1.min.js"></script>
<script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>
<script src="vendors/skrollr.min.js"></script>
<script src="vendors/owl-carousel/owl.carousel.min.js"></script>
<script src="vendors/nice-select/jquery.nice-select.min.js"></script>
<script src="vendors/nouislider/nouislider.min.js"></script>
<script src="vendors/jquery.ajaxchimp.min.js"></script>
<script src="vendors/mail-script.js"></script>
<script src="js/main.js"></script>

<?php
require "footer.php";
?>