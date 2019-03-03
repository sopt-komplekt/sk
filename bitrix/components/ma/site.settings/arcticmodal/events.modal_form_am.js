$(document).on('submit', '.m-box-modal form', function() {
        $.arcticmodal('close');
        var href = $(this).attr('action');
        var data = new FormData(this);
        $.arcticmodal({
            type: 'ajax',
            url: href,
            ajax: {
                type: 'POST',
                cache: false,
                data: data,
                contentType: false,
                processData: false,
                success: function(data, el, responce) {
                    var h = $('<div class="m-box-modal">' +
                            '<div class="box-modal_close arcticmodal-close"></div>' +
                             responce +
                            '</div>');
                    data.body.html(h);
                },
                error: function(){
                    $.arcticmodal('close');
                }
            }
        });
        return false;
});

// $(document).on('click', '.g-new-form', function() {
//         $.arcticmodal('close');
//         var href = $(this).attr('href');
//         var data = new FormData(this);
//         $.arcticmodal({
//             type: 'ajax',
//             url: href,
//             ajax: {
//                 type: 'POST',
//                 cache: false,
//                 data: data,
//                 contentType: false,
//                 processData: false,
//                 success: function(data, el, responce) {
//                     var h = $('<div class="m-box-modal">' +
//                             '<div class="box-modal_close arcticmodal-close"></div>' +
//                              responce +
//                             '</div>');
//                     data.body.html(h);
//                 },
//                 error: function(){
//                     $.arcticmodal('close');
//                 }
//             }
//         });
//         return false;
// });