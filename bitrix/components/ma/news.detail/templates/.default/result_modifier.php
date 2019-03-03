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

if($arParams['RESIZE_DOP_IMAGE'] == 1) {
	$arParams['RESIZE_DOP_IMAGE'] = BX_RESIZE_IMAGE_EXACT;
}
elseif($arParams['RESIZE_DOP_IMAGE'] == 2) {
	$arParams['RESIZE_DOP_IMAGE'] = BX_RESIZE_IMAGE_PROPORTIONAL;
}
elseif($arParams['RESIZE_DOP_IMAGE'] == 3) {
	$arParams['RESIZE_DOP_IMAGE'] = BX_RESIZE_IMAGE_PROPORTIONAL_ALT;
}
else {
	$arParams['RESIZE_DOP_IMAGE'] = BX_RESIZE_IMAGE_PROPORTIONAL;
}

if(is_array($arResult["DETAIL_PICTURE"])){
	$arPicture = $arResult["DETAIL_PICTURE"];
}
elseif(is_array($arResult["PREVIEW_PICTURE"])){
	$arPicture = $arResult["PREVIEW_PICTURE"];
}

if(is_array($arPicture)) {

	$arFilter = '';
	
	if($arParams["DISPLAY_IMG_WIDTH"] <= 0) {
		$arParams["DISPLAY_IMG_WIDTH"] = 250;
	}
	if($arParams["DISPLAY_IMG_HEIGHT"] <= 0) {
		$arParams["DISPLAY_IMG_HEIGHT"] = 250;
	}

	$arFileTmp = CFile::ResizeImageGet(
		$arPicture,
		array("width" => $arParams["DISPLAY_IMG_WIDTH"], "height" => $arParams["DISPLAY_IMG_HEIGHT"]),
		$arParams['RESIZE_IMAGE'],
		true, 
		$arFilter
	);

	$arResult['PREVIEW_PICTURE'] = array(
		'SRC' => $arFileTmp["src"],
		'WIDTH' => $arFileTmp["width"],
		'HEIGHT' => $arFileTmp["height"],
	);

	$arFileTmp = CFile::ResizeImageGet(
		$arPicture,
		array("width" => 1000, "height" => 700),
		$arParams['RESIZE_IMAGE'],
		true, 
		$arFilter
	);

	$arResult['DETAIL_PICTURE'] = array(
		'SRC' => $arFileTmp["src"],
		'WIDTH' => $arFileTmp["width"],
		'HEIGHT' => $arFileTmp["height"],
	);

}

if(is_array($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'])) {

	foreach ($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'] as $key => $idElement) {

		$arPicture = CFile::GetFileArray($idElement);

		if(is_array($arPicture)) {
			
			if($arParams["DISPLAY_DOP_IMG_WIDTH"] <= 0){
				$arParams["DISPLAY_DOP_IMG_WIDTH"] = 70;
			}
			if($arParams["DISPLAY_DOP_IMG_HEIGHT"] <= 0){
				$arParams["DISPLAY_DOP_IMG_HEIGHT"] = 70;
			}

			$arResizePicture = array();

			$arFileTmp = CFile::ResizeImageGet(
				$arPicture,
				array("width" => $arParams["DISPLAY_DOP_IMG_WIDTH"], "height" => $arParams["DISPLAY_DOP_IMG_HEIGHT"]),
				$arParams['RESIZE_DOP_IMAGE'],
				true, 
				$arFilter
			);

			$arResizePicture['PREVIEW_PICTURE'] = array(
				'SRC' => $arFileTmp["src"],
				'WIDTH' => $arFileTmp["width"],
				'HEIGHT' => $arFileTmp["height"],
			);

			$arFileTmp = CFile::ResizeImageGet(
				$arPicture,
				array("width" => 1000, "height" => 700),
				$arParams['RESIZE_DOP_IMAGE'],
				true, $arFilter
			);

			$arResizePicture['DETAIL_PICTURE'] = array(
				'SRC' => $arFileTmp["src"],
				'WIDTH' => $arFileTmp["width"],
				'HEIGHT' => $arFileTmp["height"],
			);

			$arResizePicture['DESCRIPTION'] = $arPicture['DESCRIPTION'];

			$arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'][$key] = $arResizePicture;
		}
	}
}

?>