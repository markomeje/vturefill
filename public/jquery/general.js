(function($) {

    'use strict';

    var inputs = $('input[type="text"], input[type="email"], input[type="password"], input[type="tel"], input[type="number"]');
    inputs.attr('autocomplete', 'off');
    $(window).on('shown.bs.modal', function() {
        inputs.attr('autocomplete', 'off');
    });
    
    $('.toggle-right-sidebar').on('click', function() {
        $('.right-sidebar').toggleClass('sidebar-right');
        $('.backend-menu').toggleClass('open');
    });

    $('.navbar-menu').on('click', function() {
        $('.navbar-mobile').toggleClass('navbar-toggle');
        $('.navbar-menu').toggleClass('slide');
    });

    if ($('.navbar-mobile').length) {
        var target = '.navbar-mobile' || window;
        $(target).on('click', function() {
            $('.navbar-mobile').removeClass('navbar-toggle');
            $('.navbar-menu').removeClass('slide');
        });
    }

    backendLinksNavigation();

})(jQuery);

function backendLinksNavigation() {
    var event = 'change' || 'popstate';
    $('.backend-links').on(event, function() {
        localStorage.clear();
        var link = $('.backend-links').val();
        window.location.href = $(this).attr('data-url')+'/'+link;
    });
}


function handleButton(button, spinner) {
    button.attr('disabled', false);
    spinner.addClass('d-none');
}

function handleErrors(input, span, message = '') {
    input.addClass('is-invalid');
    span.html(message);
    input.focus(function() {
        input.removeClass('is-invalid');
        span.html('');
    });
}
