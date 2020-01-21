$(document).ready(() => {

    CART.init();
    PageCart.init();

    $('.cart').on('click', (e) => {
        e.preventDefault();
        let bookId = e.target.parentNode.dataset.id || e.target.dataset.id;
        let bookTitle = e.target.parentNode.dataset.title || e.target.dataset.title;
        let bookPrice = e.target.parentNode.dataset.price || e.target.dataset.price;
        let bookCurrency = e.target.parentNode.dataset.currency || e.target.dataset.currency;
        let bookImagePath = e.target.parentNode.dataset.imagePath || e.target.dataset.imagePath;
        let bookQty = Number($('#qty').attr('data-quantity')) || 1;

        let book = {
            bookId: bookId,
            bookTitle: bookTitle,
            bookPrice: bookPrice,
            bookCurrency: bookCurrency,
            bookImagePath: bookImagePath,
            bookQty: bookQty
        };

        CART.add(book, bookQty);
    });

    $('#qty').on('change', (e) => {
        $('#qty').attr('data-quantity', e.target.value);
    });

    $('.zmdi-delete').on('click', (e) => {
        let id = e.target.dataset.id;
        CART.remove(id);
    });

    $('.plus').on('click', (e) => {
        let id = parseInt(e.target.dataset.id);
        CART.increase(id, 1);
    });

    $('.minus').on('click', (e) => {
        let id = parseInt(e.target.getAttribute('data-id'));
        CART.reduce(id, 1);
    });

    $('.product-quantity').on('change', (e) => {
        let id = parseInt(e.target.dataset.id);
        let previousQty = parseInt(e.target.dataset.quantity);
        let currentQty = parseInt(e.target.value);
        let subTotal = `.product-subtotal[data-id=${ id }]`;
        $('.product-quantity .cart-qty').attr('data-quantity', e.target.value);

        let item = CART.find(id);
        let difference = currentQty - previousQty;
        let qty = Math.abs(difference);
        if (difference > 0) {
            CART.increase(id, qty);
        } else if (difference < 0) {
            CART.reduce(id, qty);
        }
        $(subTotal).html(item.bookCurrency+(currentQty*item.bookPrice).toFixed(2));
        CART.sync();
        CART.update(id);
        CART.count();
    });

    $('.delete-product').on('click', (e) => {
        let id = parseInt(e.target.dataset.id);
        console.log(id);
        CART.remove(id);
        PageCart.init();
    });

});

const CART = {
    contents: (JSON.parse(localStorage.getItem('books')) ? JSON.parse(localStorage.getItem('books')) : []),
    init() {
        let books = JSON.parse(localStorage.getItem('books'));

        if (books) {
            CART.count(books);

            const miniCartHTML = `
                <div class="miniproduct">
                    ${ renderMiniCartBody(books) }
                </div>
            `;

            $('.single__items').html(miniCartHTML);
        }
    },
    count() {
        let books = JSON.parse(localStorage.getItem('books'));
        let amount = Number(0);
        let sum = Number(0);

        for (let i = 0; i < books.length; i++) {
            amount += books[i].bookQty;
            sum += Number(books[i].bookPrice * books[i].bookQty);
        }

        sum = ((sum * 100) / 100).toFixed(2);

        $('.product_qun').html(amount);
        $('.total-sum').html(sum);
        $('.cart-total-sum').html(sum);
    },
    sync() {
        localStorage.setItem('books', JSON.stringify(CART.contents));
    },
    find(id) {
        let math = CART.contents.filter(book => {
            if (book.bookId == id) {
                return true;
            }
        });
        if (math && math[0]) {
            return math[0];
        }
    },
    add(book, bookQty) {
        //add a new item to the cart
        //and check that it is not in the cart already
        let books = JSON.parse(localStorage.getItem('books'));
        if (books) {
            CART.contents = books;
            //update localStorage
            CART.sync();
        }
        if (CART.find(book.bookId)) {
            CART.increase(book.bookId, bookQty);
        } else {
            CART.contents = [...CART.contents, book];
            //update localStorage
            CART.sync();
            CART.init();
        }
        CART.count();
    },
    increase(id, bookQty=1) {
        CART.contents = CART.contents.map(item => {
            if (item.bookId == id) {
                item.bookQty += bookQty;
            }
            return item;
        });
        //update localStorage
        CART.sync();
        CART.count();
        CART.update(id);
    },
    reduce(id, bookQty=1) {
        CART.contents = CART.contents.map(item => {
            if (item.bookId == id) {
                item.bookQty -= bookQty;
            }
            return item;
        });
        CART.contents.forEach(item => {
            if (item.bookId == id && item.bookQty == 0) {
                CART.remove(id);
            }
        });
        //update localStorage
        CART.sync();
        CART.count();
        CART.update(id);
    },
    remove(id) {
        CART.contents = CART.contents.filter(item => {
            if (item.bookId !== id) {
                return true;
            }
        });
        //update localStorage
        CART.sync();
        CART.init();
    },
    update(id) {
        let $qtySelector = `.controls .qty[data-id=${ id }]`;
        let $priceSelector = `.content .prize[data-id=${ id }]`;
        let $qtyCartSelector = `.product-quantity .cart-qty[data-id=${ id }]`;

        let itemCart = CART.find(id);
        $($qtySelector).html(itemCart.bookQty);
        $($qtyCartSelector).attr('data-quantity', itemCart.bookQty);
        $($qtyCartSelector).attr('value', itemCart.bookQty);
        $($priceSelector).html(itemCart.bookCurrency+(itemCart.bookQty*itemCart.bookPrice).toFixed(2));


    }
};

