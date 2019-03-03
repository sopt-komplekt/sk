<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__DIR__.'/template.php');

if($arParams["SET_CANONICAL_URL"] == "Y") {
	$protocol = CMain::IsHTTPS() ? "https" : "http";
	$APPLICATION->AddHeadString('<link href="'.$protocol.'://'.SITE_SERVER_NAME.$APPLICATION->GetCurPage(false).'" rel="canonical" />',true);
}

__IncludeLang($_SERVER["DOCUMENT_ROOT"].$templateFolder."/lang/".LANGUAGE_ID."/template.php");

$APPLICATION->AddHeadScript('/bitrix/components/ma/catalog/script.js');

if ($arParams['DETAIL_PICTURE_MODE'] == "POPUP") {
	$APPLICATION->AddHeadScript('/bitrix/components/ma/catalog/fancybox2/jquery.fancybox.pack.js');
	$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/catalog/fancybox2/jquery.fancybox.css');
}


#--- check if product is already in basket ---START-
if (\Bitrix\Main\Loader::includeModule('sale')) {
	$fuserId = \Bitrix\Sale\Fuser::getId();
	$basketItem = \Bitrix\Sale\Internals\BasketTable::getList(array(
		'filter' => array(
			'FUSER_ID' => \Bitrix\Sale\Fuser::getId(),
			'PRODUCT_ID' => $arResult['ID'],
			'LID' => SITE_ID,
			'ORDER_ID' => false,
		),
		'select' => array('ID', 'DELAY', 'CAN_BUY'),
	))->fetch();

	if ($basketItem) { ?>
		<script data-skip-moving="true">
			document.querySelector('#catalog_add2cart_link').text = '<?=
					('Y' == $basketItem['DELAY']) ? Loc::getMessage('CATALOG_IN_CART_DELAY') : Loc::getMessage('CATALOG_IN_BASKET'); ?>';
		</script><?
	}

	/***
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
		if($arBasket["DELAY"] == "Y")
			echo "<script type=\"text/javascript\">$(function() {disableAddToCart('catalog_add2cart_link', '".GetMessage("CATALOG_IN_CART_DELAY")."')});</script>\r\n";
		else
			echo "<script type=\"text/javascript\">$(function() {disableAddToCart('catalog_add2cart_link', '".GetMessage("CATALOG_IN_BASKET")."')});</script>\r\n";
	}
	***/
}
#--- check if product is already in basket ---END-

if ($arParams['USE_COMPARE'])
{
	if (isset(
		$_SESSION[$arParams["COMPARE_NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$arResult['ID']]
	))
	{
		echo '<script type="text/javascript">$(function(){disableAddToCompare(\'catalog_add2compare_link\', \''.GetMessage("CATALOG_IN_COMPARE").'\');})</script>';
	}
}

if (array_key_exists("PROPERTIES", $arResult) && is_array($arResult["PROPERTIES"]))
{
	$sticker = "";

	foreach (Array("SPECIALOFFER", "NEWPRODUCT", "SALELEADER") as $propertyCode)
	{
		if (array_key_exists($propertyCode, $arResult["PROPERTIES"]) && intval($arResult["PROPERTIES"][$propertyCode]["PROPERTY_VALUE_ID"]) > 0)
			$sticker .= "&nbsp;<span class=\"sticker\">".$arResult["PROPERTIES"][$propertyCode]["NAME"]."</span>";
	}

	if ($sticker != "")
		$APPLICATION->SetPageProperty("ADDITIONAL_TITLE", $sticker);
}
if (count($arResult['OFFERS_IDS']) > 0 && CModule::IncludeModule('sale'))
{
	$arItemsInCompare = array();
	foreach ($arResult['OFFERS_IDS'] as $ID)
	{
		if (isset(
			$_SESSION[$arParams["COMPARE_NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$ID]
		))
			$arItemsInCompare[] = $ID;
	}

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
		if (in_array($arItem['PRODUCT_ID'], $arResult['OFFERS_IDS']))
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
			echo "disableAddToCart('catalog_add2cart_link_ofrs_".$id."', '".GetMessage("CATALOG_IN_BASKET")."');\r\n";
		}
		foreach ($arPageItemsDelay as $id) 
		{
			echo "disableAddToCart('catalog_add2cart_link_ofrs_".$id."', '".GetMessage("CATALOG_IN_CART_DELAY")."');\r\n";
		}
		echo '})</script>';
	}
	
	if (count($arItemsInCompare) > 0)
	{
		echo '<script type="text/javascript">$(function(){'."\r\n";
		foreach ($arItemsInCompare as $id) 
		{
			echo "disableAddToCompare('catalog_add2compare_link_ofrs_".$id."', '".GetMessage("CATALOG_IN_COMPARE")."');\r\n";
		}
		echo '})</script>';
	}
}

// use \Bitrix\Catalog\CatalogViewedProductTable as CatalogViewedProductTable;
// CatalogViewedProductTable::refresh($arResult['ID'], CSaleBasket::GetBasketUserID());

?>

<script>
    $(document).ready(function() {
    	var linkedBlock = $('.b-catalog-detail_linked'),
    		tmpBlock = $('.b-mod-catalog-detail_temp-holder');

		tmpBlock.append(linkedBlock);
		linkedBlock.unwrap();
    });
</script>
