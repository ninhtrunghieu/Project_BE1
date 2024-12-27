<?php
require "header.php";
?>
  
	<!-- ================ start banner area ================= -->	
	<section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Xác nhận đơn hàng</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Danh mục cửa hàng</li>
            </ol>
          </nav>
				</div>
			</div>
    </div>
	</section>
	<!-- ================ end banner area ================= -->
  
  <!--================Order Details Area =================-->
  <section class="order_details section-margin--small">
    <div class="container">
      <p class="text-center billing-alert">Cảm ơn. Đơn đặt hàng của bạn đã được nhận.</p>
      <div class="row mb-5">
        <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Thông tin đặt hàng</h3>
            <table class="order-rable">
              <tr>
                <td>Số đơn hàng</td>
                <td>: 60235</td>
              </tr>
              <tr>
                <td>Ngày</td>
                <td>: Oct 03, 2017</td>
              </tr>
              <tr>
                <td>Tổng cộng</td>
                <td>: USD 2210</td>
              </tr>
              <tr>
                <td>Phương thức thanh toán</td>
                <td>: Check payments</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Địa chỉ thanh toán</h3>
            <table class="order-rable">
              <tr>
                <td>Đường phố</td>
                <td>: 13/36 đường 12</td>
              </tr>
              <tr>
                <td>Thành Phố</td>
                <td>: Thủ Đức</td>
              </tr>
              <tr>
                <td>Quốc gia</td>
                <td>: VietNam</td>
              </tr>
              <tr>
                <td>Mã bưu điện</td>
                <td>: 1205</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Địa chỉ giao hàng</h3>
            <table class="order-rable">
              <tr>
                <td>Đường</td>
                <td>: 13/36 đường 12</td>
              </tr>
              <tr>
                <td>City</td>
                <td>: Thủ Đức</td>
              </tr>
              <tr>
                <td>Quốc gia</td>
                <td>: VietNam</td>
              </tr>
              <tr>
                <td>Mã bưu điện</td>
                <td>: 1205</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="order_details_table">
        <h2>Chi tiết đặt hàng</h2>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Sản phẩm</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Tổng Cộng</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <p>Pixelstore fresh Blackberry</p>
                </td>
                <td>
                  <h5>x 02</h5>
                </td>
                <td>
                  <p>$720.00</p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>Pixelstore fresh Blackberry</p>
                </td>
                <td>
                  <h5>x 02</h5>
                </td>
                <td>
                  <p>$720.00</p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>Pixelstore fresh Blackberry</p>
                </td>
                <td>
                  <h5>x 02</h5>
                </td>
                <td>
                  <p>$720.00</p>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>Tổng phụ</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <p>$2160.00</p>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>vận chuyển</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <p>Tỷ giá cố định: $50.00</p>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>Tổng cộng</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <h4>$2210.00</h4>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!--================End Order Details Area =================-->







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