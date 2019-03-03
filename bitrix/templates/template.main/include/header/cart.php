<?$APPLICATION->IncludeComponent("ma:sale.basket.basket.line", "header.cart", Array(
	"HIDE_ON_BASKET_PAGES" => "N",	// Не показывать на страницах корзины и оформления заказа
		"PATH_TO_BASKET" => SITE_DIR."personal/cart/",	// Страница корзины
		"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",	// Страница оформления заказа
		"SHOW_EMPTY_VALUES" => "Y",	// Выводить нулевые значения в пустой корзине
		"SHOW_NUM_PRODUCTS" => "Y",	// Показывать количество товаров
		"SHOW_PRODUCTS" => "N",	// Показывать список товаров
		"SHOW_TOTAL_PRICE" => "N",	// Показывать общую сумму по товарам
	),
	false
);?>