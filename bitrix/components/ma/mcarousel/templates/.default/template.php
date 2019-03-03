<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?/*
Используется скрипт карусели owl-carousel 2.2.0
Исходники: https://owlcarousel2.github.io/OwlCarousel2/
Полный список опций: https://owlcarousel2.github.io/OwlCarousel2/docs/api-options.html
Полный список событий: https://owlcarousel2.github.io/OwlCarousel2/docs/api-events.html
Скрипты для дополнительных опций в папке /bitrix/components/carousel.new/carousel/js/
*/?>
<?
if(count($arResult['ITEMS']) > 0): 
	$randid = rand();
	if(is_numeric($arParams['ELEMENT_WIDTH'])){
		$elwidth = intval($arParams['ELEMENT_WIDTH']).'px';
	}
	else {
		$elwidth = $arParams['ELEMENT_WIDTH'];	
	}
	if(is_numeric($arParams['ELEMENT_HEIGHT'])){
		$elheight = $arParams['ELEMENT_HEIGHT'].'px';
	}
	else {
		$elheight = $arParams['ELEMENT_HEIGHT'];	
	}
	if(is_numeric($arParams['BLOCK_WIDTH'])){
		$blockwidth = intval($arParams['BLOCK_WIDTH']).'px';
	}
	else {
		$blockwidth = $arParams['BLOCK_WIDTH'];	
	}
	if(is_numeric($arParams['BLOCK_HEIGHT'])){
		$blockheight = $arParams['BLOCK_HEIGHT'].'px';
	}
	else {
		$blockheight = $arParams['BLOCK_HEIGHT'];	
	}
