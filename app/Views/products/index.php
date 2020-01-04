<?php
\Core\View::render('common/header.php', ['title' => 'Show All Products']);
?>

<div class="row justify-content-center">
    <div class="col-md-12">
        <h1 class="text-center">All products</h1>
    </div>
    <div class="col-md-12">
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <?php
                    foreach ($args as $product) {
                        ?>
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <img src="<?php echo DIR_IMAGE_PRODUCT . $product['img'];?>" alt="<?php echo $product['title'];?>" class="card-img-top">
                                <div class="card-body">
                                    <p class="card-title"><?php echo $product['title'];?></p>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p>Price:
                                            <span class="text-muted"><?php echo $product['price']; echo $product['currency'];?></span>
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p>Quantity:
                                            <span class="text-muted"><?php echo $product['quantity'];?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
\Core\View::render('common/footer.php');
