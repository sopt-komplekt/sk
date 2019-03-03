    <!-- Комментарии -->

    <? if($arParams['USE_REVIEW'] == "Y"): ?>
    
        <? if($arParams['USE_REVIEW_LIST'] == 'vk'): ?>
    
            <? if($arParams['USE_REVIEW_VK_ID']): ?>
    
                <div id="vk_comments"></div>
                
                <script type="text/javascript">
                
                window.onload = function () {
                    
                    var vk_option = {
                        attach: <?=($arParams['USE_REVIEW_VK_ATTACH'] == "Y" ? '"*"' : 'false'); ?>,
                        width: <?=$arParams['USE_REVIEW_VK_WIDTH']; ?>, 
                        limit: <?=$arParams['USE_REVIEW_VK_LIMIT']; ?>,
                        height: <?=$arParams['USE_REVIEW_VK_HEIGHT']; ?>
                        
                    }
                    
                    VK.init({apiId: <?=$arParams['USE_REVIEW_VK_ID']; ?>, onlyWidgets: true});
                    
                    VK.Widgets.Comments('vk_comments', vk_option);
                 
                }
                
                </script>
    
            <? endif; ?>
            
        <? elseif($arParams['USE_REVIEW_LIST'] == 'fb'): ?>
        
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            
            <div class="fb-comments" data-numposts="<?=$arParams['USE_REVIEW_FB_NUM_POSTS']; ?>" data-colorscheme="<?=$arParams['USE_REVIEW_FB_COLOR_SCHEME']; ?>" data-width="<?=$arParams['USE_REVIEW_FB_WIDTH']; ?>" data-href="<?=$_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL']; ?>"></div>
    
        <? elseif($arParams['USE_REVIEW_LIST'] == 'disqus'): ?>
        
            <? if($arParams['USE_REVIEW_DISQUS_SHORTNAME']): ?>
            
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                    var disqus_shortname = '<?=$arParams['USE_REVIEW_DISQUS_SHORTNAME']; ?>'; // required: replace example with your forum shortname
            
                    /* * * DON'T EDIT BELOW THIS LINE * * */
                    (function() {
                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
            
            <? endif; ?>
    
        <? endif; ?>
        
    <? endif; ?>
    
    <!-- /////Комментарии -->