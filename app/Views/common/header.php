<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link rel="shortcut icon" href="/images/favicon.ico">
    <link rel="apple-touch-icon" href="/images/icon.png">

    <!-- Google font (font-family: 'Roboto', sans-serif; Poppins ; Satisfy) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/plugins.css">
    <link rel="stylesheet" href="/css/style.css">

    <!-- Cusom css -->
    <link rel="stylesheet" href="/css/custom.css">

    <!-- Modernizer js -->
    <script src="/js/vendor/modernizr-3.5.0.min.js" type="application/javascript"></script>
</head>
<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->

<!-- Main wrapper -->
<div class="wrapper" id="wrapper">
    <!-- Header -->
    <header id="wn__header" class="header__area header__absolute sticky__header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-6 col-lg-2">
                    <div class="logo">
                        <a href="/">
                            <img src="/images/logo/logo.png" alt="logo images">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 d-none d-lg-block">
                    <nav class="mainmenu__nav">
                        <ul class="meninmenu d-flex justify-content-start">
                            <li class="drop with--one--item"><a href="/">Home</a></li>
                            <li class="drop with--one--item"><a href="/catalog">Catalog</a></li>
                            <li><a href="/contact.html">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-6 col-6 col-lg-2">
                    <ul class="header__sidebar__right d-flex justify-content-end align-items-center">
<!--                        <li class="shop_search"><a class="search__active" href="#"></a></li>-->
<!--                        <li class="wishlist"><a href="/#/"></a></li>-->
                        <li class="shopcart"><a class="cartbox_active" href="/#/"><span class="product_qun">0</span></a>
                            <!-- Start Shopping Cart -->
                            <div id="cart" class="block-minicart minicart__active">
                                <div class="minicart-content-wrapper">
                                    <div class="micart__close">
                                        <span>close</span>
                                    </div>
                                    <div class="items-total d-flex justify-content-between">
                                        <span><span class="product_qun">0</span> item(s)</span>
                                        <span>Cart Subtotal</span>
                                    </div>
                                    <div class="total_amount text-right">
                                        <span>$<span class="total-sum">0.00</span></span>
                                    </div>
<!--                                    <div class="mini_action checkout">-->
<!--                                        <a class="checkout__btn" href="cart.html">Go to Checkout</a>-->
<!--                                    </div>-->
                                    <div class="single__items">
                                        <div class="miniproduct"></div>
                                    </div>
                                    <div class="mini_action">
                                        <a class="cart__btn" href="/cart">View and edit cart</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Shopping Cart -->
                        </li>
                        <li class="setting__bar__icon"><a class="setting__active" href="#"></a>
                            <div class="searchbar__content setting__block">
                                <div class="content-inner">
                                    <div class="switcher-currency">
                                    <strong class="label switcher-label">
                                        <span>My Account</span>
                                    </strong>
                                    <ul class="main-sign">
                                        <?php
                                            if (\App\Components\Auth::isAuth()) {
                                                $userId = \App\Components\Auth::get('user_id');
                                                ?>
                                                <li><a href="/user/<?php echo $userId; ?>">Account</a></li>
                                                <li><a href="/user/logout">Log out</a></li>
                                            <?php
                                            } else {
                                                ?>
                                                <li><span class="cd-signin">Sign in</span></li>
                                                <li><span class="cd-signup">Sign up</span></li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Start Mobile Menu -->
<!--            <div class="row d-none">-->
<!--                <div class="col-lg-12 d-none">-->
<!--                    <nav class="mobilemenu__nav">-->
<!--                        <ul class="meninmenu">-->
<!--                            <li><a href="/">Home</a></li>-->
<!--                            <li><a href="#">Pages</a>-->
<!--                                <ul>-->
<!--                                    <li><a href="about.html">About Page</a></li>-->
<!--                                    <li><a href="portfolio.html">Portfolio</a>-->
<!--                                        <ul>-->
<!--                                            <li><a href="portfolio.html">Portfolio</a></li>-->
<!--                                            <li><a href="portfolio-details.html">Portfolio Details</a></li>-->
<!--                                        </ul>-->
<!--                                    </li>-->
<!--                                    <li><a href="my-account.html">My Account</a></li>-->
<!--                                    <li><a href="cart.html">Cart Page</a></li>-->
<!--                                    <li><a href="checkout.html">Checkout Page</a></li>-->
<!--                                    <li><a href="wishlist.html">Wishlist Page</a></li>-->
<!--                                    <li><a href="error404.html">404 Page</a></li>-->
<!--                                    <li><a href="faq.html">Faq Page</a></li>-->
<!--                                    <li><a href="team.html">Team Page</a></li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                            <li><a href="shop-grid.html">Shop</a>-->
<!--                                <ul>-->
<!--                                    <li><a href="shop-grid.html">Shop Grid</a></li>-->
<!--                                    <li><a href="single-product.html">Single Product</a></li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                            <li><a href="blog.html">Blog</a>-->
<!--                                <ul>-->
<!--                                    <li><a href="blog.html">Blog Page</a></li>-->
<!--                                    <li><a href="blog-details.html">Blog Details</a></li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                            <li><a href="contact.html">Contact</a></li>-->
<!--                        </ul>-->
<!--                    </nav>-->
<!--                </div>-->
<!--            </div>-->
            <!-- End Mobile Menu -->
            <div class="mobile-menu d-block d-lg-none">
            </div>
            <!-- Mobile Menu -->
        </div>
    </header>
    <!-- //Header -->
    <!-- Start Search Popup -->
    <div class="brown--color box-search-content search_active block-bg close__top">
        <form id="search_mini_form" class="minisearch" action="#">
            <div class="field__search">
                <input type="text" placeholder="Search entire store here...">
                <div class="action">
                    <a href="#"><i class="zmdi zmdi-search"></i></a>
                </div>
            </div>
        </form>
        <div class="close__wrap">
            <span>close</span>
        </div>
    </div>
    <!-- End Search Popup -->
