<?php
$currentAuthor = $args[1]['first_name'] . " " . $args[1]['last_name'];
\Core\View::render('common/header.php', ['title' => "Author $currentAuthor"]);
?>

    <div class="page-shop-sidebar left--sidebar bg--white section-padding--lg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 order-2 order-lg-1 md-mt-40 sm-mt-40">
                    <div class="shop__sidebar">
                        <aside class="wedget__categories poroduct--cat">
                            <h3 class="wedget__title">Book Genres</h3>
                            <ul>
                                <?php
                                if (!empty($args[0])) {
                                    foreach ($args[0] as $genre) {
                                        ?>
                                        <li><a href="/catalog/<?php echo (int)$genre['id']; ?>/"><?php echo $genre['title']; ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </aside>
                        <aside class="wedget__categories pro--range">
                            <h3 class="wedget__title">Filter by price</h3>
                            <div class="content-shopby">
                                <div class="price_filter s-filter clear">
                                    <form action="#" method="GET">
                                        <div id="slider-range"></div>
                                        <div class="slider__range--output">
                                            <div class="price__output--wrap">
                                                <div class="price--output">
                                                    <span>Price :</span><input type="text" id="amount" readonly="">
                                                </div>
                                                <div class="price--filter">
                                                    <a href="#">Filter</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
                <div class="col-lg-9 col-12 order-1 order-lg-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section__title text-center">
                                <h2 class="title__be--2">Author: <span class="color--theme"><?php echo $currentAuthor; ?></span></h2>
                            </div>
                            <div class="section__title text-left">
                                <p><?php echo $args[1]['description']; ?></p>
                            </div>
                            <br>
                        </div>
                        <div class="col-lg-12">
                            <div class="shop__list__wrapper d-flex flex-wrap flex-md-nowrap justify-content-between">
                                <div class="shop__list nav justify-content-center" role="tablist">
                                    <a class="nav-item nav-link active" data-toggle="tab" href="#nav-grid" role="tab"><i class="fa fa-th"></i></a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#nav-list" role="tab"><i class="fa fa-list"></i></a>
                                </div>
                                <p>Showing 1–12 of 40 results</p>
                                <div class="orderby__wrapper">
                                    <span>Sort By</span>
                                    <select class="shot__byselect">
                                        <option>Default sorting</option>
                                        <option>HeadPhone</option>
                                        <option>Furniture</option>
                                        <option>Jewellery</option>
                                        <option>Handmade</option>
                                        <option>Kids</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab__container">
                        <div class="shop-grid tab-pane fade show active" id="nav-grid" role="tabpanel">
                            <div class="row">
                                <?php
                                if (!empty($args[2])) {
                                    foreach ($args[2] as $book) {
                                        \Core\View::render('books/single-book.php', $book);
                                    }
                                } else {
                                    ?>
                                    <div class="section__title text-center">
                                        <h2 class="title__be--2">No <span class="color--theme">Books</span></h2>
                                        <p>There are no books in this genre.</p>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <ul class="wn__pagination">
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
\Core\View::render('common/footer.php');
