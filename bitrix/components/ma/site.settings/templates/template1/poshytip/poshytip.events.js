$(document).ready(function () {

    $('.g-tooltip').poshytip({
        className: 'b-tooltip-yellow',
        offsetX: -7,
        offsetY: 16,
        allowTipHover: false,
        //followCursor: true,
        //showTimeout: 400,
        // alignTo: 'target',
        // alignX: 'right',
        // alignY: 'center'
    });

    $('.g-tooltip-data-hover').poshytip({
        className: 'b-tooltip-gray',
        alignTo: 'target',
        alignX: 'center', // 'right', 'center', 'left', 'inner-left', 'inner-right'
        alignY: 'bottom',
        offsetY: 12,
        fade: false,
        slide: true,
        liveEvents: true,
        hideTimeout: 1000,
        hideAniDuration: 200,
        content: function (updateCallback) {
            var file = $(this).attr('tooltip-data');
            $.get(file, function (data) {
                updateCallback(data);
            });
            return 'Загрузка...';
        }
    });

    $('.g-tooltip-data-onclick').poshytip({
        className: 'b-tooltip-gray',
        alignTo: 'target',
        alignX: 'center', // 'right', 'center', 'left', 'inner-left', 'inner-right'
        alignY: 'bottom',
        offsetY: 12,
        fade: false,
        slide: true,
        liveEvents: true,
        hideTimeout: 1000,
        hideAniDuration: 200,
        showOn: 'none',
        content: function (updateCallback) {
            var file = $(this).attr('tooltip-data');
            $.get(file, function (data) {
                updateCallback(data);
            });
            return 'Загрузка...';
        }
    });

    var mouse_inside_popup = false;

    $('.b-tooltip-gray').hover(function () {
        mouse_inside_popup = true;
    }, function () {
        mouse_inside_popup = false;
    });


    $('.g-tooltip-data-onclick').click(function (event) {
        event.stopPropagation();
        $('.g-tooltip-data-onclick').poshytip('hide');
        $(this).poshytip('show');
    });

    $('body').click(function (event) {
        if (!mouse_inside_popup) {
            $('.g-tooltip-data-onclick').poshytip('hide');
        }
    });

    // $('b-tooltip-gray').click(function (event) {
    //     event.stopPropagation();
    // });

    $('.g-input-validation-error').poshytip({
        className: 'b-tooltip-red',
        showOn: 'none',
        alignTo: 'target',
        alignX: 'right',
        alignY: 'center',
        offsetY: 0,
        offsetX: 10,
        fade: false,
        slide: true,
        slideOffset: 70,
        content: function () {
            var data = $(this).attr('data-val-required');
            return data;
        }
    }).poshytip('show');


});