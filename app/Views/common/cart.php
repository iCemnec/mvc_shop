<?php
\Core\View::render('common/header.php', ['title' => "Cart"]);
?>

    <!-- cart-main-area start -->
    <div class="cart-main-area section-padding--lg bg--white">
        <div class="container">
            <div id="cart-table"></div>
        </div>
    </div>
    <!-- cart-main-area end -->

<?php
\Core\View::render('common/footer.php');

