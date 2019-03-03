$(document).ready(function(){   
    $(document).on('click', '.g-ajax-data', function(event){
        event.preventDefault();
        //$.arcticmodal('close');

        // var href = $(this).attr('href'),
        var href = $(this).attr('href') ? $(this).attr('href') : $(this).data('href'),
            specialId = $(this).attr('data-specialId');

        //Особый id для особых стилей особых страниц..)
        if (specialId != 'undefined') {
            specialId = 'id="'+specialId+'"';
        }
        $.arcticmodal({
        type: 'ajax',
        url: href,
        ajax: {
                type: 'POST',
                cache: false,
                success: function(data, el, responce) {
                    var h = $('<div '+ specialId +'class="m-box-modal">' +
                            '<div class="box-modal_close arcticmodal-close" title="Закрыть"></div>' +
                             responce +
                            '</div>');
                    data.body.html(h);
                }
            }
        });
        return false;
    });
});