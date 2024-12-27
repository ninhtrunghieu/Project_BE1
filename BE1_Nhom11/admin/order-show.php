<?php include "header.php";
include "sidebar.php";
?>
<div class="app-main">
    <div class="app-sidebar sidebar-shadow">
        <div class="app-header__logo">
            <div class="logo-src"></div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                        data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
            <span>
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div>
    </div>

    <div class="app-main__outer">

        <!-- Main -->
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                        </div>
                        <div>
                            Order
                            <div class="page-title-subheading">
                                View, create, update, delete and manage.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body display_data">

                            <div class="table-responsive">
                                <h2 class="text-center">Products list</h2>
                                <hr>
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img style="height: 60px;" data-toggle="tooltip"
                                                                    title="Image" data-placement="bottom"
                                                                    src="assets/images/_default-product.jpg" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">Pure Pineapple</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                2
                                            </td>
                                            <td class="text-center">$10.00</td>
                                            <td class="text-center">
                                                $20.00
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>



                            <h2 class="text-center mt-5">Order info</h2>
                            <hr>
                            <div class="position-relative row form-group">
                                <label for="name" class="col-md-3 text-md-right col-form-label">
                                    Full Name
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    <p>CodeLean</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="email" class="col-md-3 text-md-right col-form-label">Email</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>info@CodeLean.vn</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="phone" class="col-md-3 text-md-right col-form-label">Phone</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>0123456789</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="company_name" class="col-md-3 text-md-right col-form-label">
                                    Company Name
                                </label>
                                <div class="col-md-9 col-xl-8">
                                    <p>CodeLean</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="street_address" class="col-md-3 text-md-right col-form-label">
                                    Street Address</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>Ton That Thuyet, Ha Noi</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="town_city" class="col-md-3 text-md-right col-form-label">
                                    Town City</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>Ha Noi</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="country" class="col-md-3 text-md-right col-form-label">Country</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>Viet Nam</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="postcode_zip" class="col-md-3 text-md-right col-form-label">
                                    Postcode Zip</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>10000</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="payment_type" class="col-md-3 text-md-right col-form-label">Payment
                                    Type</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>Pay Later</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="status" class="col-md-3 text-md-right col-form-label">Status</label>
                                <div class="col-md-9 col-xl-8">
                                    <div class="badge badge-dark mt-2">
                                        Finish
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="description"
                                    class="col-md-3 text-md-right col-form-label">Description</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main -->
        <?php include "footer.php" ?>