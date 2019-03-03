$(document).ready(function(){
  
    chooseItem = function(){
        var code = $(this).find('span').attr('code');
        $(this).parents('form').find('input#captcha').val( code );
        $('div.b-captcha_selected').removeClass('b-captcha_selected');
        $(this).addClass('b-captcha_selected');
    }

    $('div.b-captcha_item').on('click', chooseItem);


    setLabel($('.g-input-undo-label'));

    $('.g-input-undo-label').on('focus', function(){
        $(this).parents('div.b-message-form_item').find("label").css('display', 'none');
    }).on('blur', function(){
        setLabel($(this));
    }).on('change', function(){
        setLabel($(this));
    });

    function setLabel(nod) 
    {
        var value;
        nod.each(function(index){
            value = $(this).val();
            if(!value){
                $(this).parents('div.b-message-form_item').find("label").css('display', 'inline');
            }
            else{
                $(this).parents('div.b-message-form_item').find("label").css('display', 'none');
            }
        });
    }

});

