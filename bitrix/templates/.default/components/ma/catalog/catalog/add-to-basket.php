<?
	require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/bx_root.php');
	require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT.'/modules/main/include/prolog_before.php');
	
	$APPLICATION->SetTitle('Товар добавлен в корзину');
?>
<? 
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
	$APPLICATION->RestartBuffer();
?>
<?$APPLICATION->IncludeComponent(
	"ma:sale.basket.basket",
	"popup",
	array(
		"BASKET_URL" => "/personal/cart/",
		"HIDE_COUPON" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"USE_PREPAYMENT" => "N",
		"SET_TITLE" => "N"
	),
	false
);?>
<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
	die();
?>