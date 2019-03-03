$(document).ready(function(){

    chooseItem = function(){
        var code = $(this).find('span').attr('code');
        $(this).parents('form').find('input#captcha').val( code );
        $('div.b-captcha_selected').removeClass('b-captcha_selected');
        $(this).addClass('b-captcha_selected');
    }

    $('div.b-captcha_item').click(chooseItem);

});