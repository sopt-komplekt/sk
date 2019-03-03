<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? 
if(count($arResult['ITEMS']) > 0): 

	$randid = rand();

	if(!is_numeric($arParams['ELEMENT_WIDTH'])){
		$arParams['ELEMENT_WIDTH'] = 1000;
	}
	if(!is_numeric($arParams['ELEMENT_HEIGHT'])){
		$arParams['ELEMENT_HEIGHT'] = 400;
	}
    
?>

<? //dump($arResult); ?>

<div class="b-nivoslider" id="i-nivoslider-<?=$randid?>" style="width: <?=$arParams['ELEMENT_WIDTH']?>px<?//=$arParams['ELEMENT_WIDTH_UNIT']?>; height: <?=$arParams['ELEMENT_HEIGHT']?>px<?//=$arParams['ELEMENT_HEIGHT_UNIT']?>;">
	
	<? foreach($arResult['ITEMS'] as $arElement): ?>
    
		<? if(is_array($arElement["PREVIEW_PICTURE"])): ?>
        
            <? if($arParams['PROPERTY_TO_LINK']): ?>
            
                <? if($arElement['PROPERTIES'][$arParams['PROPERTY_TO_LINK']]['VALUE']): ?>
            
                    <a href="<?=$arElement['PROPERTIES'][$arParams['PROPERTY_TO_LINK']]['VALUE']; ?>" title="<?=$arElement["NAME"]; ?>" target="_blank">
                    
                        <img src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arElement["NAME"]; ?>" title="<?=($arParams['NAME_IN_TITLE'] == 'Y' ? $arElement["NAME"] : ''); ?>" />
                    
                    </a>
                    
                <? else: ?>
                    
                    <img src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arElement["NAME"]; ?>" title="<?=($arParams['NAME_IN_TITLE'] == 'Y' ? $arElement["NAME"] : ''); ?>" />
            
                <? endif; ?>
            
            <? else: ?>
                
                <img src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arElement["NAME"]; ?>" title="<?=($arParams['NAME_IN_TITLE'] == 'Y' ? $arElement["NAME"] : ''); ?>" />
            
            <? endif; ?>
				
		<? endif; ?>

	<? endforeach ?>
    
</div>

    <? if(count($arResult['ITEMS']) > 1): ?>
		
		<script type="text/javascript">
		
			$(window).load(function(){
			 
                $('#i-nivoslider-<?=$randid?>').nivoSlider({
                    
                    effect: '<?=$arParams['ANIMATE_EFFECT']; ?>',
                    boxCols: <?=$arParams['BOX_COLS']; ?>,
                    boxRows: <?=$arParams['BOX_ROWS']; ?>,
                    animSpeed: <?=$arParams['AMIMATE_SPEED']; ?>,
                    pauseTime: <?=$arParams['PAUSE_SPEED']; ?>,
                    directionNav: <? if($arParams['DIRECTION_NAV'] == 'Y') : ?>true <? else: ?> false <? endif; ?>,
                    <? if($arParams['DIRECTION_NAV'] == 'Y') : ?>
                    directionNavHide: <? if($arParams['DIRECTION_NAV_HIDE'] == 'Y') : ?>true <? else: ?> false <? endif; ?>,
                    <? endif; ?>
                    controlNav: <? if($arParams['CONTROL_NAV'] == 'Y') : ?>true <? else: ?> false <? endif; ?>,
                    pauseOnHover: <? if($arParams['PAUSE_ON_HOVER'] == 'Y') : ?>true <? else: ?> false <? endif; ?>,
                    manualAdvance: <? if($arParams['MANUAL_ADVANCE'] != 'Y') : ?>true <? else: ?> false <? endif; ?>,
                    prevText: '<?=$arParams['PREV_TEXT']; ?>',
                    nextText: '<?=$arParams['NEXT_TEXT']; ?>',
                    randomStart: <? if($arParams['RANDOM_START'] == 'Y') : ?>true <? else: ?> false <? endif; ?>
                    
                });
             
			});
			
		</script>
	<? endif; ?>

<? endif; ?>

<? //dump($arResult); ?>