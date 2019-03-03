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
	
	$arPicture = '';
	if(is_array($arItem["PREVIEW_PICTURE"])) {
		$arPicture = $arItem["PREVIEW_PICTURE"];
	}
	elseif(is_array($arItem["DETAIL_PICTURE"])) {
		$arPicture = $arItem["DETAIL_PICTURE"];
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

}

?>