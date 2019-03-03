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

// Водяной знак
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


/***
// Ссылка на добавление в корзину
$arResult['ADD_TO_BASKET_URL'] = '/catalog/add-to-basket/?action=add&id='.implode(',', $arResult["PROPERTIES"]["LINKED_ITEMS"]["VALUE"]).'&quantity='.implode(',', $arResult["PROPERTIES"]["LINKED_ITEMS"]["DESCRIPTION"]);
***/

#--- add to basket link ---
$arResult['ADD_TO_BASKET_URL'] = '/catalog/add-to-basket/?action=add&id='.$arResult['ID'].'&quantity=1';

// Ссылка на добавление в сравнение
$arResult['ADD_TO_COMPARE_URL'] = $arParams['SEF_FOLDER'].'add-to-compare/?action=ADD_TO_COMPARE_LIST&id='.$arResult['ID'];

// Ссылка на добавление в избранное
$arResult['ADD_TO_FAVORITE_URL'] = $arParams['SEF_FOLDER'].'add-to-favorite/?action=add&id='.$arResult['ID'];

$arResult["PROPERTIES"]["PRICE"]["PRINT_VALUE"] = CurrencyFormat($arResult["PROPERTIES"]["PRICE"]["VALUE"], "RUB");

if (!empty($arResult["PROPERTIES"]["PRICE"]["VALUE"])) {
	$arResult["CAN_BUY"] = "Y";
}

// Получение связных элементов

/*
$IBLOCK_SALE_ID = "16";

$arElementList = \Bitrix\Iblock\ElementTable::getList(array(
	"filter" => array("IBLOCK_ID"=> $IBLOCK_SALE_ID, "ACTIVE"=>"Y"),
	"select" => array("*")
	//"select" => array("ID", "NAME", "DISPLAY_ACTIVE_FROM" => "ACTIVE_FROM", "CODE")
))->fetchAll();

foreach ($arElementList as $key => $arElement) {
	$arElementList[$key]["DISPLAY_ACTIVE_FROM"] = $arElement["ACTIVE_FROM"]->format("d.m.Y");
	$arElementList[$key]["DETAIL_PAGE_URL"] = '/personal/notifications/actions/'.$arElement["CODE"].'/';
}

$arResult["ITEMS"] = array_merge($arResult["ITEMS"], $arElementList);

function cmp($a, $b)
{
	$a = $a["DISPLAY_ACTIVE_FROM"];
	$b = $b["DISPLAY_ACTIVE_FROM"];

    if ($a == $b) {
        return 0;
    }
    $a = explode('.', $a);
    $b = explode('.', $b);

    if ($a[2] < $b[2]) return 1;
    if ($b[2] < $a[2]) return -1;

    if ($a[1] < $b[1]) return 1;
    if ($b[1] < $a[1]) return -1;

    if ($a[0] < $b[0]) return 1;
    if ($b[0] < $a[0]) return -1;
    
}

usort($arResult["ITEMS"], "cmp");
*/

?>