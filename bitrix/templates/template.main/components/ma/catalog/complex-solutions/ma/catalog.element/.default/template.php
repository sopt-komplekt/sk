<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 

use \Bitrix\Main\Localization\Loc as Loc;

$this->setFrameMode(true);
?>

<div class="b-catalog-detail<? if(is_array($arResult['DETAIL_PICTURE'])): ?> with-detail-picture<? endif; ?>">
	<? if(is_array($arResult['DETAIL_PICTURE']) || is_array($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'])): ?>
		<div class="b-catalog-detail_holder-pic">
			<? if(is_array($arResult['DETAIL_PICTURE'])): ?>
				<div class="b-catalog-detail_detail-pic">
					<a class="g-fancybox" href="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
						<img
							src="<?=$arResult['DETAIL_PICTURE']['SRC']?>"
							alt="<?if (!empty($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"])):?><?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]?><?else:?><?=$arResult["NAME"]?><?endif;?>"
							title="<?if (!empty($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"])):?><?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]?><?else:?><?=$arResult["NAME"]?><?endif;?>"
						/>
					</a>
				</div>
			<? endif; ?>
			<? if(is_array($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE']) && count($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE']) > 0): ?>
				<div class="b-catalog-detail_more-pic">
				<? foreach($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'] as $arItem):?>
					<div class="b-catalog-detail_more-pic_item">
						<a class="g-fancybox" href="<?=$arItem['DETAIL_PICTURE']['SRC']?>">
							<img
								src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"
								alt="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]?>"
								title="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]?>"
								/>
						</a>
					</div>
				<? endforeach; ?>
				</div>
			<? endif; ?>
		</div>
		<?php if ($arParams['DETAIL_PICTURE_MODE'] == "POPUP"): ?>
			<script type="text/javascript">
				$(document).ready(function() {
					$('a.g-fancybox').fancybox();
				});
			</script>

		<?php endif ?>		
		
	<? else: ?>
	
		<div class="b-catalog-detail_holder-no_pic_wrap">
	
			<div class="b-catalog-detail_holder-no_pic"></div>
		
		</div>
		
	<? endif; ?>
	<? if($arResult["DETAIL_TEXT"]): ?>
		<div class="b-catalog-detail_detail-text">
			<span class="b-catalog-detail_detail-text_title">Описание</span>
			<?=$arResult["DETAIL_TEXT"];?>
		</div>
	<? endif; ?>

	<div class="b-mod-catalog-detail_temp-holder"></div>
	<div class="b-mod-catalog-detail_supply"><?
		foreach ($arResult['PRICES'] as $code => $arPrice) {
			if ($arPrice['CAN_ACCESS']) {
				if ($arPrice['DISCOUNT_VALUE'] < $arPrice['VALUE']) {
					$curPrice = $arPrice['PRINT_DISCOUNT_VALUE'];
					$oldPrice = $arPrice['PRINT_VALUE'];
				} else {
					$curPrice = $arPrice['PRINT_VALUE'];
					$oldPrice = false;
				}
			}
		}
		?>
		<div class="b-catalog-detail-price">
			<div class="b-catalog-detail-price_holder">
				<span class="b-catalog-detail-price_title">Стоимость комплекта:</span>
				<span class="b-cur_price">
					<? if ($arResult["PROPERTIES"]["PRICE"]["PRINT_VALUE"]): ?>
						<? $frame = $this->createFrame()->begin(""); ?>
							<?=$arResult["PROPERTIES"]["PRICE"]["PRINT_VALUE"]?>
						<? $frame->end(); ?>
					<? else: ?>
						<span class="not_price"><?= Loc::getMessage('NOT_PRICE'); ?></span>
					<? endif ?>
				</span>
			</div>
			<? if($arResult["CAN_BUY"]): ?>
				<!--noindex-->
				<? $frame = $this->createFrame()->begin(""); ?>
				<a href="<?= $arResult["ADD_TO_BASKET_URL"]; ?>" rel="nofollow" class="g-button g-add-cart g-ajax-data" id="catalog_add2cart_link">
					<?= Loc::getMessage('CATALOG_BUY'); ?>
				</a>
				<? $frame->end(); ?>
				<!--/noindex-->
			<? endif; ?>
			
			<? if(!$arResult["CAN_BUY"] && (count($arResult["PRICES"]) > 0)): ?>
				<?= Loc::getMessage('CATALOG_NOT_AVAILABLE'); ?>
			<? endif; ?>

			<? if ($arParams["USE_COMPARE"] == "Y"): ?>
				<a class="g-ajax-data" href="<?=$arResult["ADD_TO_COMPARE_URL"]?>"><?= Loc::getMessage('CATALOG_COMPARE'); ?></a>
			<? endif; ?>

			<? if ($arParams["USE_FAVORITE"] == "Y"): ?>
				<a class="g-ajax-data" href="<?=$arResult["ADD_TO_FAVORITE_URL"]?>"><?= Loc::getMessage('CATALOG_FAVORITE'); ?></a>
			<? endif; ?>

		</div>
		
		<? if($oldPrice): ?>
			<div class="b-catalog-detail-old_price">
				<?= Loc::getMessage('OLD_PRICE'); ?> <span class="b-old_price"><?= $oldPrice; ?></span>        
			</div>
		<? endif; ?>
	</div>
	<?php if (!empty($arResult['COMMENTS'])): ?>
		<div class="b-catalog-detail-comments">
			<?=$arResult['COMMENTS']; ?>
		</div>
	<?php endif ?>        
	<div class="g-clean"></div>
</div>

<script>
	BX.message({
		'CATALOG_IN_BASKET': '<?= Loc::getMessage('CATALOG_IN_BASKET'); ?>',
	});
</script>