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
	$arParams['RESIZE_IMAGE'] = BX_RESIZE_IMAGE_EXACT;
}

foreach ($arResult['ITEMS'] as $key => $arElement)
{
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

		$arFileTmp = CFile::ResizeImageGet(
			$arPicture,
			array("width" => $arParams["ELEMENT_WIDTH"], "height" => $arParams["ELEMENT_HEIGHT"]),
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