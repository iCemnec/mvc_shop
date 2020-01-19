<?php
$book_title = $args[0]['title'];
\Core\View::render('common/header.php', ['title' => "Book $book_title"]);
$book = $args[0];
?>

<!-- Start main Content -->
<div class="maincontent bg--white pt--80 pb--55">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="wn__single__product">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="wn__fotorama__wrapper">
                                <div class="fotorama wn__fotorama__action" data-nav="thumbs">
                                    <a href="<?php echo $book['image_path']; ?>">
                                        <img src="<?php echo DIR_IMAGE_BOOK . $book['image_path']; ?>" alt="<?php echo $book['title']; ?>">
                                    </a>
<!--                                    <a href="2.jpg"><img src="images/product/2.jpg" alt=""></a>-->
<!--                                    <a href="3.jpg"><img src="images/product/3.jpg" alt=""></a>-->
<!--                                    <a href="4.jpg"><img src="images/product/4.jpg" alt=""></a>-->
<!--                                    <a href="5.jpg"><img src="images/product/5.jpg" alt=""></a>-->
<!--                                    <a href="6.jpg"><img src="images/product/6.jpg" alt=""></a>-->
<!--                                    <a href="7.jpg"><img src="images/product/7.jpg" alt=""></a>-->
<!--                                    <a href="8.jpg"><img src="images/product/8.jpg" alt=""></a>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="product__info__main">
                                <h1><?php echo $book['title']; ?></h1>
                                <div class="product-info-stock-sku d-flex">
                                    <p>Author:
                                        <span>
                                            <a href="/author/<?php echo $book['author_id']; ?>">
                                                <?php echo $book['first_name'] . " "; echo $book['last_name']; ?>
                                            </a>
                                        </span>
                                    </p>
                                </div>
                                <div class="product-info-stock-sku d-flex">
                                    <p>The year of publication: <span><?php echo $book['pub_year']; ?></span></p>
                                </div>
                                <br>
                                <div class="product-info-stock-sku d-flex">
                                    <p>Availability: <span><?php echo $book['quantity'] ? 'In stock' : 'Under the order';?></span></p>
                                    <p>ISBN: <span><?php echo $book['isbn']; ?></span></p>
                                </div>
                                <div class="price-box">
                                    <span><?php echo $book['code_currency'] . " "; echo $book['price']; ?></span>
                                </div>
                                <div class="product__overview">
<!--                                    <p>ISBN: --><?php //echo $book['isbn']; ?><!--</p>-->
                                </div>
                                <div class="box-tocart d-flex">
                                    <span>Qty</span>
                                    <input id="qty" data-quantity="1" class="input-text qty" name="qty" min="1" value="1" title="Qty" max="<?php echo $book['quantity']; ?>" type="number">
                                    <div class="addtocart__actions">
                                        <button class="tocart cart" type="submit" title="Add to Cart"
                                                data-id="<?php echo $book['id']; ?>"
                                                data-title="<?php echo $book['title']; ?>"
                                                data-price="<?php echo $book['price']; ?>"
                                                data-currency="<?php echo $book['code_currency']; ?>"
                                                data-image-path="<?php echo DIR_IMAGE_BOOK . $book['image_path']; ?>"
                                        >Add to Cart</button>
                                    </div>
                                </div>
                                <div class="product_meta">
                                    <?php
                                    if (!empty($args[1])) {
                                        ?>
                                        <div class="posted_in">Categories: </div>
                                        <?php
                                        foreach ($args[1] as $genre) {
                                            ?>
                                            <p><a href="/catalog/<?php echo (int)$genre['id']; ?>/"><?php echo $genre['title']; ?></a></p>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__info__detailed">
                    <div class="description__attribute">
                        <?php echo $book['description']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
\Core\View::render('common/footer.php');
