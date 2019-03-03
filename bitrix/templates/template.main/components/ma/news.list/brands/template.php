<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>

<? if (count($arResult['ITEMS']) > 0) :?>

	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>

	<div class="b-brands__list owl-carousel owl-theme jsBrandsSlider">

	<?
		foreach($arResult["ITEMS"] as $arItem):
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
		<div class="b-brands__item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="b-brands__holder">

				<? if($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])):?>
					<div class="b-brands__pic">
						<? if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
								<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem['NAME']?>">
							</a>
						<? else: ?>
							<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem['NAME']?>">
						<? endif; ?>
					</div>
				<? endif; ?>

				<? if($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
					<div class="b-brands__date">
						<?echo $arItem["DISPLAY_ACTIVE_FROM"]?>
					</div>
				<? endif?>

				<? if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]): ?>
					<div class="b-brands__title">
						<? if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
							<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
						<? else: ?>
							<?=$arItem["NAME"]?>
						<? endif; ?>
					</div>
				<? endif; ?>

				<div class="b-brands__text">
					<? if($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]):?>
						<?=$arItem["PREVIEW_TEXT"];?>
					<? endif; ?>
					
					<? foreach($arItem["FIELDS"] as $code=>$value): ?>
						<small>
						<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
						</small>
					<? endforeach; ?>
					
					<? foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty): ?>
						<small>
						<?=$arProperty["NAME"]?>:&nbsp;
						<? if(is_array($arProperty["DISPLAY_VALUE"])):?>
							<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
						<? else:?>
							<?=$arProperty["DISPLAY_VALUE"];?>
						<? endif?>
						</small>
					<? endforeach;?>
				</div>
			</div>
		</div>

	<? endforeach; ?>

	</div>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
	
<?endif;?>