(function($) {

    'use strict';

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