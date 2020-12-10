(function($) {

    'use strict';

    $('.add-level-form').submit(function(event) {
        var form = $(this);
        var button = $('.add-level-button');
        var spinner = $('.add-level-spinner');
        var message = $('.add-level-message');
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

            }else if (response.status === 'invalid-level') {
                handleButton(button, spinner);
                handleErrors($('.level'), $('.level-error'), 'Level is required');

            }else if (response.status === 'level-exists') {
                handleButton(button, spinner);
                handleErrors($('.level'), $('.level-error'), 'Level already exists');

            } else if (response.status === 'invalid-discount') {
                handleButton(button, spinner);
                handleErrors($('.discount'), $('.discount-error'), 'Please add discount percentage');

            } else if (response.status === 'invalid-minimum') {
                handleButton(button, spinner);
                handleErrors($('.minimum'), $('.minimum-error'), 'Minimum amount is required.');

            } else if (response.status === 'invalid-maximum') {
                handleButton(button, spinner);
                handleErrors($('.maximum'), $('.maximum-error'), 'Maximum amount is required.');

            } else if (response.status === 'invalid-description') {
                handleButton(button, spinner);
                handleErrors($('.description'), $('.description-error'), 'Description is required.');

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

    $('.edit-level-form').submit(function(event) {
        var form = $(this);
        var button = $('.edit-level-button');
        var spinner = $('.edit-level-spinner');
        var message = $('.edit-level-message');
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

            }else if (response.status === 'invalid-level') {
                handleButton(button, spinner);
                handleErrors($('.level'), $('.level-error'), 'Level is required');

            }else if (response.status === 'level-exists') {
                handleButton(button, spinner);
                handleErrors($('.level'), $('.level-error'), 'Level already exists');

            } else if (response.status === 'invalid-discount') {
                handleButton(button, spinner);
                handleErrors($('.discount'), $('.discount-error'), 'Please add discount percentage');

            } else if (response.status === 'invalid-minimum') {
                handleButton(button, spinner);
                handleErrors($('.minimum'), $('.minimum-error'), 'Minimum amount is required.');

            } else if (response.status === 'invalid-maximum') {
                handleButton(button, spinner);
                handleErrors($('.maximum'), $('.maximum-error'), 'Maximum amount is required.');

            } else if (response.status === 'invalid-description') {
                handleButton(button, spinner);
                handleErrors($('.description'), $('.description-error'), 'Description is required.');

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