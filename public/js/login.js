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
        }
    });

    //switch from a tab to another
    formModalTab.on('click', (e) => {
        e.preventDefault();
        ( $(e.target).is( tabLogin ) ) ? login_selected() : signup_selected();
    });


    //show error messages
    formLogin.find('input[type="submit"]').on('click', (e) => {
        e.preventDefault();
        formLogin.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
    });
    formSignup.find('input[type="submit"]').on('click', (e) => {
        e.preventDefault();
        formSignup.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
    });

});
