<?php
\Core\View::render('common/header.php', ['title' => 'Account']);
$user = $args;
?>

    <!-- Start Checkout Area -->
    <section class="wn__checkout__area section-padding--lg bg__white">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-6 md-mt-40 sm-mt-40">
                    <div class="my__account__wrapper">
                        <h3 class="account__title">Account details</h3>
                        <div class="account__form">
                            <ul class="order_product">
                                <li>First name<span><?php echo $user['first_name'] ? $user['first_name'] : 'None'; ?></span></li>
                                <li>Last name<span><?php echo $user['last_name'] ? $user['last_name'] : 'None'; ?></span></li>
                                <li>Email<span><?php echo $user['email']; ?></span></li>
                                <li>Phone<span><?php echo $user['phone'] ? $user['phone'] : 'None'; ?></span></li>
                            </ul>
                            <div class="form__btn">
                                <a href="/user/<?php echo $user['id']; ?>/edit"><button>Edit</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Checkout Area -->

<?php
\Core\View::render('common/footer.php');
