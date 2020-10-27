(function ($) {

	'use strict';

	$('.update-password-form').submit(function(event){
        event.preventDefault();
        var form = $(this);
    	var button = $('.update-password-button');
    	var spinner = $('.update-password-spinner');
    	var message = $('.update-password-message');
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
        	if (response.status === 'invalid-reason') {
                handleButton(button, spinner);
                handleErrors($('.reason'), $('.reason-error'), 'Reason is required.');
            } else if (response.status === 'incorrect-password') {
                handleButton(button, spinner);
                handleErrors($('.currentpassword'), $('.currentpassword-error'), 'Incorrect password.');
            } else if (response.status === 'invalid-password') {
                handleButton(button, spinner);
                handleErrors($('.newpassword'), $('.newpassword-error'), 'Password must be between 6 - 15 characters.');
            } else if (response.status === 'invalid-confirm-password') {
                handleButton(button, spinner);
                handleErrors($('.confirmpassword'), $('.confirmpassword-error'), 'Passwords do not match.');
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
