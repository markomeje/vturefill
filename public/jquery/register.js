(function ($) {

	'use strict';

    $('.register-form').submit(function(event){
        event.preventDefault();
        var form = $(this);
    	var button = $('.register-button');
    	var spinner = $('.register-spinner');
    	var message = $('.register-message');
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

        request.done(function(response){
            if (response.status === 'invalid-email') {
                handleButton(button, spinner);
                handleErrors($('.email'), $('.email-error'), 'Invalid email format.');

            }else if (response.status === 'email-exists') {
                handleButton(button, spinner);
                handleErrors($('.email'), $('.email-error'), 'Email is already in use.');

            } else if (response.status === 'invalid-password') {
                handleButton(button, spinner);
                handleErrors($('.password'), $('.password-error'), 'Password must be between 7 - 15 characters');

            } else if (response.status === 'unmatched-password') {
                handleButton(button, spinner);
                handleErrors($('.retype-password'), $('.retype-password-error'), 'Passwords do not match');
                handleErrors($('.password'), $('.password-error'), '');

            } else if (response.status === 'success') {
                handleButton(button, spinner);
                message.removeClass('d-none alert-danger').addClass('alert-success');
                message.html('Operation successful.').fadeIn();
                window.location.href = response.redirect;

            } else if (response.status === 'error') {
                handleButton(button, spinner);
                message.removeClass('d-none alert-success').addClass('alert-danger');
                message.html('An error occured. Try again.').fadeIn();
            } else {
                handleButton(button, spinner);
            }
        });

        request.fail(function() {
            handleButton(button, spinner);
            alert('Network Error');
        });
    });

})(jQuery);
