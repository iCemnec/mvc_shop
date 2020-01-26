<?php
\Core\View::render('common/header.php', ['title' => 'Login']);
?>

    <section class="my_account_area pt--80 pb--55 bg--white">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div id="cd-admin-login" class="my__account__wrapper">
                        <h3 class="account__title">Login</h3>
                        <form class="cd-form" method="post" name="loginAdminForm">
                            <div class="account__form">
                                <div class="input__box fieldset">
                                    <label for="admin-login-email">Email address <span>*</span></label>
                                    <input id="admin-login-email" class="full-width has-border" type="text" placeholder="E-mail">
                                    <span class="cd-error-message">Enter the correct email!</span>
                                </div>
                                <div class="input__box fieldset">
                                    <label for="admin-login-password">Password <span>*</span></label>
                                    <input id="admin-login-password" class="full-width has-border" type="password" placeholder="Password">
                                    <span class="cd-error-message">The password should be more than 6 symbols!</span>
                                </div>
                                <div class="form__btn">
                                    <input id="admin-login" type="submit" value="Login">
                                </div>
<!--                                <a class="forget_pass" href="#">Lost your password?</a>-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
\Core\View::render('common/footer.php');