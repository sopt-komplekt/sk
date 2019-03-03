<?

require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/bx_root.php');
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT.'/modules/main/include/prolog_before.php');
require_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/profile.php');

?>

<?$APPLICATION->IncludeComponent(
	"ma:sale.basket.basket",
	"mini",
	Array(
		"BASKET_URL" => "/personal/order/make/",
		"HIDE_COUPON" => "N",
		"COLUMNS_LIST" => array(),
		"PRICE_VAT_SHOW_VALUE" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"USE_PREPAYMENT" => "N",
		"SET_TITLE" => "N"
	)
);?> 