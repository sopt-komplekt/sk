$(document).ready(function(){
	$('.g-ajax-data').bind('click', function(){
        var href = $(this).attr('href');
        $.arcticmodal({
		type: 'ajax',
		url: href,
        ajax: {
                type: 'POST',
                cache: false,
                success: function(data, el, responce) {
                    var h = $('<div class="m-box-modal">' +
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