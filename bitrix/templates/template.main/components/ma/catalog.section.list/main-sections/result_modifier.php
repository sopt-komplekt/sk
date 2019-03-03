<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arParams["DISPLAY_IMG_WIDTH"] <= 0) {
	$arParams["DISPLAY_IMG_WIDTH"] = 330;
}
if($arParams["DISPLAY_IMG_HEIGHT"] <= 0) {
	$arParams["DISPLAY_IMG_HEIGHT"] = 230;
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

$arSections = array();
foreach ($arResult['SECTIONS'] as $key => $arSection)
{
	if ($arSection['IBLOCK_SECTION_ID'] > $arResult['SECTION']['ID'])
		$arSections[$arSection['IBLOCK_SECTION_ID']]['CHILDREN'][$arSection['ID']] = $arSection;
	else
	{
		$arSections[$arSection['ID']] = $arSection;
		$arSection['CHILDREN'] = array();
	}
} 
$arResult['SECTIONS'] = $arSections;

foreach ($arResult['SECTIONS'] as $key => $arSection)
{
	$arPicture = '';
	if(is_array($arSection["DETAIL_PICTURE"])){
		$arPicture = $arSection["DETAIL_PICTURE"];
	}
	elseif(is_array($arSection["PICTURE"])){
		$arPicture = $arSection["PICTURE"];
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
			array("width" => $arParams["DISPLAY_IMG_WIDTH"], "height" => $arParams["DISPLAY_IMG_HEIGHT"]),
			$arParams['RESIZE_IMAGE'],
			true, $arFilter
		);

		$arResult['SECTIONS'][$key]['PREVIEW_PICTURE'] = array(
			'SRC' => $arFileTmp["src"],
			'WIDTH' => $arFileTmp["width"],
			'HEIGHT' => $arFileTmp["height"],
		);
	}
}

if ($arParams["ORDER_REVERSE"] == "Y") {
	$arResult['SECTIONS'] = array_reverse($arResult['SECTIONS']);
}

?>