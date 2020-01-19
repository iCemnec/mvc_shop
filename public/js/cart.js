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
        e.preventDefault();
        let id = e.target.dataset.id;
        // console.log(id);
        CART.remove(id);
    });

    // $('.plus').on('click', (e) => {
    //     incrementCart(e);
    // });
    //
    // $('.minus').on('click', (e) => {
    //     decrementCart(e);
    // });


});

const CART = {
    contents: [],
    init() {
        //check localStorage and initialize the contents of CART.contents
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
    count(books) {
        let amount = Number(0);
        let sum = Number(0);

        for (let i = 0; i < books.length; i++) {
            amount += books[i].bookQty;
            sum += Number(books[i].bookPrice * books[i].bookQty);
        }

        $('.product_qun').html(amount);
        $('.total-sum').html(sum);
    },
    sync() {
        localStorage.setItem('books', JSON.stringify(CART.contents));
        CART.init();
    },
    find(id) {
        let math = CART.contents.filter(book => {
            if (book.bookId === id) {
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
        }
    },
    increase(id, bookQty=1) {
        CART.contents = CART.contents.map(item => {
            if (item.bookId === id) {
                item.bookQty += bookQty;
            }
            return item;
        });
        //update localStorage
        CART.sync();
    },
    reduce(id, bookQty=1) {
        CART.contents = CART.contents.map(item => {
            if (item.bookId === id) {
                item.bookQty -= bookQty;
            }
            return item;
        });
        // CART.contents.forEach(item => {
        //     if (item.bookId === id && item.bookQty === 0) {
        //         CART.remove(id);
        //     }
        // });
        //update localStorage
        CART.sync();
    },
    remove(id) {
        CART.contents = CART.contents.filter(item => {
            if (item.bookId !== id) {
                return true;
            }
        });
        //update localStorage
        CART.sync();
    },
    empty(){
        //empty whole cart
        CART.contents = [];
        //update localStorage
        CART.sync()
    }
};

const PageCart = {
    init() {
        //check localStorage and initialize the contents of PageCart.contents
        let books = JSON.parse(localStorage.getItem('books'));

        if (books) {
            $('#cart-table').html(renderTableCar(books));
            PageCart.count(books);
        }
    },
    count(books) {
        let sum = Number(0);

        for (let i = 0; i < books.length; i++) {
            sum += Number(books[i].bookPrice * books[i].bookQty);
        }

        $('.cart-total-sum').html(sum);
    },
};

const renderMiniCartItem = row => `
    <div class="item01 d-flex mt--20">
        <div class="thumb">
            <a href="/book/${ row.bookId }"><img src=${ row.bookImagePath } alt=${ row.bookTitle }></a>
        </div>
        <div class="content">
            <h6><a href="/book/${ row.bookId }">${ row.bookTitle }</a></h6>
            <span class="prize">${ row.bookCurrency }${ row.bookPrice * row.bookQty }</span>
            <div class="product_prize d-flex justify-content-between controls">
<!--                <span data-id=${ row.bookId } class="minus">-</span>-->
                <span class="qun">Qty: <span class="qty">${ row.bookQty }</span></span>
<!--                <span data-id=${ row.bookId } class="plus">+</span>-->
                <ul class="d-flex justify-content-end">
                    <li><a href="/book/${ row.bookId }"><i class="zmdi zmdi-settings"></i></a></li>
                    <li><i data-id=${ row.bookId } class="zmdi zmdi-delete"></i></li>
                </ul>
            </div>
        </div>
    </div>
    `;

const renderMiniCartBody = rows => rows.map(row => renderMiniCartItem(row)).join(' ');

// function incrementCart(ev){
//     // ev.preventDefault();
//     let id = parseInt(ev.target.getAttribute('data-id'));
//     console.log(id);
//     // CART.increase(id, 1);
// }

// function decrementCart(ev){
//     // ev.preventDefault();
//     let id = parseInt(ev.target.getAttribute('data-id'));
//     // console.log(id);
//     CART.reduce(id, 1);
// }


    const renderCartTableRow = row => `
    <tr>
        <td class="product-thumbnail"><a href="/book/${ row.bookId }"><img src=${ row.bookImagePath } alt=${ row.bookTitle }></a></td>
        <td class="product-name"><a href="/book/${ row.bookId }">${ row.bookTitle }</a></td>
        <td class="product-price"><span class="amount">${ row.bookCurrency }${ row.bookPrice }</span></td>
        <td class="product-quantity"><input type="number" value="${ row.bookQty }"></td>
        <td class="product-subtotal">${ row.bookCurrency }${ row.bookPrice * row.bookQty }</td>
        <td class="product-remove"><a href="#">X</a></td>
    </tr>
    `;

    const renderCartTableBody = rows => rows.map(row => renderCartTableRow(row)).join(' ');

const renderTableCar = (books) => `
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

