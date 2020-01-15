<?php
\Core\View::render('common/header.php', ['title' => 'Books Genre']);
?>

    <!-- Start Best Seller Area -->
    <section class="wn__product__area brown--color pt--80  pb--30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section__title text-center">
                        <h2 class="title__be--2">New <span class="color--theme">Products</span></h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered lebmid alteration in some ledmid form</p>
                    </div>
                </div>
            </div>

            <!-- Start Single Tab Content -->
            <div class="furniture--4 border--round arrows_style owl-carousel owl-theme row mt--50">
                <!--    <div class="row">-->

                <?php
                if (!empty($args)) {
                    foreach ($args as $book) {
                        ?>
                        <div class="product product__style--3">
                            <!-- Start Single Product -->
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                <div class="product__thumb">
                                    <a class="first__img" href="#"><img src="<?php echo DIR_IMAGE_BOOK . $book['image_path']; ?>" alt="<?php echo $book['title']; ?>"></a>
                                    <a class="second__img animation1" href="#"><img src="<?php echo DIR_IMAGE_BOOK . $book['image_path']; ?>" alt="<?php echo $book['title']; ?>"></a>
                                    <div class="hot__box">
                                        <span class="hot-label">NEW</span>
                                    </div>
                                </div>
                                <div class="product__content content--center">
                                    <h5><a href="#"><?php echo $book['first_name'] . " "; echo $book['last_name']; ?></a></h5>
                                    <h4><a href="#"><?php echo $book['title']; ?></a></h4>
                                    <ul class="prize d-flex">
                                        <li><?php echo $book['code_currency'] . " "; echo $book['price']; ?></li>
                                    </ul>
                                    <div class="action">
                                        <div class="actions_inner">
                                            <ul class="add_to_links">
                                                <li><a class="cart" href="cart.html"><i class="bi bi-shopping-bag4"></i></a></li>
                                                <li><a data-toggle="modal" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                        <?php
                    }
                }
                ?>

            </div>
            <!-- End Single Tab Content -->
        </div>
    </section>

<?php
\Core\View::render('common/footer.php');
