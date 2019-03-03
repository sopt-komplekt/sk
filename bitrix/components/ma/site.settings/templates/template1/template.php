<?
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	$this->setFrameMode(true);
?>

<? IncludeTemplateLangFile(__FILE__); ?>

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