(function($) {

    'use strict';

    $('.add-category-form').submit(function(event) {
        var form = $(this);
        var button = $('.add-category-button');
        var spinner = $('.add-category-spinner');
        var message = $('.add-category-message');
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

            }else if (response.status === 'invalid-category') {
                handleButton(button, spinner);
                handleErrors($('.category'), $('.category-error'), 'Category is required');

            }else if (response.status === 'category-exists') {
                handleButton(button, spinner);
                handleErrors($('.category'), $('.category-error'), 'Category already exists');

            } else if (response.status === 'invalid-status') {
                handleButton(button, spinner);
                handleErrors($('.status'), $('.status-error'), 'Please select status');

            } else if (response.status === 'success') {
                handleButton(button, spinner);
                message.removeClass('alert-danger d-none').addClass('alert-success');
                message.html('Operation Successfull').fadeIn();
                window.location.reload();

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