<?php
\Core\View::render('common/header.php', ['title' => 'Books eCommerce Store']);
?>

    <!-- Start Best Seller Area -->
    <section class="wn__product__area brown--color pt--80 pb--30">
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
        <?php
            if (!empty($args)) {
                foreach ($args as $book) {
                    \Core\View::render('books/single-book.php', $book);
                }
            }
        ?>
    </div>
    <!-- End Single Tab Content -->
    </section>

<?php
\Core\View::render('common/footer.php');
