<?php
\Core\View::render('common/header.php', ['title' => 'Welcome']);
?>

    <main>
        <div class="container container-main">
            <h4>Hello, <?php echo $login;?></h4>
        </div>
    </main>

<?php
\Core\View::render('common/footer.php');
