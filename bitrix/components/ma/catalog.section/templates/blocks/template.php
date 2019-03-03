<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<? if (count($arResult['ITEMS']) > 0) :?>

	<div class="b-catalog-elements-blocks">
		<?
		foreach ($arResult['ITEMS'] as $key => $arItem):
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CATALOG_ELEMENT_DELETE_CONFIRM')));	
		?>
			<div class="b-catalog-elements-blocks_item b-sebi-<?=$arItem['ID']?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	
				<div class="b-catalog-elements-blocks_holder">
					
					<div class="b-catalog-elements-blocks_pic">
						<a href="<?=$arItem['DETAIL_PAGE_URL'];?>">
							<? if ($arItem['PREVIEW_PICTURE']['SRC']): ?>
								<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
							<? else: ?>
								<img src="<?=$templateFolder?>/img/no-photo.png" alt="<?=$arItem['NAME']?>">
							<? endif; ?>
						</a>
					</div>

					<div class="b-catalog-elements-blocks_text">
						<? if($arItem['NAME'] && $arResult['SECTION']['ID'] != $arItem['ID']): ?>
							<div class="b-catalog-elements-blocks_name">
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
							</div>
						<? endif; ?>
						<? if ($arItem['PREVIEW_TEXT']): ?>
							<div class="b-catalog-elements-blocks_description">
								<?=$arItem['PREVIEW_TEXT_TYPE'] == 'text' ? $arItem['PREVIEW_TEXT'] : $arItem['~PREVIEW_TEXT']?>
							</div>
						<? endif; ?>
						
						<? if($arItem["PRICE"]): ?>
							<div class="b-catalog-elements-blocks_order">
								<div class="b-catalog-elements-blocks_price">
									<!-- <span><?=GetMessage("CATALOG_PRICE")?></span> -->
									<?=$arItem["PRICE"]["PRINT_VALUE"]?>
								</div>
								<div class="b-catalog-elements-blocks_buy">
									<noindex>
										<? if(isset($arResult['SHOP_BASKET']['ITEMS'][$arItem['ID']])): ?>
											<a class="g-button-disabled" rel="nofollow" href="<?=$arParams['SEF_FOLDER']?><?=$arParams['SEF_URL_TEMPLATES_ORDER']?>"><?=$arParams['IN_BASKET_TEXT']?></a>
										<? else: ?>
											<a class="g-button" rel="nofollow" href="<?=$arParams['SEF_FOLDER']?>/basket/?action=add&id=<?=$arItem['ID']?>"><?=$arParams['TO_BASKET_TEXT']?></a>
										<? endif; ?>
									</noindex>
								</div>
							</div>
						<? endif; ?>
					</div>
					<div class="b-catalog-elements-blocks_supply">
						<? foreach($arItem["PRICES"] as $code=>$arPrice): ?>
							<? if($arPrice["CAN_ACCESS"]): ?>
								<div class="bmcl_supply-value">
									<span><?=GetMessage("CATALOG_PRICE")?></span>
									<? if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]): ?>
										<span class="catalog-detail-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span> <s><span><?=$arPrice["PRINT_VALUE"]?></span></s>
									<? else: ?>
										<span class="catalog-detail-price"><?=$arPrice["PRINT_VALUE"]?></span>
									<? endif; ?>
								</div>
							<? endif; ?>
						<? endforeach; ?>
						
						<? if($arItem["CAN_BUY"]): ?>
							<div class="bmcl_supply-buttons">
								<!--noindex-->
									<a class="g-button g-add-cart g-ajax-data" href="<?=$arItem["ADD_TO_BASKET_URL"]?>" rel="nofollow" id="catalog_add2cart_link_<?=$arItem["ID"]?>"><?=GetMessage("CATALOG_ADD_TO_BASKET")?></a>
								<!--/noindex-->
							</div>
						<? endif; ?>
			
						<? if(!$arItem["CAN_BUY"] && (count($arItem["PRICES"]) > 0)): ?>
							<div class="bmcl_supply-not-available">
								<!--noindex--><?=GetMessage("CATALOG_NOT_AVAILABLE");?><!--/noindex-->
							</div>
						<? endif; ?>
						
						<? if($arParams["USE_COMPARE"] == "Y"): ?>
							<div class="bmcl_supply-compare">
								<a class="g-ajax-data" href="<?=$arItem["ADD_TO_COMPARE_URL"]?>"><?=GetMessage("CATALOG_COMPARE")?></a>
							</div>
						<? endif; ?>

						<? if($arParams["USE_FAVORITE"] == "Y"): ?>
							<div class="bmcl_supply-favorite">
								<?/* --- Работа с Избранным ---НАЧАЛО- */?>
								<a 
									class="g-ajax-data js-favorite-action"
									href="<?= $arItem['ADD_TO_FAVORITE_URL']; ?>"
									rel="nofollow"
									title="<?= GetMessage('CATALOG_ADD_TO_FAVORITE'); ?>"
									data-add-href="<?= $arItem['ADD_TO_FAVORITE_URL']; ?>"
									data-add-title="<?= GetMessage('CATALOG_ADD_TO_FAVORITE_TITLE'); ?>"
									data-add-text="<?= GetMessage('CATALOG_ADD_TO_FAVORITE_TEXT'); ?>"
									data-remove-href="<?= $arItem['REMOVE_FROM_FAVORITE_URL']; ?>"
									data-remove-title="<?= GetMessage('CATALOG_REMOVE_FROM_FAVORITE_TITLE'); ?>"
									data-remove-text="<?= GetMessage('CATALOG_REMOVE_FROM_FAVORITE_TEXT'); ?>"
									<? if ($arParams['IS_FAVORITE_PAGE'] == "Y"): ?>data-favorite-page="true"<? endif; ?>
								><?=
										GetMessage("CATALOG_ADD_TO_FAVORITE");
								?></a>
								<?/* --- Работа с Избранным ---КОНЕЦ- */?>
							</div>
						<? endif; ?>
						
					</div>
				</div>
			</div>
		<? endforeach; ?>
		<div class="g-clean"></div>
	</div>
	<? if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"];?>
	<? endif; ?>
<? endif; ?>

<? if($arResult['DESCRIPTION'] && $arParams['ELEMENT_SIMILAR_DISPLAY'] != 'Y'): ?>
	<div class="b-catalog-elements-description">
		<?=$arResult['DESCRIPTION']?>
	</div>
<? endif; ?>

