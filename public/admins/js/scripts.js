/*!
    * Start Bootstrap - SB Admin v6.0.0 (https://startbootstrap.com/templates/sb-admin)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    (function($) {
    "use strict";

    // Add active state to sidebar nav links
    let path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

        $('#genre-edit-title, #genre-create-title').unbind().blur( function() {
            let val = $(this).val();
            let rv_name = /^[a-zA-Zа-яА-Я0-9& ]+$/;
            if (val.length <= 2 || !rv_name.test(val)) {
                $(this).addClass('has-error').next('span').addClass('is-visible');
            } else {
                $(this).removeClass('has-error').next('span').removeClass('is-visible');
            }
        });

        $('#genre-edit').on('click', (e) => {
            e.preventDefault();
            let userId = $('#genre-edit-user-id').val();
            let genreId = $('#genre-edit-id').val();
            let genreTitle = $('#genre-edit-title').val();

            $.ajax({
                url: `/admin/genre/${ genreId }/update`,
                type: 'POST',
                data: {
                    userId: userId,
                    genreId: genreId,
                    genreTitle: genreTitle
                },
                error: (error) => console.log(error),
                success: (response) => {
                    let result = JSON.parse(response);
                    if (result['status'] === 'success') {
                        window.location.href = '/admin/genre/';
                    }
                }
            });
        });

        $('#genre-create').on('click', (e) => {
            e.preventDefault();
            let userId = $('#genre-create-user-id').val();
            let genreTitle = $('#genre-create-title').val();

            $.ajax({
                url: '/admin/genre/store',
                type: 'POST',
                data: {
                    userId: userId,
                    genreTitle: genreTitle
                },
                error: (error) => console.log(error),
                success: (response) => {
                    let result = JSON.parse(response);
                    if (result['status'] === 'success') {
                        window.location.href = '/admin/genre/';
                    }
                }
            });
        });

        $('#genre-delete').on('click', (e) => {
            e.preventDefault();
            let genreId = $('#genre-delete-id').val();
            let userId = $('#genre-delete-user-id').val();
            let genreTitle = $('#genre-delete-title').val();

            $.ajax({
                url: `/admin/genre/${ genreId }/destroy`,
                type: 'POST',
                data: {
                    userId: userId,
                    genreId: genreId,
                    genreTitle: genreTitle
                },
                error: (error) => console.log(error),
                success: (response) => {
                    console.log(response);
                    let result = JSON.parse(response);
                    console.log(result);
                    if (result['status'] === 'success') {
                        window.location.href = '/admin/genre/';
                    } else {
                        $('#genre-delete-title').addClass('has-error').next('span').addClass('is-visible');
                    }
                }
            });
        });


})(jQuery);
