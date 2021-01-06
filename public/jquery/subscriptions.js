(function($) {

    'use strict';

    $('.add-tv-subscription-form').submit(function(event) {
        var form = $(this);
        var button = $('.add-tv-subscription-button');
        var spinner = $('.add-tv-subscription-spinner');
        var message = $('.add-tv-subscription-message');
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

            }else if (response.status === 'invalid-plan') {
                handleButton(button, spinner);
                handleErrors($('.plan'), $('.plan-error'), 'Plan name is required');

            }else if (response.status === 'invalid-amount') {
                handleButton(button, spinner);
                handleErrors($('.amount'), $('.amount-error'), 'Amount is required');

            }else if (response.status === 'invalid-duration') {
                handleButton(button, spinner);
                handleErrors($('.duration'), $('.duration-error'), 'Duration is required');

            }else if (response.status === 'invalid-tv') {
                handleButton(button, spinner);
                handleErrors($('.tv'), $('.tv-error'), 'Tv is required');

            } else if (response.status === 'success') {
                handleButton(button, spinner);
                message.removeClass('alert-danger d-none').addClass('alert-success');
                message.html('Operation Successfull').fadeIn();
                // window.location.reload();

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

    $('.edit-tv-subscription-form').submit(function(event) {
        var form = $(this);
        var button = $('.edit-tv-subscription-button');
        var spinner = $('.edit-tv-subscription-spinner');
        var message = $('.edit-tv-subscription-message');
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

            }else if (response.status === 'invalid-plan') {
                handleButton(button, spinner);
                handleErrors($('.plan'), $('.plan-error'), 'Plan name is required');

            }else if (response.status === 'invalid-amount') {
                handleButton(button, spinner);
                handleErrors($('.amount'), $('.amount-error'), 'Amount is required');

            }else if (response.status === 'invalid-duration') {
                handleButton(button, spinner);
                handleErrors($('.duration'), $('.duration-error'), 'Duration is required');

            }else if (response.status === 'invalid-tv') {
                handleButton(button, spinner);
                handleErrors($('.tv'), $('.tv-error'), 'Tv is required');

            } else if (response.status === 'success') {
                handleButton(button, spinner);
                message.removeClass('alert-danger d-none').addClass('alert-success');
                message.html('Operation Successfull').fadeIn();
                // window.location.reload();

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

    $('.delete-tv-subscription').on('click', function() {
        alert("Clicked");
    });

})(jQuery);