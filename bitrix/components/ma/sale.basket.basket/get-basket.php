<?
	require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/bx_root.php');
	require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT.'/modules/main/include/prolog_before.php');
	require_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/profile.php');

	if (empty($_REQUEST['template'])) {
		$_REQUEST['template'] = '';
	}
	$APPLICATION->IncludeComponent("ma:sale.basket.basket", $_REQUEST['template'], array(
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "PRICE",
			3 => "QUANTITY",
			4 => "SUM",
			5 => "PROPS",
			6 => "DELETE",
			7 => "DELAY",
		),
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"PATH_TO_ORDER" => "/personal/order/make/",
		"HIDE_COUPON" => "N",
		"QUANTITY_FLOAT" => "N",
		"PRICE_VAT_SHOW_VALUE" => "Y",
		"TEMPLATE_THEME" => "site",
		"SET_TITLE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"OFFERS_PROPS" => array(
			0 => "SIZES_SHOES",
			1 => "SIZES_CLOTHES",
			2 => "COLOR_REF",
		),
		),
		false
	);
?>