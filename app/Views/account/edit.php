<?php
\Core\View::render('common/header.php', ['title' => 'Edit account']);
$user = $args;
?>

    <!-- Start Account Edit Area -->
    <section class="wn__checkout__area section-padding--lg bg__white">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-6 md-mt-40 sm-mt-40">
                    <div class="my__account__wrapper">
                        <h3 class="account__title">Edit account</h3>
                        <form class="cd-form" action="" method="post" name="loginFormEdit">
                            <input id="account-edit-id" type="hidden" value="<?php echo $user['id']; ?>">
                            <div class="account__form">
                                <div class="input__box fieldset">
                                    <label for="account-edit-first-name">First name <span>*</span></label>
                                    <input class="full-width has-border" id="account-edit-first-name" type="text" value="<?php echo $user['first_name']; ?>" placeholder="First name">
                                    <span class="cd-error-message">Letters, numbers or _ and more than 2!</span>
                                </div>
                                <div class="input__box fieldset">
                                    <label for="account-edit-last-name">Last name</label>
                                    <input class="full-width has-border" id="account-edit-last-name" type="text" value="<?php echo $user['last_name']; ?>" placeholder="Last name">
                                </div>
                                <div class="input__box fieldset">
                                    <label for="account-edit-email">Email address <span>*</span></label>
                                    <input class="full-width has-border" id="account-edit-email" type="email" value="<?php echo $user['email']; ?>" placeholder="E-mail">
                                    <span class="cd-error-message">Enter the correct email!</span>
                                </div>
                                <div class="input__box fieldset">
                                    <label for="account-edit-phone">Phone</label>
                                    <input class="full-width has-border" id="account-edit-phone" type="tel" value="<?php echo $user['phone']; ?>" placeholder="Phone">
                                </div>
                                <div class="input__box fieldset">
                                    <label for="account-edit-password">Enter your password for change <span>*</span></label>
                                    <input class="full-width has-border" id="account-edit-password" type="password" placeholder="Password">
                                    <span class="cd-error-message">The password should be more than 6 symbols!</span>
                                    <span class="cd-error-message cd-error-message-wrong">The password is incorrect!</span>
                                </div>
                                <div class="form__btn">
                                    <input id="account-edit" class="full-width" type="submit" value="Edit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Account Edit Area -->

<?php
\Core\View::render('common/footer.php');
