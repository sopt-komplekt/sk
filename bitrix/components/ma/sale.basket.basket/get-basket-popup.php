<?
	$APPLICATION->IncludeComponent("ma:sale.basket.basket", "popup", array(
		"BASKET_URL" => $arParams['BASKET_URL'],
		"HIDE_COUPON" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"USE_PREPAYMENT" => "N",
		"SET_TITLE" => "N"
		),
		false
	);
?>