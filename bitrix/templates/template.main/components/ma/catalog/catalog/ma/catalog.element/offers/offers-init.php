<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$templateLibrary = array('popup');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);


$mainId = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $mainId,
	'PICT' => $mainId.'_pict',
	'DISCOUNT_PICT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'SLIDER_LIST' => $mainId.'_slider_list',
	'SLIDER_LEFT' => $mainId.'_slider_left',
	'SLIDER_RIGHT' => $mainId.'_slider_right',
	'OLD_PRICE' => $mainId.'_old_price',
	'PRICE' => $mainId.'_price',
	'DISCOUNT_PRICE' => $mainId.'_price_discount',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $mainId.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $mainId.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $mainId.'_slider_right_',
	'QUANTITY' => $mainId.'_quantity',
	'QUANTITY_DOWN' => $mainId.'_quant_down',
	'QUANTITY_UP' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BASIS_PRICE' => $mainId.'_basis_price',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'PROP' => $mainId.'_prop_',
	'PROP_DIV' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
);


$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $mainId);
$templateData['JS_OBJ'] = $strObName;

//передаем id элементов в component-epilog 
$arResult['BUY_LINK']= $arItemIDs['BUY_LINK'];
$cp = $this->__component;
if (is_object($cp)) {
	$cp->arResult['BUY_LINK'];
	$cp->SetResultCacheKeys(array('BUY_LINK'));
};