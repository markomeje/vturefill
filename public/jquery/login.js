(function ($) {

	'use strict';

    $('.login-form').submit(function(event){
        event.preventDefault();
        var form = $(this);
        //var resend = $('.resend-email');
    	var button = $('.login-button');
    	var spinner = $('.login-spinner');
    	var message = $('.login-message');
        button.attr('disabled', true);
        spinner.removeClass('d-none');
        message.hasClass('d-none') ? '' : message.fadeOut();
        //resend.hasClass('d-none') ? '' : resend.fadeOut();

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
                handleErrors($('.email'), $('.email-error'), 'Please fill in your email.');

            } else if (response.status === 'empty-password') {
                handleButton(button, spinner);
                handleErrors($('.password'), $('.password-error'), 'Please fill in your password');

            }else if (response.status === 'not-found') {
                handleButton(button, spinner);
                message.removeClass('d-none alert-success').addClass('alert-danger');
                message.html('Invalid login details.').fadeIn();
                handleErrors($('.password'), $('.password-error'), '');
                handleErrors($('.email'), $('.email-error'), '');

            }else if (response.status === 'inactive') {
                handleButton(button, spinner);
                message.removeClass('d-none alert-success').addClass('alert-danger');
                message.html('Please verify your account with the link sent to your email.').fadeIn();
                //resend.removeClass('d-none').addClass('alert-info').fadeIn();
                handleErrors($('.email'), $('.email-error'), '');

            }else if (response.status === 'invalid-login') {
                handleButton(button, spinner);
                message.removeClass('d-none alert-success').addClass('alert-danger');
                handleErrors($('.password'), $('.password-error'), '');
                handleErrors($('.email'), $('.email-error'), '');
                if(response.attempts >= 1) {
                    var remainder = 5 - response.attempts;
                    message.html((remainder <= 1) ? 'Your last login attempt' : remainder+' attempts remaining').fadeIn();
                }else {
                    message.html('Invalid login details').fadeIn();
                }

            }else if (response.status === 'blocked') {
                handleButton(button, spinner);
                message.removeClass('d-none alert-success').addClass('alert-danger');
                message.html('Access denied. Try again later').fadeIn();

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
            alert('System Error');
        });
    });

    $('.logout').on('click', function(){
        var request = $.ajax({
            method: 'POST',
            url: $(this).attr('data-url'),
            processData: false,
            contentType: false,
            dataType: 'json'
        });

        request.done(function(response){
            if (response.status === 'success') {
                window.location.href = response.redirect;
            }else {
                alert('Network Error');
            }
        });

        request.fail(function() {
            alert('Network Error');
        });
    });

})(jQuery);
