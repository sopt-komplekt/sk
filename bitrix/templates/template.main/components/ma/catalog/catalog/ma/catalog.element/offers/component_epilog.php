<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */

if($arParams["SET_CANONICAL_URL"] == "Y") {
	$protocol = CMain::IsHTTPS() ? "https" : "http";
	$APPLICATION->AddHeadString('<link href="'.$protocol.'://'.SITE_SERVER_NAME.$APPLICATION->GetCurPage(false).'" rel="canonical" />',true);
}

use Bitrix\Main\Loader;
global $APPLICATION;

$APPLICATION->AddHeadScript('/bitrix/components/ma/catalog/script.js');

if ($arParams['DETAIL_PICTURE_MODE'] == "POPUP") {
	// $APPLICATION->AddHeadScript('/bitrix/components/ma/catalog/fancybox2/jquery.fancybox.pack.js');
	// $APPLICATION->SetAdditionalCSS('/bitrix/components/ma/catalog/fancybox2/jquery.fancybox.css');
	$APPLICATION->AddHeadScript('/bitrix/components/ma/catalog/fancybox3/jquery.fancybox.min.js');
	$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/catalog/fancybox3/jquery.fancybox.min.css');
}

// if (isset($templateData['TEMPLATE_THEME']))
// {
// 	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
// }
if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
	?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
	</script>
<?
	}
}

if (CModule::IncludeModule('sale'))
{
	$dbBasketItems = CSaleBasket::GetList(
		array(
			"ID" => "ASC"
		),
		array(
			"PRODUCT_ID" => $arResult['ID'],
			"FUSER_ID" => CSaleBasket::GetBasketUserID(),
			"LID" => SITE_ID,
			"ORDER_ID" => "NULL",
		),
		false,
		false,
		array()
	);

	if ($arBasket = $dbBasketItems->Fetch())
	{
		if($arBasket["DELAY"] == "Y") {
			echo "<script type=\"text/javascript\">$(function() {disableAddToCart('".$arResult["BUY_LINK"]."', '".GetMessage("CATALOG_IN_CART_DELAY")."')});</script>\r\n";
		} else{
			echo "<script type=\"text/javascript\">$(function() {disableAddToCart('".$arResult["BUY_LINK"]."', '".GetMessage("CATALOG_IN_BASKET")."')});</script>\r\n";
		}

	}

}

if (isset($templateData['JS_OBJ']))
{
?><script type="text/javascript">
BX.ready(BX.defer(function(){
	if (!!window.<? echo $templateData['JS_OBJ']; ?>)
	{
		window.<? echo $templateData['JS_OBJ']; ?>.allowViewedCount(true);
	}
}));
</script><?
}
?>