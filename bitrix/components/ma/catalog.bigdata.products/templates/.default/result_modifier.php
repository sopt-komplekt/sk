<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arParams['RESIZE_IMAGE'] == 1) {
	$arParams['RESIZE_IMAGE'] = BX_RESIZE_IMAGE_EXACT;
}
elseif($arParams['RESIZE_IMAGE'] == 2) {
	$arParams['RESIZE_IMAGE'] = BX_RESIZE_IMAGE_PROPORTIONAL;
}
elseif($arParams['RESIZE_IMAGE'] == 3) {
	$arParams['RESIZE_IMAGE'] = BX_RESIZE_IMAGE_PROPORTIONAL_ALT;
}
else {
	$arParams['RESIZE_IMAGE'] = BX_RESIZE_IMAGE_PROPORTIONAL;
}

// cache hack to use items list in component_epilog.php
$this->__component->arResult["IDS"] = array();
$this->__component->arResult["OFFERS_IDS"] = array();

// Обработка ссылок на элементы
if(isset($arParams["DETAIL_URL"]) && strlen($arParams["DETAIL_URL"]) > 0)
	$urlTemplate = $arParams["DETAIL_URL"];
else
	$urlTemplate = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "DETAIL_PAGE_URL");

$arSections = array();
$rsSections = CIBlockSection::GetList(
	array(), 
	array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"LEFT_MARGIN" => $arResult["LEFT_MARGIN"],
		"RIGHT_MARGIN" => $arResult["RIGHT_MARGIN"],
	), 
	false, 
	array("ID", "DEPTH_LEVEL", "SECTION_PAGE_URL")
);

while($arSection = $rsSections->Fetch()) {
	$arSections[$arSection["ID"]] = $arSection;
}

foreach ($arResult['ITEMS'] as $key => $arElement)
{

	$this->__component->arResult["IDS"][] = $arElement["ID"];
	if(is_array($arElement["OFFERS"]) && !empty($arElement["OFFERS"])){
		foreach($arElement["OFFERS"] as $arOffer){
			$this->__component->arResult["OFFERS_IDS"][] = $arOffer["ID"];
		}
	}

	// Постоянные ссылки
	$section_id = $arElement["~IBLOCK_SECTION_ID"];
	if(array_key_exists($section_id, $arSections))
	{
		$urlSection = str_replace(
			array("#SECTION_ID#", "#SECTION_CODE#"),
			array($arSections[$section_id]["ID"], $arSections[$section_id]["CODE"]),
			$urlTemplate
		);

		$arResult["ITEMS"][$key]["DETAIL_PAGE_URL"] = CIBlock::ReplaceDetailUrl(
			$urlSection,
			$arElement,
			true,
			"E"
		);
	}

	// Изображения
	$arPicture = '';
	if(is_array($arElement["DETAIL_PICTURE"])){
		$arPicture = $arElement["DETAIL_PICTURE"];
	}
	elseif(is_array($arElement["PREVIEW_PICTURE"])){
		$arPicture = $arElement["PREVIEW_PICTURE"];
	}

	if(is_array($arPicture))
	{
		$arFilter = '';
		if($arParams["SHARPEN"] != 0)
		{
			$arFilter = array(array("name" => "sharpen", "precision" => $arParams["SHARPEN"]));
		}
		
		if($arParams["DISPLAY_IMG_HEIGHT"] <= 0){
			$arParams["DISPLAY_IMG_HEIGHT"] = 100;
		}
		if($arParams["DISPLAY_IMG_WIDTH"] <= 0){
			$arParams["DISPLAY_IMG_WIDTH"] = 100;
		}

		$arFileTmp = CFile::ResizeImageGet(
			$arPicture,
			array("width" => $arParams["DISPLAY_IMG_WIDTH"], "height" => $arParams["DISPLAY_IMG_HEIGHT"]),
			$arParams['RESIZE_IMAGE'],
			true, 
			$arFilter
		);

		$arResult['ITEMS'][$key]['PREVIEW_PICTURE'] = array(
			'SRC' => $arFileTmp["src"],
			'WIDTH' => $arFileTmp["width"],
			'HEIGHT' => $arFileTmp["height"],
		);
	}

	// Ссылка на добавление в корзину
	if ($arElement['CAN_BUY']) {
		$arResult['ITEMS'][$key]['ADD_URL'] = $arParams['SEF_FOLDER'].'basket/?action=add&id='.$arElement['ID'];
	}
}

$this->__component->SetResultCacheKeys(array("IDS"));
$this->__component->SetResultCacheKeys(array("OFFERS_IDS"));

?>