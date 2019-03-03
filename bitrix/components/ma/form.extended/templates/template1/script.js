$(document).ready(function(){
  
    // getHexRGBColor = function(color){
    //     color = color.replace(/\s/g,"");
    //     var aRGB = color.match(/^rgb\((\d{1,3}[%]?),(\d{1,3}[%]?),(\d{1,3}[%]?)\)$/i);
    //     if(aRGB) {
    //         color = '';
    //         for (var i=1;  i<=3; i++) color += Math.round((aRGB[i][aRGB[i].length-1]=="%"?2.55:1)*parseInt(aRGB[i])).toString(16).replace(/^(.)$/,'0$1');
    //     }
    //     else color = color.replace(/^#?([\da-f])([\da-f])([\da-f])$/i, '$1$1$2$2$3$3');
    //     return color;
    // }

    // chooseItem = function(){
    //     var color = getHexRGBColor($('span', this).css('background-color'));
    //     if(color.substr(0,1) == '#') color = color.substr( 1 );
    //     $(this).parents('form').find('div.b-color-captcha input').val( color );
    //     $('div.b-color-captcha_selected').removeClass('b-color-captcha_selected');
    //     $(this).addClass('b-color-captcha_selected');
    // }

    // $('div.b-color-captcha_item').click(chooseItem);

    chooseItem = function(){
        var code = $(this).find('span').attr('code');
        $(this).parents('form').find('input#captcha').val( code );
        $('div.b-captcha_selected').removeClass('b-captcha_selected');
        $(this).addClass('b-captcha_selected');
    }

    $('div.b-captcha_item').on('click', chooseItem);


    setLabel($('.g-input-undo-label'));

    $('.g-input-undo-label').live('focus', function(){
        $(this).parents('div.b-message-form_item').find("label").css('display', 'none');
    }).live('blur', function(){
        setLabel($(this));
    }).live('change', function(){
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