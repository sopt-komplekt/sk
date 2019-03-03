<?php
/**
 * Файл для ajax-запроса количества товаров в Избранном
 */
require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/bx_root.php');
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT.'/modules/main/include/prolog_before.php');
require_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/profile.php');
?>
<?$APPLICATION->IncludeComponent(
	'ma:catalog.favorite.list', 
	'', 
	array(),
	false
);?>