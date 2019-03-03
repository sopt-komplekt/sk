<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? 
if(count($arResult['ITEMS']) > 0): 

	$randid = $this->randString();

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
?>

<div class="b-carousel b-carousel_<?=$arParams['CAROUSEL_DISPOSITION']?>" id="i-carousel-<?=$randid?>" style="width: <?=$arParams['ELEMENT_WIDTH']?>px; height: <?=$arParams['ELEMENT_HEIGHT']?>px;">
	<div class="b-carousel_holder g-carousel-holder">
		<div class="g-carousel-wrapper">
			<? foreach($arResult['ITEMS'] as $arElement): ?>
				<div class="b-carousel_item g-carousel-item" style="width: <?=$elwidth?>; height: <?=$elheight?>;">
					<? if(is_array($arElement['PREVIEW_PICTURE'])): ?>
						<div class="b-carousel_item_pic">
							<? if($arElement['PROPERTIES']['LINK']['VALUE']): ?>
								<a href="<?=$arElement['PROPERTIES']['LINK']['VALUE']?>">
									<img src="<?=$arElement['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arElement['NAME']?>" width="<?=$arElement['PREVIEW_PICTURE']['WIDTH']?>" height="<?=$arElement['PREVIEW_PICTURE']['HEIGHT']?>">
								</a>
							<? elseif($arParams['USE_PHOTOGALLERY'] == 'Y'): // фотогалерея ?>
								<a class="g-fancybox" href="<?=$arElement['DETAIL_PICTURE']['SRC']?>" rel="photo-<?=$randid?>">
									<img src="<?=$arElement['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arElement['NAME']?>" width="<?=$arElement['PREVIEW_PICTURE']['WIDTH']?>" height="<?=$arElement['PREVIEW_PICTURE']['HEIGHT']?>">
								</a>
							<? else: ?>
								<img src="<?=$arElement['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arElement['NAME']?>" width="<?=$arElement['PREVIEW_PICTURE']['WIDTH']?>" height="<?=$arElement['PREVIEW_PICTURE']['HEIGHT']?>">
							<? endif; ?>
						</div>
					<? endif ?>
				</div>
			<? endforeach ?>
		</div>
	</div>
	<? if(count($arResult['ITEMS']) > 1): ?>
		<? if($arParams['SHOW_SWITCH_LR'] == 'Y'): ?>
			<div class="b-carousel_left g-carousel-prev g-ico">
				<?=GetMessage('NAV_LEFT');?>
			</div>
			<div class="b-carousel_right g-carousel-next g-ico">
				<?=GetMessage('NAV_RIGHT');?>
			</div>
		<? endif; ?>
		<? if($arParams['SHOW_SWITCH_EL'] == 'Y'): ?>
			<div class="b-carousel_nav">
				<? foreach($arResult['ITEMS'] as $id => $arElement):
					$arbmtn.= '"#i-nav-'.$id.'"';
					if($id < count($arResult['ITEMS'])) $arbmtn.= ',';
				?>
					<span id="i-nav-<?=$id?>" class="b-carousel_nav_item g-ico<? if($id===0): ?> active<? endif; ?>"><?=$id?></span>
				<? endforeach ?>
			</div>
		<? endif; ?>
		<script type="text/javascript">
		
			$(window).load(function(){
			
				$carousel = $('#i-carousel-<?=$randid?>').carousel({
					<? if($arParams['CAROUSEL_DISPOSITION'] == 'ver'): ?>
					vertical: true,
					<? endif; ?>
					<? if(is_numeric($arParams['AUTO_SPEED'])): ?>
					auto: <?=$arParams['AUTO_SPEED']?>,
					autoHoverPause: <?= $arParams['AUTO_SPEED_HOVER_PAUSE'] == 'Y' ? 'true' : 'false' ?>,
					<? endif; ?>
					<? if($arParams['NOT_CYCLIC'] == 'Y'): ?>
					circular: false,
					<? endif; ?>
					visible: <?=$arParams['ELEMENT_VISIBLE_COUNT']?>,
					scroll: 1,
					speed: <?=$arParams['SCROLL_SPEED']?><? if($arParams['SHOW_SWITCH_EL'] == 'Y'): ?>,<? endif; ?>
					<? if($arParams['SHOW_SWITCH_EL'] == 'Y'): ?>
					btnGo: [<?=$arbmtn?>]
					<? endif; ?>
				});
				<? if($arParams['USE_PHOTOGALLERY'] == 'Y'): ?>
					$('a.g-fancybox').fancybox();
				<? endif; ?>
				
			});
			
		</script>
	<? endif; ?>
</div>

<? endif; ?>

<? //dump($arResult); ?>