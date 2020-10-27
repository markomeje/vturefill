(function($) {

    'use strict';

    $('.add-tariff-form').submit(function(event) {
        var form = $(this);
        var button = $('.add-tariff-button');
        var spinner = $('.add-tariff-spinner');
        var message = $('.add-tariff-message');
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

            }else if (response.status === 'invalid-bundle') {
                handleButton(button, spinner);
                handleErrors($('.bundle'), $('.bundle-error'), 'Bundle size is required');

            }else if (response.status === 'invalid-network') {
                handleButton(button, spinner);
                handleErrors($('.network'), $('.network-error'), 'Please select network provider.');

            }else if (response.status === 'invalid-amount') {
                handleButton(button, spinner);
                handleErrors($('.amount'), $('.amount-error'), 'Amount is required');

            }else if (response.status === 'invalid-duration') {
                handleButton(button, spinner);
                handleErrors($('.duration'), $('.duration-error'), 'Bundle duration is required');

            }else if (response.status === 'invalid-code') {
                handleButton(button, spinner);
                handleErrors($('.code'), $('.code-error'), 'Bundle code is required');

            }else if (response.status === 'invalid-status') {
                handleButton(button, spinner);
                handleErrors($('.status'), $('.status-error'), 'Status is required');

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

    $('.edit-tariff-form').submit(function(event) {
        var form = $(this);
        var button = $('.edit-tariff-button');
        var spinner = $('.edit-tariff-spinner');
        var message = $('.edit-tariff-message');
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

            }else if (response.status === 'invalid-bundle') {
                handleButton(button, spinner);
                handleErrors($('.bundle'), $('.bundle-error'), 'Bundle size is required');

            }else if (response.status === 'invalid-network') {
                handleButton(button, spinner);
                handleErrors($('.network'), $('.network-error'), 'Please select network provider.');

            }else if (response.status === 'invalid-amount') {
                handleButton(button, spinner);
                handleErrors($('.amount'), $('.amount-error'), 'Amount is required');

            }else if (response.status === 'invalid-duration') {
                handleButton(button, spinner);
                handleErrors($('.duration'), $('.duration-error'), 'Bundle duration is required');

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

    $('.delete-tariff').on('click', function() {
        alert("Clicked");
    });

})(jQuery);