<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $this->setFrameMode(true);
?>

<? IncludeTemplateLangFile(__FILE__); ?>

<? if($arParams['USE_POPUP_SCRIPTS'] == 'Y'): ?>

    <script>
        
        $(document).ready(function(){

        <? if($arParams['MODAL_SCRIPTS_LIST'] == 'AM'): ?>
        
            $('body').on('click',".<?=$arParams['MODAL_CLASS']; ?>", function(){
                
                var href = $(this).attr('href');
                
                $.arcticmodal({
        		type: 'ajax',
        		url: href,
                ajax: {
                        type: 'POST',
                        cache: false,
                        success: function(data, el, responce) {
                            var h = $('<div class="m-box-modal">' +
                                    '<div class="box-modal_close arcticmodal-close" title="<?=GetMessage("CLOSE"); ?>"></div>' +
                                     responce +
                                    '</div>');
                            data.body.html(h);
                        }
                    }
                });
                
                return false;
                
        	});
            
            <? if($arParams['MODAL_FORM'] == "Y"): ?>
            
            $('.m-box-modal form').live('submit', function(){
        
                $.arcticmodal('close');
                
                var href = $(this).attr('action');
                var data = $(this).serialize();
                
                $.arcticmodal({
        			type: 'ajax',
        			url: href,
                    ajax: {
                        type: 'POST',
                        cache: false,
                        data: data,
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
            
            <? endif; ?>
        
        <? elseif($arParams['MODAL_SCRIPTS_LIST'] == 'FB'): ?>
        
            $(".<?=$arParams['MODAL_CLASS']; ?>").fancybox({
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
            
            <? if($arParams['MODAL_FORM'] == "Y"): ?>
            
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
            
            <? endif; ?>
        
        <? endif; ?>
    
        });
            
    </script>

<? endif; ?>

<? if($arParams['USE_TOP_SCROLL'] == "Y"): ?>

    <a class="b-up_button" href="#top" title="<?=GetMessage("UP_BUTTON"); ?>" ><span style=""></span></a>

    <? //if($arParams['USE_TOP_SCROLL']): ?>
        <script>
            $(document).ready(function(){
                up_button("<?=($arParams['USE_TOP_ALWAYS'] == 'Y' ? 'yes' : 'no'); ?>", <?=($arParams['USE_TOP_SCROLL_HEIGHT'] ? $arParams['USE_TOP_SCROLL_HEIGHT'] : 0); ?>);
            });
        </script> 
    <? //endif; ?>

<? endif; ?>