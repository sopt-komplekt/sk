$(document).ready(function(){

    $(".fancybox-inner form").live('submit', function(){
                    
        $.fancybox.close();
        
        $.fancybox.showLoading();
        
        var href = $(this).attr('action');
        var data = $(this).serialize();
        
        $.ajax({
            
            type: 'POST',
            url: href,
            data: data,
            success: function(data){
                
                $.fancybox({
                    
                    content: data,
                    maxWidth	: 800,
            		maxHeight	: 600,
            		fitToView	: true,
            		// width		: '70%',
            		// height		: '70%',
            		autoSize	: 'auto', //false,
            		closeClick	: false,
            		openEffect	: 'none',
            		closeEffect	: 'none'
                    
                });
                
                $.fancybox.hideLoading();
                
            },
            error: function(){
                
                $.fancybox.hideLoading();
                
            }
            
        });
        
        return false;
        
    });

});