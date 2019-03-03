<?
require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/bx_root.php');
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT.'/modules/main/include/prolog_before.php');
?>

<? $APPLICATION->IncludeComponent(
	"ma:ip.geobase",
	"list",
	Array(
		"FAVORITE_ITEMS" => $_SESSION['FAVORITE_ITEMS'],
	)
);?>
