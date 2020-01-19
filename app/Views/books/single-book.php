<?php
$book = $args;
?>
<!-- Start Single Product -->
<div class="product product__style--3 col-lg-4 col-md-4 col-sm-6 col-12">
    <div class="product__thumb">
        <a class="first__img" href="/book/<?php echo $book['id']; ?>"><img src="<?php echo DIR_IMAGE_BOOK . $book['image_path']; ?>" alt="<?php echo $book['title']; ?>"></a>
<!--        <a class="second__img animation1" href="/book/--><?php //echo $book['id']; ?><!--"><img src="--><?php //echo DIR_IMAGE_BOOK . $book['image_path']; ?><!--" alt="--><?php //echo $book['title']; ?><!--"></a>-->
        <div class="hot__box">
            <span class="hot-label">HOT</span>
        </div>
    </div>
    <div class="product__content content--center">
        <h4><a href="/book/<?php echo $book['id']; ?>"><?php echo $book['first_name'] . " "; echo $book['last_name']; ?></a></h4>
        <h4><a href="/book/<?php echo $book['id']; ?>"><?php echo $book['title']; ?></a></h4>
        <ul class="prize d-flex">
            <li><?php echo $book['code_currency']; ?> <span><?php echo $book['price']; ?></span></li>
        </ul>
        <div class="action">
            <div class="actions_inner">
                <ul class="add_to_links">
                    <li>
                        <a class="cart"
                           data-id="<?php echo $book['id']; ?>"
                           data-title="<?php echo $book['title']; ?>"
                           data-price="<?php echo $book['price']; ?>"
                           data-currency="<?php echo $book['code_currency']; ?>"
                           data-image-path="<?php echo DIR_IMAGE_BOOK . $book['image_path']; ?>"
                           href="/cart.html"><i class="bi bi-shopping-bag4"></i>
                        </a>
                    </li>
<!--                    <li><a data-toggle="modal" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"><i class="bi bi-search"></i></a></li>-->
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Single Product -->
