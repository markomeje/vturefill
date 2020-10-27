(function($) {

    'use strict';

    $('.contact-form').submit(function(event) {
        var form = $(this);
        var button = $('.contact-button');
        var spinner = $('.contact-spinner');
        var message = $('.contact-message');
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
            }else if (response.status === 'invalid-firstname') {
                handleButton(button, spinner);
                handleErrors($('.firstname'), $('.firstname-error'), 'Firstname must be between 3 - 55 characters.');
            } else if (response.status === 'invalid-lastname') {
                handleButton(button, spinner);
                handleErrors($('.lastname'), $('.lastname-error'), 'Lastname must be between 3 - 55 characters.');
            } else if (response.status === 'invalid-phone') {
                handleButton(button, spinner);
                handleErrors($('.phone'), $('.phone-error'), 'Please fill in your phone number.');
            } else if (response.status === 'invalid-email') {
                handleButton(button, spinner);
                handleErrors($('.email'), $('.email-error'), 'Invalid email format.');
            } else if (response.status === 'invalid-message') {
                handleButton(button, spinner);
                handleErrors($('.message'), $('.message-error'), 'Message must be between 3 - 255 characters.');
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