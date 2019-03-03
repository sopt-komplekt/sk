<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

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

if (is_array($arResult["SECTION"])) {

	if(!empty($arResult["SECTION"]["DETAIL_PICTURE"])){
		$arPicture = CFile::GetFileArray($arResult["SECTION"]["DETAIL_PICTURE"]);
	}
	elseif(!empty($arResult["SECTION"]["PICTURE"])){
		$arPicture = CFile::GetFileArray($arResult["SECTION"]["PICTURE"]);
	}

	if(is_array($arPicture))
	{
		$arFilter = '';
		if($arParams["SHARPEN"] != 0)
		{
			$arFilter = array(array("name" => "sharpen", "precision" => $arParams["SHARPEN"]));
		}
		
		if($arParams["DISPLAY_IMG_WIDTH"] <= 0){
			$arParams["DISPLAY_IMG_WIDTH"] = 333;
		}
		if($arParams["DISPLAY_IMG_HEIGHT"] <= 0){
			$arParams["DISPLAY_IMG_HEIGHT"] = 280;
		}

		$arFileTmp = CFile::ResizeImageGet(
			$arPicture,
			array("width" => $arParams["DISPLAY_IMG_WIDTH"], "height" => $arParams["DISPLAY_IMG_HEIGHT"]),
			$arParams['RESIZE_IMAGE'],
			true, $arFilter
		);

		$arResult['SECTION']['PREVIEW_PICTURE'] = array(
			'SRC' => $arFileTmp["src"],
			'WIDTH' => $arFileTmp["width"],
			'HEIGHT' => $arFileTmp["height"],
		);
	}

}


?>