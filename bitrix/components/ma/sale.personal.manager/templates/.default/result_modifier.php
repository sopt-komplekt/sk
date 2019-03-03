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

if (is_array($arResult)) {

	$arPicture = '';
	if(!empty($arResult["PREVIEW_PICTURE"])) {
		$arPicture = CFile::GetFileArray($arResult["PREVIEW_PICTURE"]);
	}
	elseif(!empty($arResult["DETAIL_PICTURE"])) {
		$arPicture = CFile::GetFileArray($arResult["DETAIL_PICTURE"]);
	}

	if(is_array($arPicture)) {

		$arFilter = '';

		if($arParams["SHARPEN"] != 0) {
			$arFilter = array(array("name" => "sharpen", "precision" => $arParams["SHARPEN"]));
		}
		
		if($arParams["IMAGE_WIDTH"] <= 0) {
			$arParams["IMAGE_WIDTH"] = 100;
		}
		if($arParams["IMAGE_HEIGHT"] <= 0) {
			$arParams["IMAGE_HEIGHT"] = 100;
		}
		

		$arPictResize = CFile::ResizeImageGet(
			$arPicture,
			array("width" => $arParams["IMAGE_WIDTH"], "height" => $arParams["IMAGE_HEIGHT"]),
			$arParams['RESIZE_IMAGE'],
			true, 
			$arFilter
		);

		$arResult['PREVIEW_PICTURE'] = array(
			'SRC' => $arPictResize["src"],
			'WIDTH' => $arPictResize["width"],
			'HEIGHT' => $arPictResize["height"],
		);
	}

}

?>
