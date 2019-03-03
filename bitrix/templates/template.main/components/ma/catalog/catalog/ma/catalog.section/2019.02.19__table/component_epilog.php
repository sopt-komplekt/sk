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

if (count($arResult['IDS']) > 0 && CModule::IncludeModule('sale'))
{
	$dbBasketItems = CSaleBasket::GetList(
		array(
			"ID" => "ASC"
		),
		array(
			"FUSER_ID" => CSaleBasket::GetBasketUserID(),
			"LID" => SITE_ID,
			"ORDER_ID" => "NULL",
			),
		false,
		false,
		array()
	);

	$arPageItems = array();
	$arPageItemsDelay = array();
	while ($arItem = $dbBasketItems->Fetch())
	{
		if (in_array($arItem['PRODUCT_ID'], $arResult['IDS']))
		{
			if($arItem["DELAY"] == "Y")
				$arPageItemsDelay[] = $arItem['PRODUCT_ID'];
			else
				$arPageItems[] = $arItem['PRODUCT_ID'];
		}
	}
	
	if (count($arPageItems) > 0 || count($arPageItemsDelay) > 0)
	{
		echo '<script type="text/javascript">$(function(){'."\r\n";
		foreach ($arPageItems as $id) 
		{
			echo "disableAddToCart('catalog_add2cart_link_".$id."', '".GetMessage("CATALOG_IN_CART")."');\r\n";
		}
		foreach ($arPageItemsDelay as $id) 
		{
			echo "disableAddToCart('catalog_add2cart_link_".$id."', '".GetMessage("CATALOG_IN_CART_DELAY")."');\r\n";
		}
		echo '})</script>';
	}
}