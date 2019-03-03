<?
	require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/bx_root.php');
	require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT.'/modules/main/include/prolog_before.php');

	$APPLICATION->SetTitle('Товар добавлен в избранное');
?>
<? 
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
	$APPLICATION->RestartBuffer();
?>
<?
$APPLICATION->IncludeComponent(
	"ma:catalog.favorite.result",
	"popup",
	Array(
		"FAVORITE_URL" => "/catalog/favorite/",
	),
	$component,
	array('HIDE_ICONS' => 'Y')
);
?>
<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
	die();
?>