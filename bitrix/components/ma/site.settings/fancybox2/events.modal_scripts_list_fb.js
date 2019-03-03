$(document).ready(function(){
        $('.g-ajax-data').fancybox({
        	type: 'ajax',
        	dataType : 'html',
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
});