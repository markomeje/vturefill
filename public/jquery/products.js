(function($) {

    'use strict';

    $('.add-product-form').submit(function() {
        var form = $(this);
        var button = $('.add-product-button');
        var spinner = $('.add-product-spinner');
        var message = $('.add-product-message');
        button.attr('disabled', true);
        spinner.removeClass('d-none');
        message.hasClass('d-none') ? '' : message.fadeOut();

        var request = $.ajax({
            method: form.attr('method'),
            url: form.attr('data-action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: 'json'
        });

        request.done(function(response) {
            if(response === null) {
                handleButton(button, spinner);
                message.removeClass('alert-success d-none').addClass('alert-danger');
                message.html('An error ocurred. Try again').fadeIn();

            }else if (response.status === 'invalid-product') {
                handleButton(button, spinner);
                handleErrors($('.product'), $('.product-error'), 'Product is required');

            }else if (response.status === 'product-exists') {
                handleButton(button, spinner);
                handleErrors($('.product'), $('.product-error'), 'Product already exists for category');

            } else if (response.status === 'invalid-status') {
                handleButton(button, spinner);
                handleErrors($('.status'), $('.status-error'), 'Please select status');

            } else if (response.status === 'success') {
                handleButton(button, spinner);
                message.removeClass('alert-danger d-none').addClass('alert-success');
                message.html('Operation Successfull').fadeIn();
                //window.location.reload();

            } else if (response.status === 'error') {
                handleButton(button, spinner);
                message.removeClass('alert-success d-none').addClass('alert-danger');
                message.html('An error ocurred. Try again').fadeIn();

            }else {
                alert('Network Error');
                handleButton(button, spinner);
            }
        });

        request.fail(function() {
            handleButton(button, spinner);
            alert('Network Error');
        });

    });
})(jQuery);