const PageCart = {
    init() {
        //check localStorage and initialize the contents of PageCart.contents
        let books = JSON.parse(localStorage.getItem('books'));
        if (books.length != 0) {
            $('#cart-table').html(renderTableCart(books));
            PageCart.count(books);
        } else {
            $('#cart-table').html(renderEmptyCart());
        }
    },
    count() {
        let books = JSON.parse(localStorage.getItem('books'));
        let sum = Number(0);

        for (let i = 0; i < books.length; i++) {
            sum += Number(books[i].bookPrice * books[i].bookQty);
        }

        sum = ((sum * 100) / 100).toFixed(2);

        $('.cart-total-sum').html(sum);
    },
    change(id) {

    }
};

const renderMiniCartItem = row => `
    <div class="item01 d-flex mt--20">
        <div class="thumb">
            <a href="/book/${ row.bookId }"><img src=${ row.bookImagePath } alt=${ row.bookTitle }></a>
        </div>
        <div class="content">
            <h6><a href="/book/${ row.bookId }">${ row.bookTitle }</a></h6>
            <span class="prize" data-id=${ row.bookId }>${ row.bookCurrency }${ (row.bookPrice * row.bookQty).toFixed(2) }</span>
            <div class="product_prize d-flex justify-content-between controls">
                <span data-id=${ row.bookId } class="minus">-</span>
                <span class="qun">Qty: <span  data-id=${ row.bookId } class="qty">${ row.bookQty }</span></span>
                <span data-id=${ row.bookId } class="plus">+</span>
                <ul class="d-flex justify-content-end">
                    <li><a href="/book/${ row.bookId }"><i class="zmdi zmdi-settings"></i></a></li>
                    <li><i data-id=${ row.bookId } class="zmdi zmdi-delete"></i></li>
                </ul>
            </div>
        </div>
    </div>
    `;

const renderMiniCartBody = rows => rows.map(row => renderMiniCartItem(row)).join(' ');

const renderCartTableRow = row => `
    <tr>
        <td class="product-thumbnail"><a href="/book/${ row.bookId }"><img src=${ row.bookImagePath } alt=${ row.bookTitle }></a></td>
        <td class="product-name"><a href="/book/${ row.bookId }">${ row.bookTitle }</a></td>
        <td class="product-price"><span class="amount" data-id=${ row.bookId }>${ row.bookCurrency }${ row.bookPrice }</span></td>
        <td class="product-quantity"><input type="number" class="cart-qty" data-id=${ row.bookId } data-quantity="${ row.bookQty }" value="${ row.bookQty }"></td>
        <td class="product-subtotal" data-id=${ row.bookId }>${ row.bookCurrency }${ row.bookPrice * row.bookQty }</td>
        <td class="product-remove"><span class="delete-product" data-id=${ row.bookId }>X</span></td>
    </tr>
    `;

const renderCartTableBody = rows => rows.map(row => renderCartTableRow(row)).join(' ');

const renderTableCart = (books) => `
            <div class="row">
                <div class="col-md-12 col-sm-12 ol-lg-12">
                    <form action="#">
                        <div class="table-content wnro__table table-responsive">
                            <table>
                                <thead>
                                    <tr class="title-top">
                                        <th class="product-thumbnail">Image</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${ renderCartTableBody(books) }
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="cartbox__btn">
                        <ul class="cart__btn__list d-flex flex-wrap flex-md-nowrap flex-lg-nowrap justify-content-between">
                            <li><a href="/catalog">Continue shopping</a></li>
                            <li><a href="#">Check Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-6">
                    <div class="cartbox__total__area">
                        <div class="cart__total__amount">
                            <span>Total</span>
                            <span>$<span class="cart-total-sum"> 0</span></span>
                        </div>
                    </div>
                </div>
            </div>
    `;

const renderEmptyCart = () => `
    <div class="row">
        <div class="col-md-12 col-sm-12 ol-lg-12">
            <div class="empty-cart-content">
                <p class="d-flex flex-wrap justify-content-center">Empty cart.</p>
            </div>
            <div class="cartbox__btn">
                <ul class="cart__btn__list d-flex flex-wrap flex-md-nowrap flex-lg-nowrap justify-content-between">
                    <li><a href="/catalog">Continue shopping</a></li>
                </ul>
            </div>
        </div>
    </div>
`;
