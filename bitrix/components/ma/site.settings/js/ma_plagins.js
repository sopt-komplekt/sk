(function( $ ){
    
    //Плейсхолдер
    $.fn.ma_placeholder_text = function(options) {
        
        var settings = $.extend( {
            placeholder: ''
        }, options);
        
        function a(input){
            
            input.each(function(){
                
                var input = $(this);
                
                var type = input.attr('type');
                
                var tag_type = input.get(0).tagName.toLowerCase();
                
                if((type != 'text' || tag_type != 'input') && tag_type != 'textarea') return;
                
                var placeholder;
                
                if(settings.placeholder != ''){
                
                    placeholder = settings.placeholder;
                
                } else{
                    
                    placeholder = input.attr('placeholder');
                    
                }
                
                if(placeholder == '') return;
                
                var ua = navigator.userAgent.toLowerCase();

                if (ua.indexOf("msie 7") == -1 && ua.indexOf("msie 6") == -1){
                
                    input.removeAttr('placeholder');
                
                }
                
                if(input.val() == ''){
                    
                    input.val(placeholder);
                    input.addClass('custom-'+(tag_type == 'input' ? 'input' : 'textarea')+'-placeholder');
                    input.addClass('placeholder-color');
                    
                }
                
                input.focus(function(){
        
                    if($(this).val() == placeholder) {
                    
                        $(this).val('');
                        $(this).removeClass('placeholder-color');
                    };
                    
                });
                
                input.blur(function(){
                    
                    if($(this).val() == '') {
                        
                        $(this).val(placeholder);
                        $(this).addClass('placeholder-color');
                        
                    };
                    
                });
                
            });
            
        }
        
       return a(this);
    
    };
    
    //Плейсхолдер для input[type=password]
    $.fn.ma_password_text = function(options) {
        
        var settings = $.extend( {
            placeholder: 'Пароль',
            set_placeholder: false
        }, options);
        
        function a(input){
            
            input.each(function(){
                
                var input = $(this);
                
                var type = input.attr('type');
                
                if(type != 'password') return;
                
                input.wrap('<div class="substitution_text_input_wrap"></div>');
                
                var this_class = input.attr('class');
                
                var this_id = input.attr('id');
                
                settings.placeholder = (settings.placeholder != ''? settings.placeholder : 'Пароль');
                
                if(settings.set_placeholder){
                    
                    placeholder = 'placeholder="'+settings.placeholder+'"';
                    
                } else {
                    
                     placeholder = 'value="'+settings.placeholder+'"';
                    
                }
                
                input.after('<input type="text" id="'+this_id+'" class="'+this_class+' substitution_text_input" '+placeholder+'/>');
                
                input.hide();
                
                var new_input = input.closest('div.substitution_text_input_wrap').find('input.substitution_text_input');
                
                new_input.bind('click', function(){
                    
                    $(this).hide();
                    
                    input.show();
                    
                    input.focus();
                    
                });
                
                input.bind('blur', function(){
                    
                    if($(this).val() == ''){
                        
                        $(this).hide();
                        
                        new_input.show();
                        
                    }
                    
                });
                
            });
            
        }
        
       return a(this);
    
    };
      
    
    
    
    //Custom radio-button
    $.fn.ma_custom_radio = function(/*options*/) {
        
        /*var settings = $.extend( {
            placeholder: 'Пароль',
            set_placeholder: false
        }, options);*/
        
        //alert('!')
        
        function a(input){
    
            input.each(function(){
                
                var input = $(this);
                
                var type = input.attr('type');
                
                if(type != 'radio') return;
                
                var name = input.attr('name').replace(/[\[\]]/g,'').toLowerCase();
                
                var label;
                
                if(input.closest('label').length > 0){
                    
                    label = input.parent('label');
                    
                } else {
                    
                    input.wrap('<label></label>');
                    
                    label = input.parent('label');
                    
                }
                
                label.addClass('ma_custom_radio_button');
                
                label.addClass('label_for_'+name);
                
                if(input.attr('checked')){
                    
                    label.addClass('checked');
                    
                }
               
                label.bind('click', function(){
                
                    var name = $(this).find('input').attr('name').replace(/[\[\]]/g,'').toLowerCase();
                    
                    $('label.label_for_'+name).removeClass('checked');
                    
                    $(this).addClass('checked');
                    
                });
                
            });
            
        }
        
       return a(this);
    
    };
    
    
    
    
    //Custom checkbox
    $.fn.ma_custom_checkbox = function(/*options*/) {
        
        /*var settings = $.extend( {
            placeholder: 'Пароль',
            set_placeholder: false
        }, options);*/
        
        //alert('!')
        
        function a(input){
    
            input.each(function(){
                
                var input = $(this);
                
                var type = input.attr('type');
                
                if(type != 'checkbox') return;
                
                var name = input.attr('name').replace('[','').replace(']','').toLowerCase();
                
                var label;
                
                if(input.closest('label').length > 0){
                    
                    label = input.parent('label');
                    
                } else {
                    
                    input.wrap('<label></label>');
                    
                    label = input.parent('label');
                    
                }
                
                label.addClass('ma_custom_checkbox_button');
                
                label.addClass('label_for_'+name);
                
                if(input.attr('checked')){
                    
                    label.addClass('checked');
                    
                }
               
                label.bind('click', function(){
                
                    //var name = $(this).find('input').attr('name').replace('[','').replace(']','').toLowerCase();
//                    
//                    $('label.label_for_'+name).removeClass('checked');
//                    
//                    $(this).addClass('checked');

                    if(input.is(':checked')){
                        
                        $(this).addClass('checked');
                        
                    } else {
                        
                        $(this).removeClass('checked');
                        
                    }

                    
                });
                
            });
            
        }
        
       return a(this);
    
    };
    
    
    
    
    //Прелоадер
    /*$.fn.ma_preloader = function(options) {
        
        var settings = $.extend({
            cSpeed: 9,
        	cWidth: 40,
        	cHeight: 40,
        	cTotalFrames: 12,
        	cFrameWidth: 40,
        	cImageTimeout: false,
        	cIndex: 0,
        	cXpos: 0,
        	cPreloaderTimeout: false,
        	SECONDS_BETWEEN_FRAMES: 0
        }, options);
        
        //alert('!')
        
        function a(pre){
            
            var i = 0;
    
            pre.each(function(){
                
                a = $(this)
                
                setId = setInterval(function(){
                
                    a.css('background-position', i+'px');    
                    
                    i++;
                    
                },10);
                
            });
            
        }
        
        this.stop = function(){
            
            clearInterval(setId);
            
        };
        
       return a(this);
    
    };*/
      
  
})( jQuery );
