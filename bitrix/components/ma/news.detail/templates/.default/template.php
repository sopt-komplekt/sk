<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<div class="b-news-detail">

	<? if($arParams["DISPLAY_DATE"] !="N" && $arResult["DISPLAY_ACTIVE_FROM"]): ?>
		<div class="b-news-detail_date">
			<?=$arResult["DISPLAY_ACTIVE_FROM"]?>
		</div>
	<? endif; ?>

	<? if($arParams["DISPLAY_PICTURE"] != "N" &&  is_array($arResult["DETAIL_PICTURE"])):?>
		<div class="b-news-detail_pic">
			<a data-fancybox="news-detail-gallery" href="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
				<img src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>">
			</a>
		</div>
	<? endif; ?>

	<? if(is_array($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'])): ?>
		<div class="b-news-detail_gallery">
		<? foreach($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'] as $arItem):?>
			<div class="b-news-detail_gallery_item">
				<a data-fancybox="news-detail-gallery" href="<?=$arItem['DETAIL_PICTURE']['SRC']?>">
                    <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]?>" title="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>">
                </a>
			</div>
		<? endforeach; ?>
		</div>
	<? endif; ?>

	<? if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]): ?>
		<div class="b-news-detail_preview">
			<?=$arResult["FIELDS"]["PREVIEW_TEXT"]; unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?>
		</div>
	<? endif; ?>

	<div class="b-news-detail_text">
		<? if($arResult["NAV_RESULT"]): ?>
			<? if($arParams["DISPLAY_TOP_PAGER"]): ?><?=$arResult["NAV_STRING"]?><? endif; ?>
				<?=$arResult["NAV_TEXT"]; ?>
			<? if($arParams["DISPLAY_BOTTOM_PAGER"]): ?><?=$arResult["NAV_STRING"]?><? endif; ?>
	 	<? elseif(strlen($arResult["DETAIL_TEXT"])>0): ?>
			<?=$arResult["DETAIL_TEXT"]; ?>
	 	<? else:?>
			<?=$arResult["PREVIEW_TEXT"]; ?>
		<? endif; ?>
	</div>

	<? foreach($arResult["FIELDS"] as $code => $value): ?>
		<? if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code): ?>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>
			<? if (!empty($value) && is_array($value)) :?>
				<img border="0" src="<?=$value["SRC"]?>" width="<?=$value["WIDTH"]?>" height="<?=$value["HEIGHT"]?>">
			<? endif; ?>
		<? else: ?>
			<div>
				<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			</div>
		<? endif; ?>
	<? endforeach; ?>

	<? foreach($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
		<?=$arProperty["NAME"]?>:&nbsp;
		<? if(is_array($arProperty["DISPLAY_VALUE"])): ?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]); ?>
		<? else: ?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<? endif; ?>
		<br />
	<? endforeach; ?>

	<? if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y"): ?>
		<div class="b-news-detail_share">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
	<? endif; ?>

</div>