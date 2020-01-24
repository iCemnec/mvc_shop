$(document).ready(() => {
    let formModal = $('.cd-user-modal'),
        formLogin = formModal.find('#cd-login'),
        formSignup = formModal.find('#cd-signup'),
        formModalTab = $('.cd-switcher'),
        tabLogin = formModalTab.children('li').eq(0).children('a'),
        tabSignup = formModalTab.children('li').eq(1).children('a'),
        settingContainer = $('.setting__block'),
        mainSign = $('.main-sign');

    const login_selected = () => {
        mainSign.children('ul').removeClass('is-visible');
        formModal.addClass('is-visible');
        formLogin.addClass('is-selected');
        formSignup.removeClass('is-selected');
        tabLogin.addClass('selected');
        tabSignup.removeClass('selected');
        settingContainer.removeClass('is-visible');
    };

    const signup_selected = () => {
        mainSign.children('ul').removeClass('is-visible');
        formModal.addClass('is-visible');
        formLogin.removeClass('is-selected');
        formSignup.addClass('is-selected');
        tabLogin.removeClass('selected');
        tabSignup.addClass('selected');
        settingContainer.removeClass('is-visible');
    };

    //open modal
    mainSign.on('click', (e) => {
        $(e.target).is(mainSign) && mainSign.children('ul').toggleClass('is-visible');
    });

    //open sign-up form
    mainSign.on('click', '.cd-signup', signup_selected);
    //open login-form form
    mainSign.on('click', '.cd-signin', login_selected);

    //close modal
    formModal.on('click', (e) => {
        if( $(e.target).is(formModal) || $(e.target).is('.cd-close-form') ) {
            formModal.removeClass('is-visible');
        }
    });
    //close modal when clicking the esc keyboard button
    $(document).keyup(function(e){
        if(e.which=='27'){
            formModal.removeClass('is-visible');
            $('.setting__block').removeClass('is-visible');
        }
    });

    //switch from a tab to another
    formModalTab.on('click', (e) => {
        e.preventDefault();
        ( $(e.target).is( tabLogin ) ) ? login_selected() : signup_selected();
    });

    $('#signup-username').unbind().blur( function() {
        let val = $(this).val();
        let rv_name = /^[a-zA-Zа-яА-Я0-9_]+$/;
        if (val.length <= 2 || !rv_name.test(val)) {
            $(this).addClass('has-error').next('span').addClass('is-visible');
        } else {
            $(this).removeClass('has-error').next('span').removeClass('is-visible');
        }
    });

    $('#signup-email, #signin-email').unbind().blur( function() {
        let val = $(this).val();
        let rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
        if (val == '' || !rv_email.test(val)) {
            $(this).addClass('has-error').next('span').addClass('is-visible');
        } else {
            $(this).removeClass('has-error').next('span').removeClass('is-visible');
        }
        $(this).removeClass('has-error').next().next('span').removeClass('is-visible');
    });

    $('#signup-password, #signin-password').unbind().blur( function() {
        let val = $(this).val();
        if (val.length < 6) {
            $(this).addClass('has-error').next('span').addClass('is-visible');
        } else {
            $(this).removeClass('has-error').next('span').removeClass('is-visible');
        }
    });


    $('#cd-signup').on('submit', (e) => {
        e.preventDefault();
        let username = $('#signup-username').val();
        let email = $('#signup-email').val();
        let password = $('#signup-password').val();

        $.ajax({
            url: '/user/store',
            type: 'POST',
            data: {
                username: username,
                email: email,
                password: password
            },
            error: (error) => console.log(error),
            success: (response) => {
                let result = JSON.parse(response);
                if (result['status'] === 'success') {
                    formModal.removeClass('is-visible');
                    mainSign.html(`
                        <li><a href="/user/${ result['id'] }">Account</a></li>
                        <li><a href="/user/${ result['id'] }/logout">Log out</a></li>
                    `);
                } else {
                    $('#signup-email').addClass('has-error').next().next('span').addClass('is-visible');
                }
            }
        });

    });

    $('#cd-login').on('submit', (e) => {
        e.preventDefault();
        let email = $('#signin-email').val();
        let password = $('#signin-password').val();

        $.ajax({
            url: '/user/login',
            type: 'POST',
            data: {
                email: email,
                password: password
            },
            error: (error) => console.log(error),
            success: (response) => {
                console.log(response);
                let result = JSON.parse(response);
                console.log(result);
                if (result['status'] === 'success') {
                    formModal.removeClass('is-visible');
                    mainSign.html(`
                        <li><a href="/user/${ result['id'] }">Account</a></li>
                        <li><a href="/user/${ result['id'] }/logout">Log out</a></li>
                    `);
                } else {
                    $('#signup-email').addClass('has-error').next().next('span').addClass('is-visible');
                }
            }
        });

    });

});
