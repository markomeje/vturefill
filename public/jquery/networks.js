(function($) {

    'use strict';

    $('.add-network-form').submit(function(event) {
        var form = $(this);
        var button = $('.add-network-button');
        var spinner = $('.add-network-spinner');
        var message = $('.add-network-message');
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

            }else if (response.status === 'empty-name') {
                handleButton(button, spinner);
                handleErrors($('.name'), $('.name-error'), 'Network name is required');

            }else if (response.status === 'empty-code') {
                handleButton(button, spinner);
                handleErrors($('.code'), $('.code-error'), 'Network code is required');

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

    $('.edit-network-form').submit(function(event) {
        var form = $(this);
        var button = $('.edit-network-button');
        var spinner = $('.edit-network-spinner');
        var message = $('.edit-network-message');
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

            }else if (response.status === 'empty-name') {
                handleButton(button, spinner);
                handleErrors($('.name'), $('.name-error'), 'Network name is required');

            }else if (response.status === 'empty-code') {
                handleButton(button, spinner);
                handleErrors($('.code'), $('.code-error'), 'Network code is required');

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


    $('.network-switch').change(function(event) {
        var checkbox = $(this);
        var state = checkbox.prop('checked') ? true : false;
        var networkStatus = checkbox.parent().parent().parent().find('.network-status');
        var request = $.ajax({
            url: checkbox.attr('data-url'),
            processData: false,
            contentType: false,
            dataType: 'json'
        });

        request.done(function(response) {
            if (response.status === 'error') {
                checkbox.prop('checked', !state);
                $(networkStatus[0]).text(response.network);
                alert('An error occured. Try again');
            }else if(response.status === 'success') {
                $(networkStatus[0]).text(response.network);
            }
        });

        request.fail(function() {
            alert('Network Error');
        });

    });

})(jQuery);