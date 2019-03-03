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

if(is_array($arResult["DETAIL_PICTURE"])){
	$arPicture = $arResult["DETAIL_PICTURE"];
}
elseif(is_array($arResult["PREVIEW_PICTURE"])){
	$arPicture = $arResult["PREVIEW_PICTURE"];
}

// Âîäÿíîé çíàê
if($arParams['USE_WATERMARK'] == 'Y' && !empty($arParams['WATERMARK_URL']))
{
	$arFilter = array(
		array(
			"name" => "watermark",
			"position" => "center", // center / bottomright
			"type" => "image",
			//"size" => "real",
			"file" => $_SERVER['DOCUMENT_ROOT'].$arParams['WATERMARK_URL'],
			"fill" => 'repeat', // exact / repeat (íå äîëæíî áûòü "size" => "real") 
		)
	);
}

if(is_array($arPicture))
{
	// $arFilter = '';
	// if($arParams["SHARPEN"] != 0)
	// {
	// 	$arFilter = array(array("name" => "sharpen", "precision" => $arParams["SHARPEN"]));
	// }
	
	if($arParams["DISPLAY_IMG_HEIGHT"] <= 0){
		$arParams["DISPLAY_IMG_HEIGHT"] = 300;
	}
	if($arParams["DISPLAY_IMG_WIDTH"] <= 0){
		$arParams["DISPLAY_IMG_WIDTH"] = 300;
	}

	$arFileTmp = CFile::ResizeImageGet(
		$arPicture,
		array("width" => $arParams["DISPLAY_IMG_WIDTH"], "height" => $arParams["DISPLAY_IMG_HEIGHT"]),
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

if(is_array($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE']))
{
	foreach ($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'] as $key => $idElement)
	{
		$arPicture = CFile::GetFileArray($idElement);

		if(is_array($arPicture))
		{
			// $arFilter = '';
			// if($arParams["SHARPEN"] != 0)
			// {
			// 	$arFilter = array(array("name" => "sharpen", "precision" => $arParams["SHARPEN"]));
			// }
			
			if($arParams["DISPLAY_DOP_IMG_WIDTH"] <= 0){
				$arParams["DISPLAY_DOP_IMG_WIDTH"] = 100;
			}
			if($arParams["DISPLAY_DOP_IMG_HEIGHT"] <= 0){
				$arParams["DISPLAY_DOP_IMG_HEIGHT"] = 100;
			}

			$arFileTmp = CFile::ResizeImageGet(
				$arPicture,
				array("width" => $arParams["DISPLAY_DOP_IMG_WIDTH"], "height" => $arParams["DISPLAY_DOP_IMG_HEIGHT"]),
				$arParams['RESIZE_IMAGE'],
				true, 
				$arFilter
			);

			$arResizePicture = array();
			$arResizePicture['PREVIEW_PICTURE'] = array(
				'SRC' => $arFileTmp["src"],
				'WIDTH' => $arFileTmp["width"],
				'HEIGHT' => $arFileTmp["height"],
			);

			$arFileTmp = CFile::ResizeImageGet(
				$arPicture,
				array("width" => 1600, "height" => 1600),
				$arParams['RESIZE_IMAGE'],
				true, $arFilter
			);
			$arResizePicture['DETAIL_PICTURE'] = array(
				'SRC' => $arFileTmp["src"],
				'WIDTH' => $arFileTmp["width"],
				'HEIGHT' => $arFileTmp["height"],
			);


			$arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'][$key] = $arResizePicture;
		}
	}
}

if($arParams['USE_REVIEW'] == "Y"){
    
    ob_start();
    include('comments.php');
    $arResult['COMMENTS'] = ob_get_contents();
    ob_end_clean();

}

switch($arParams['SOCIAL_BUTTON_TYPE']){
            
    case 'min_count':
        $arResult['SOCIAL_BUTTON_TYPE']['VK'] = 'button';
        $arResult['SOCIAL_BUTTON_TYPE']['FB'] = 'button_count';
        $arResult['SOCIAL_BUTTON_TYPE']['TW'] = 'horizontal';
        break;
    case 'min_up':
        $arResult['SOCIAL_BUTTON_TYPE']['VK'] = 'vertical';
        $arResult['SOCIAL_BUTTON_TYPE']['FB'] = 'box_count';
        $arResult['SOCIAL_BUTTON_TYPE']['TW'] = 'vertical';
        break;
    case 'min':
        $arResult['SOCIAL_BUTTON_TYPE']['VK'] = 'mini';
        $arResult['SOCIAL_BUTTON_TYPE']['FB'] = 'button';
        $arResult['SOCIAL_BUTTON_TYPE']['TW'] = 'none';
        break;
    case 'standart':
        $arResult['SOCIAL_BUTTON_TYPE']['VK'] = 'full';
        $arResult['SOCIAL_BUTTON_TYPE']['FB'] = 'standard';
        $arResult['SOCIAL_BUTTON_TYPE']['TW'] = 'horizontal';
        break;
    
}


// Ссылка на добавление в корзину
$arResult['ADD_TO_BASKET_URL'] = $arParams['SEF_FOLDER'].'add-to-basket/?action=add&id='.$arResult['ID'];

// Ссылка на добавление в сравнение
$arResult['ADD_TO_COMPARE_URL'] = $arParams['SEF_FOLDER'].'add-to-compare/?action=ADD_TO_COMPARE_LIST&id='.$arResult['ID'];

// Ссылка на добавление в избранное
$arResult['ADD_TO_FAVORITE_URL'] = $arParams['SEF_FOLDER'].'add-to-favorite/?action=add&id='.$arResult['ID'];
?>