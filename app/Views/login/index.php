<?php
\Core\View::render('common/header.php', ['title' => 'Login']);

?>

    <main>
        <div class="container container-main">
            <form method="post" name="loginForm" class="login-form" action="login/welcome">
                <div class="form-group">
                    <label for="inputLogin">Login</label>
                    <input type="text" class="form-control" name="login" id="inputLogin" placeholder="Enter login">
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" class="form-control" name="pass" id="inputPassword"
                           placeholder="Password">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>

<?php
\Core\View::render('common/footer.php');
