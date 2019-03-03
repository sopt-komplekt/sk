<? 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;

__IncludeLang($_SERVER["DOCUMENT_ROOT"].$templateFolder."/lang/".LANGUAGE_ID."/template.php");

$APPLICATION->AddHeadScript('/bitrix/components/ma/catalog/script.js');

if($arParams["SET_CANONICAL_URL"] == "Y") {
	$protocol = CMain::IsHTTPS() ? "https" : "http";
	$APPLICATION->AddHeadString('<link href="'.$protocol.'://'.SITE_SERVER_NAME.$APPLICATION->GetCurPage(false).'" rel="canonical" />',true);
}

if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY'])) {
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency) {
?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
	</script>
<?
	}
}

/* --- Работа с Избранным ---НАЧАЛО- */
if($arParams["USE_FAVORITE"] == "Y" && count($arResult['IDS']) > 0) {
	$arFavoriteIdList = $APPLICATION->IncludeComponent(
		'ma:catalog.favorite.result',
		'',
		array(
			'GET_LIST' => 'Y',
		),
		false
	);
	$arFavoriteIdList = $arFavoriteIdList['IDS'];
	$arFavoriteIdList = implode(', ', $arFavoriteIdList);
	?><script>
		var favItemList = [<?= $arFavoriteIdList ?>];
		disableAddToFavorite(favItemList);
	</script><?

}
/* --- Работа с Избранным ---КОНЕЦ- */