function up_button(always, scroll_height){
    
    always = (always == 'yes' ? 'yes' : 'no');
    
    scroll_height = parseInt(scroll_height);
          
    var up_button = $('.b-up_button');

    if(always == 'no'){

        if(typeof(scroll_height) != 'number' || scroll_height == ''){
            
            scroll_height = 300;
            
        }
        
        $(window).scroll( function(){
        
            if($(window).scrollTop() >= scroll_height){
                
                up_button.fadeIn(300);
                
            } else {
                
                up_button.fadeOut(300);
                
            }
        
        });
    
    } else {
        
        up_button.show();
        
    }
    
    up_button.hover(function(){
        
        $(this).find('span').stop(true, true).animate({'opacity':1},300);
        
    }, function(){
        
        $(this).find('span').stop(true, true).animate({'opacity':0.3},300);
        
    });
    
    up_button.click(function(){
        
        $('body,html').animate({scrollTop: 0}, 400);
        
        return false;
        
    });
    
}