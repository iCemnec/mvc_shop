<?php
\Core\View::render('common/header.php', ['title' => 'Edit account']);
$user = $args;
?>

    <!-- Start Checkout Area -->
    <section class="wn__checkout__area section-padding--lg bg__white">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-6 md-mt-40 sm-mt-40">
                    <div class="my__account__wrapper">
                        <h3 class="account__title">Edit account</h3>
                        <form action="#">
                            <div class="account__form">
                                <div class="input__box">
                                    <label>First name <span>*</span></label>
                                    <input type="text" value="<?php echo $user['first_name']; ?>">
                                </div>
                                <div class="input__box">
                                    <label>Last name</label>
                                    <input type="text" value="<?php echo $user['last_name']; ?>">
                                </div>
                                <div class="input__box">
                                    <label>Email address <span>*</span></label>
                                    <input type="email" value="<?php echo $user['email']; ?>">
                                </div>
                                <div class="input__box">
                                    <label>Phone</label>
                                    <input type="tel" value="<?php echo $user['phone']; ?>">
                                </div>
                                <div class="input__box">
                                    <label>Password <span>*</span></label>
                                    <input type="password">
                                </div>
                                <div class="form__btn">
                                    <a href="/user/<?php echo $user['id']; ?>/update"><button>Edit</button></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Checkout Area -->

<?php
\Core\View::render('common/footer.php');
