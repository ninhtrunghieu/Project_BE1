<?php
include "header.php";
include "sidebar.php";
?>

<div class="ui-theme-settings">

    <div class="theme-settings__inner">
        <div class="scrollbar-container">
            <div class="theme-settings__options-wrapper">
                <h3 class="themeoptions-heading">Layout Options</h3>
                <div class="p-3">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-3">
                                        <div class="switch has-switch switch-container-class" data-class="fixed-header">
                                            <div class="switch-animate switch-on">
                                                <input type="checkbox" checked data-toggle="toggle"
                                                    data-onstyle="success">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Fixed Header</div>
                                        <div class="widget-subheading">Makes the header top fixed, always
                                            visible!</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-3">
                                        <div class="switch has-switch switch-container-class"
                                            data-class="fixed-sidebar">
                                            <div class="switch-animate switch-on">
                                                <input type="checkbox" checked data-toggle="toggle"
                                                    data-onstyle="success">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Fixed Sidebar</div>
                                        <div class="widget-subheading">Makes the sidebar left fixed, always
                                            visible!</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-3">
                                        <div class="switch has-switch switch-container-class" data-class="fixed-footer">
                                            <div class="switch-animate switch-off">
                                                <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Fixed Footer</div>
                                        <div class="widget-subheading">Makes the app footer bottom fixed, always
                                            visible!</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <h3 class="themeoptions-heading">
                    <div> Header Options </div>
                    <button type="button"
                        class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class"
                        data-class="">
                        Restore Default
                    </button>
                </h3>
                <div class="p-3">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <h5 class="pb-2">Choose Color Scheme</h5>
                            <div class="theme-settings-swatches">
                                <div class="swatch-holder bg-primary switch-header-cs-class"
                                    data-class="bg-primary header-text-light"></div>
                                <div class="swatch-holder bg-secondary switch-header-cs-class"
                                    data-class="bg-secondary header-text-light"></div>
                                <div class="swatch-holder bg-success switch-header-cs-class"
                                    data-class="bg-success header-text-light"></div>
                                <div class="swatch-holder bg-info switch-header-cs-class"
                                    data-class="bg-info header-text-light"></div>
                                <div class="swatch-holder bg-warning switch-header-cs-class"
                                    data-class="bg-warning header-text-dark"></div>
                                <div class="swatch-holder bg-danger switch-header-cs-class"
                                    data-class="bg-danger header-text-light"></div>
                                <div class="swatch-holder bg-light switch-header-cs-class"
                                    data-class="bg-light header-text-dark"></div>
                                <div class="swatch-holder bg-dark switch-header-cs-class"
                                    data-class="bg-dark header-text-light"></div>
                                <div class="swatch-holder bg-focus switch-header-cs-class"
                                    data-class="bg-focus header-text-light"></div>
                                <div class="swatch-holder bg-alternate switch-header-cs-class"
                                    data-class="bg-alternate header-text-light"></div>
                                <div class="divider"></div>
                                <div class="swatch-holder bg-vicious-stance switch-header-cs-class"
                                    data-class="bg-vicious-stance header-text-light"></div>
                                <div class="swatch-holder bg-midnight-bloom switch-header-cs-class"
                                    data-class="bg-midnight-bloom header-text-light"></div>
                                <div class="swatch-holder bg-night-sky switch-header-cs-class"
                                    data-class="bg-night-sky header-text-light"></div>
                                <div class="swatch-holder bg-slick-carbon switch-header-cs-class"
                                    data-class="bg-slick-carbon header-text-light"></div>
                                <div class="swatch-holder bg-asteroid switch-header-cs-class"
                                    data-class="bg-asteroid header-text-light"></div>
                                <div class="swatch-holder bg-royal switch-header-cs-class"
                                    data-class="bg-royal header-text-light"></div>
                                <div class="swatch-holder bg-warm-flame switch-header-cs-class"
                                    data-class="bg-warm-flame header-text-dark"></div>
                                <div class="swatch-holder bg-night-fade switch-header-cs-class"
                                    data-class="bg-night-fade header-text-dark"></div>
                                <div class="swatch-holder bg-sunny-morning switch-header-cs-class"
                                    data-class="bg-sunny-morning header-text-dark"></div>
                                <div class="swatch-holder bg-tempting-azure switch-header-cs-class"
                                    data-class="bg-tempting-azure header-text-dark"></div>
                                <div class="swatch-holder bg-amy-crisp switch-header-cs-class"
                                    data-class="bg-amy-crisp header-text-dark"></div>
                                <div class="swatch-holder bg-heavy-rain switch-header-cs-class"
                                    data-class="bg-heavy-rain header-text-dark"></div>
                                <div class="swatch-holder bg-mean-fruit switch-header-cs-class"
                                    data-class="bg-mean-fruit header-text-dark"></div>
                                <div class="swatch-holder bg-malibu-beach switch-header-cs-class"
                                    data-class="bg-malibu-beach header-text-light"></div>
                                <div class="swatch-holder bg-deep-blue switch-header-cs-class"
                                    data-class="bg-deep-blue header-text-dark"></div>
                                <div class="swatch-holder bg-ripe-malin switch-header-cs-class"
                                    data-class="bg-ripe-malin header-text-light"></div>
                                <div class="swatch-holder bg-arielle-smile switch-header-cs-class"
                                    data-class="bg-arielle-smile header-text-light"></div>
                                <div class="swatch-holder bg-plum-plate switch-header-cs-class"
                                    data-class="bg-plum-plate header-text-light"></div>
                                <div class="swatch-holder bg-happy-fisher switch-header-cs-class"
                                    data-class="bg-happy-fisher header-text-dark"></div>
                                <div class="swatch-holder bg-happy-itmeo switch-header-cs-class"
                                    data-class="bg-happy-itmeo header-text-light"></div>
                                <div class="swatch-holder bg-mixed-hopes switch-header-cs-class"
                                    data-class="bg-mixed-hopes header-text-light"></div>
                                <div class="swatch-holder bg-strong-bliss switch-header-cs-class"
                                    data-class="bg-strong-bliss header-text-light"></div>
                                <div class="swatch-holder bg-grow-early switch-header-cs-class"
                                    data-class="bg-grow-early header-text-light"></div>
                                <div class="swatch-holder bg-love-kiss switch-header-cs-class"
                                    data-class="bg-love-kiss header-text-light"></div>
                                <div class="swatch-holder bg-premium-dark switch-header-cs-class"
                                    data-class="bg-premium-dark header-text-light"></div>
                                <div class="swatch-holder bg-happy-green switch-header-cs-class"
                                    data-class="bg-happy-green header-text-light"></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <h3 class="themeoptions-heading">
                    <div>Sidebar Options</div>
                    <button type="button"
                        class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-sidebar-cs-class"
                        data-class="">
                        Restore Default
                    </button>
                </h3>

                <h3 class="themeoptions-heading">
                    <div>Main Content Options</div>
                    <button type="button"
                        class="btn-pill btn-shadow btn-wide ml-auto active btn btn-focus btn-sm">Restore
                        Default</button>
                </h3>
                <div class="p-3">
                    <ul class="list-group">

                        <li class="list-group-item">
                            <h5 class="pb-2">Page Section Tabs</h5>
                            <div class="theme-settings-swatches">
                                <div role="group" class="mt-2 btn-group">
                                    <button type="button"
                                        class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class"
                                        data-class="body-tabs-line"> Line</button>
                                    <button type="button"
                                        class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class"
                                        data-class="body-tabs-shadow"> Shadow </button>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h5 class="pb-2">Light Color Schemes
                            </h5>
                            <div class="theme-settings-swatches">
                                <div role="group" class="mt-2 btn-group">
                                    <button type="button"
                                        class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class"
                                        data-class="app-theme-white"> White Theme</button>
                                    <button type="button"
                                        class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class"
                                        data-class="app-theme-gray"> Gray Theme</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

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
                            Product
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

                            <div class="position-relative row form-group">
                                <label for="" class="col-md-3 text-md-right col-form-label">Images</label>
                                <div class="col-md-9 col-xl-8">
                                    <ul class="text-nowrap overflow-auto" id="images">
                                        <li class="d-inline-block mr-1" style="position: relative;">
                                            <img style="height: 150px;" src="assets/images/_default-product.jpg"
                                                alt="Image">
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="brand_id" class="col-md-3 text-md-right col-form-label">Product
                                    Images</label>
                                <div class="col-md-9 col-xl-8">
                                    <p><a href="./product-image.php">Manage images</a></p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="brand_id" class="col-md-3 text-md-right col-form-label">Product
                                    Details</label>
                                <div class="col-md-9 col-xl-8">
                                    <p><a href="./product-detail.php">Manage details</a></p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="brand_id" class="col-md-3 text-md-right col-form-label">Brand</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>Calvin Klein</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="product_category_id"
                                    class="col-md-3 text-md-right col-form-label">Category</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>Men</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="name" class="col-md-3 text-md-right col-form-label">Name</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>Pure Pineapple</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="content" class="col-md-3 text-md-right col-form-label">Content</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>High quality fabric, modern and youthful design</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="price" class="col-md-3 text-md-right col-form-label">Price</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>$629.99</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="discount" class="col-md-3 text-md-right col-form-label">Discount</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>$495.00</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="qty" class="col-md-3 text-md-right col-form-label">Qty</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>20</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="weight" class="col-md-3 text-md-right col-form-label">Weight</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>1.3</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="sku" class="col-md-3 text-md-right col-form-label">SKU</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>00012</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="tag" class="col-md-3 text-md-right col-form-label">Tag</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>Clothing</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="featured" class="col-md-3 text-md-right col-form-label">Featured</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>Yes</p>
                                </div>
                            </div>

                            <div class="position-relative row form-group">
                                <label for="description"
                                    class="col-md-3 text-md-right col-form-label">Description</label>
                                <div class="col-md-9 col-xl-8">
                                    <p>Product description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main -->

        <?php include "footer.php"; ?>