?>
<div class="b-carousel">
	<div<? if (count($arResult['ITEMS']) > $arParams['ELEMENT_VISIBLE_COUNT']): ?> class="owl-carousel"<? endif; ?> id="carousel_<?=$randid?>" style="width:<?=$blockwidth?>;height:<?=$blockheight?>;">
		<?
		$i = 0;
		foreach($arResult['ITEMS'] as $arElement):
			$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CATALOG_ELEMENT_DELETE_CONFIRM')));	
			?>
			<div class="owl-carousel_item g-carousel-item" id="<?=$this->GetEditAreaId($arElement['ID']);?>" style="width:<?=$elwidth?>; height:<?=$elheight?>;<?if($i!=0):?>display:none;<?endif;?>">
				<? if(is_array($arElement["PREVIEW_PICTURE"])): ?>
					<div class="b-carousel_item_pic">
						<? if($arElement['PROPERTIES']['LINK']['VALUE']): ?>
							<a href="<?=$arElement['PROPERTIES']['LINK']['VALUE']?>">
								<img src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arElement['NAME']?>">
							</a>
						<? elseif($arParams['USE_PHOTOGALLERY'] == 'Y'):?>
							<a class="g-fancybox" href="<?=$arElement["DETAIL_PICTURE"]["SRC"]?>" rel="photo-<?=$randid?>">
								<img src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arElement['NAME']?>">
							</a>
						<? else: ?>
							<img src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arElement['NAME']?>">
						<? endif; ?>
					</div>
				<? endif; ?>
			</div>
			<?
			$i++;
		endforeach;
		?>
	</div>
	<? if(count($arResult['ITEMS']) > $arParams['ELEMENT_VISIBLE_COUNT']): ?>
		<script type="text/javascript">
			$(document).ready(function(){
				var carousel = $('#carousel_<?=$randid?>');
				$('.owl-carousel_item').css('display','block');
				carousel.owlCarousel({
					<? if($arParams['CAROUSEL_DISPOSITION'] == 'ver'):?>
						animateOut: 'slideOutUp',
						animateIn: 'slideInUp',
					<? endif; ?>
					<? if(is_numeric($arParams['AUTO_SPEED'])):?>
						autoplay: true,
						autoplayTimeout: <?=$arParams['AUTO_SPEED']?>,
					<? else:?>
						autoplay: false,
					<? endif; ?>
					items: <?=$arParams['ELEMENT_VISIBLE_COUNT']?>,
					loop: <?=$arParams['CYCLIC'] == 'Y' ? 'true' : 'false'?>,
					mouseDrag: <?=$arParams['MOUSE_DRAG'] == 'Y' ? 'true' : 'false'?>,
					touchDrag: <?=$arParams['TOUCH_DRAG'] == 'Y' ? 'true' : 'false'?>,
					<? if(is_numeric($arParams['START_ELEMENT'])):?>
						startPosition: <?=$arParams['START_ELEMENT']?>,
					<? endif; ?>
					nav: <?=$arParams['SHOW_SWITCH_LR'] == 'Y' ? 'true' : 'false' ?>,
					navText: ["<?=$arParams['TEXT_PREV']?>","<?=$arParams['TEXT_NEXT']?>"],
					<? if(is_numeric($arParams['ELEMENT_SCROLL_COUNT'])):?>
						slideBy: <?=$arParams['ELEMENT_SCROLL_COUNT']?>,
					<? endif;?>
					dots: <?=$arParams['SHOW_SWITCH_EL'] == 'Y' ? 'true' : 'false' ?>,
					dotsEach: <?=$arParams['SHOW_SWITCH_EL_EACH'] == 'Y' ? 'true' : 'false' ?>,
					autoplayHoverPause: <?=$arParams['AUTO_PLAY_HOVER_PAUSE'] == 'Y' ? 'true' : 'false' ?>,
					<? if(is_numeric($arParams['SCROLL_SPEED'])):?>
						smartSpeed: <?=$arParams['SCROLL_SPEED']?>,
					<? endif;?>
					<? if(!empty($arParams['NAV_SPEED']) && is_numeric($arParams['NAV_SPEED'])):?>
						navSpeed: <?=$arParams['NAV_SPEED']?>,
					<? endif;?>
					<? if(!empty($arParams['DOTS_SPEED']) && is_numeric($arParams['DOTS_SPEED'])):?>
						dotsSpeed: <?=$arParams['DOTS_SPEED']?>,
					<? endif;?>
					<? if(!empty($arParams['MARGIN']) && is_numeric($arParams['MARGIN'])):?>
						margin: <?=$arParams['MARGIN']?>,
					<? endif;?>
					rtl: <?=$arParams['RIGHT_TO_LEFT'] == 'Y' ? 'true' : 'false' ?>,
				});
				<? if($arParams['AUTO_PLAY_HOVER_PAUSE'] == 'Y' && is_numeric($arParams['AUTO_SPEED'])):?>
					$('#carousel_<?=$randid?>').hover(
						function(){
							carousel.trigger('stop.owl.autoplay',[<?=$arParams['AUTO_SPEED']?>]);
						},
						function(){
							carousel.trigger('play.owl.autoplay',[<?=$arParams['AUTO_SPEED']?>]);
						}
					);
				<? endif;?>
				<? if($arParams['MOUSE_WHEEL'] == 'Y'):?>
					carousel.on('mousewheel', '.owl-stage', function (e) {
						console.log(e.deltaY);
						if (e.deltaY>0) {
							carousel.trigger('next.owl');
						} else {
							carousel.trigger('prev.owl');
						}
						e.preventDefault();
					});
				<? endif;?>
				<?//Событие добавлено из-за проблем со скриптом при изменении активного окна браузера?>
				<? if(is_numeric($arParams['AUTO_SPEED'])):?>
					$(window).focus(function(){
						carousel.trigger('next.owl');
					});
				<? endif;?>
				<?//Конец?>
				<? if($arParams['USE_PHOTOGALLERY'] == 'Y'): ?>
					$('a.g-fancybox').fancybox();
				<? endif; ?>
			});
		</script>
	<? endif; ?>
</div>
<? endif; ?>