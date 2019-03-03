<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

global ${$arParams['FILTER_NAME']};
$arrFilter = ${$arParams["FILTER_NAME"]};
if(isset($arrFilter['ID']) && count($arrFilter['ID']) > 0) {
	$APPLICATION->IncludeComponent(
		"ma:catalog.section",
		$arParams['ELEMENTS_LIST_TEMPLATE'],
		array(
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
			"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
			"ADD_TO_BASKET_ACTION" => $arParams["ADD_TO_BASKET_ACTION"],
			"AJAX_MODE" => $arParams["AJAX_MODE"],
			"AJAX_OPTION_ADDITIONAL" => $arParams["AJAX_OPTION_ADDITIONAL"],
			"AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
			"AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
			"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
			"CACHE_FILTER" => $arParams["CACHE_FILTER"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"COMPONENT_TEMPLATE" => $arParams["ELEMENTS_LIST_TEMPLATE"],
			"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
			"DETAIL_URL" => $arParams["DETAIL_URL"],
			"DISABLE_INIT_JS_IN_COMPONENT" => $arParams["DISABLE_INIT_JS_IN_COMPONENT"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"DISPLAY_IMG_HEIGHT" => $arParams["DISPLAY_IMG_HEIGHT"],
			"DISPLAY_IMG_WIDTH" => $arParams["DISPLAY_IMG_WIDTH"],
			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
			"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
			"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
			"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"FILTER_PROPERTIES" => $arParams["FILTER_PROPERTIES"],
			"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"MESSAGE_404" => $arParams["MESSAGE_404"],
			"MESS_BTN_ADD_TO_BASKET" => $arParams["MESS_BTN_ADD_TO_BASKET"],
			"MESS_BTN_BUY" => $arParams["MESS_BTN_BUY"],
			"MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
			"MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
			"MESS_NOT_AVAILABLE" => $arParams["MESS_NOT_AVAILABLE"],
			"META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
			"META_KEYWORDS" => $arParams["META_KEYWORDS"],
			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
			"OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
			"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
			"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
			"RESIZE_IMAGE" => $arParams["RESIZE_IMAGE"],
			"SECTION_CODE" => $arParams["SECTION_CODE"],
			"SECTION_ID" => $arParams["SECTION_ID"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"SECTION_URL" => $arParams["SECTION_URL"],
			"SECTION_USER_FIELDS" => $arParams["SECTION_USER_FIELDS"],
			"SEF_MODE" => $arParams["SEF_MODE"],
			"SET_BROWSER_TITLE" => $arParams["SET_BROWSER_TITLE"],
			"SET_CANONICAL_URL" => $arParams["SET_CANONICAL_URL"],
			"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
			"SET_META_DESCRIPTION" => $arParams["SET_META_DESCRIPTION"],
			"SET_META_KEYWORDS" => $arParams["SET_META_KEYWORDS"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"SHOW_404" => $arParams["SHOW_404"],
			"SHOW_ALL_WO_SECTION" => "Y",
			"SHOW_CLOSE_POPUP" => $arParams["SHOW_CLOSE_POPUP"],
			"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
			"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
			"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
			"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
		),
		false,
		array('HIDE_ICONS' => 'Y')
	);
}
else
{
	echo GetMessage("CT_BCSE_NOT_FOUND");
}