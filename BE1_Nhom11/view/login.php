<?php
// views/login.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aroma Shop - Login</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>img/Fevicon.png" type="image/png">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendors/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendors/linericon/style.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendors/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendors/nice-select/nice-select.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>vendors/nouislider/nouislider.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
  <!--================ Start Header Menu Area =================-->
  <header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand logo_h" href="index.html"><img src="<?php echo BASE_URL; ?>img/logo.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Shop</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="category.html">Shop Category</a></li>
                  <li class="nav-item"><a class="nav-link" href="single-product.html">Blog Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="checkout.html">Product Checkout</a></li>
                  <li class="nav-item"><a class="nav-link" href="confirmation.html">Confirmation</a></li>
                  <li class="nav-item"><a class="nav-link" href="cart.html">Shopping Cart</a></li>
                </ul>
              </li>
              <li class="nav-item active submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Pages</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                  <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
                  <li class="nav-item"><a class="nav-link" href="tracking-order.html">Tracking</a></li>
                </ul>
              </li>
              <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <!--================ End Header Menu Area =================-->
  
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
              <a class="button button-account" href="register.html">Create an Account</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="login_form_inner">
            <h3>Log in to enter</h3>
            <form class="row login_form" action="login_process.php" method="POST">
              <div class="col-md-12 form-group">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
              </div>
              <div class="col-md-12 form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
              </div>
              <div class="col-md-12 form-group">
                <div class="creat_account">
                  <input type="checkbox" id="f-option2" name="keep_logged_in">
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
  
  <script src="<?php echo BASE_URL; ?>vendors/jquery/jquery-3.2.1.min.js"></script>
  <script src="<?php echo BASE_URL; ?>vendors/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASE_URL; ?>vendors/skrollr.min.js"></script>
  <script src="<?php echo BASE_URL; ?>vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="<?php echo BASE_URL; ?>vendors/nice-select/jquery.nice-select.min.js"></script>
  <script src="<?php echo BASE_URL; ?>vendors/jquery.ajaxchimp.min.js"></script>
  <script src="<?php echo BASE_URL; ?>vendors/mailchimp/mailchimp.js"></script>
  <script src="<?php echo BASE_URL; ?>js/main.js"></script>
</body>
</html>
