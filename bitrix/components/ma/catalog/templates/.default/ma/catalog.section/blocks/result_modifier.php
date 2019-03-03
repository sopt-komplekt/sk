<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arParams["SET_CANONICAL_URL"] == "Y" && is_int($arResult["ID"]) && $arResult["ID"] != 0) {
	$arSection = CIblockSection::GetById($arResult["ID"])->GetNext();
	$arResult['SECTION_PAGE_URL'] = $arSection['SECTION_PAGE_URL'];
	$cp = $this->__component; 
	if (is_object($cp)) {
		$cp->SetResultCacheKeys(array('SECTION_PAGE_URL'));
	}
}

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

$arFilter = '';
if($arParams["SHARPEN"] != 0) {
	$arFilter = array(array("name" => "sharpen", "precision" => $arParams["SHARPEN"]));
}

if($arParams["DISPLAY_IMG_WIDTH"] <= 0) {
	$arParams["DISPLAY_IMG_WIDTH"] = 100;
}
if($arParams["DISPLAY_IMG_HEIGHT"] <= 0) {
	$arParams["DISPLAY_IMG_HEIGHT"] = 100;
}

foreach ($arResult['ITEMS'] as $key => $arItem)
{

	// Изображения
	$arPicture = '';
	if(is_array($arItem["DETAIL_PICTURE"])) {
		$arPicture = $arItem["DETAIL_PICTURE"];
	}
	elseif(is_array($arItem["PREVIEW_PICTURE"])) {
		$arPicture = $arItem["PREVIEW_PICTURE"];
	}

	if(is_array($arPicture)) {
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
	if ($arItem['CAN_BUY']) {
		$arResult['ITEMS'][$key]['ADD_TO_BASKET_URL'] = $arParams['SEF_FOLDER'].'add-to-basket/?action=add&id='.$arItem['ID'];
	}

	// Ссылка на добавление в сравнение
	$arResult['ITEMS'][$key]['ADD_TO_COMPARE_URL'] = $arParams['SEF_FOLDER'].'add-to-compare/?action=ADD_TO_COMPARE_LIST&id='.$arItem['ID'];


	/* --- Работа с Избранным, ч.1 ---НАЧАЛО- */
	$arResult['IDS'][] = $arItem['ID'];
	// Ссылка на добавление и удаление из избранного
	$arResult['ITEMS'][$key]['ADD_TO_FAVORITE_URL'] = $arParams['SEF_FOLDER'].'add-to-favorite/?action=add&id='.$arItem['ID'];
	$arResult['ITEMS'][$key]['REMOVE_FROM_FAVORITE_URL'] = $arParams['SEF_FOLDER'].'add-to-favorite/?action=remove&id='.$arItem['ID'];
	/* --- Работа с Избранным, ч.1 ---КОНЕЦ- */

}

/* --- Работа с Избранным, ч.2 ---НАЧАЛО- */
$cp = $this->__component; 
if (is_object($cp)) {
	$cp->SetResultCacheKeys(array('IDS'));
}
/* --- Работа с Избранным, ч.2 ---КОНЕЦ- */

?>