<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// https://github.com/rossvs/ipgeobase.php
// https://github.com/rossvs/ipgeobase.php/pull/2/files

require_once("ipgeobase.php");
$gb = new IPGeoBase();


if (isset($_SESSION['LOCATION_IP'])) {
    $arResult['LOCATION_IP'] = $_SESSION['LOCATION_IP'];
}
else {
	$_SESSION['LOCATION_IP'] = $gb->getRecord($_SERVER['REMOTE_ADDR']);
	$arResult['LOCATION_IP'] = $_SESSION['LOCATION_IP'];
}

if (isset($_GET['set_city'])) {
	$city_ID = intval($_GET['set_city']);
	$_SESSION['LOCATION_USER'] = $gb->getCityByIdx($city_ID);
	$arResult['LOCATION_USER'] = $_SESSION['LOCATION_USER'];

	LocalRedirect($APPLICATION->GetCurPageParam('', array('set_city'), false));
}

if(isset($_SESSION['LOCATION_USER'])) {
	$_SESSION['LOCATION_CURRENT'] = $_SESSION['LOCATION_USER'];
	$arResult['LOCATION_CURRENT'] = $_SESSION['LOCATION_USER'];
}
else {
	$_SESSION['LOCATION_CURRENT'] = $_SESSION['LOCATION_IP'];
	$arResult['LOCATION_CURRENT'] = $_SESSION['LOCATION_IP'];
}

// Сохраняем список избранных городов

$_SESSION['FAVORITE_ITEMS'] = $arParams['FAVORITE_ITEMS'];
$arParamsFavoriteItems = $_SESSION['FAVORITE_ITEMS'];

if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

	$referer = parse_url($_SERVER['HTTP_REFERER']);
	parse_str($referer['query'], $arQuery);

	$arResult['LOCATION_ITEMS'] = $gb->getCityList();

	foreach ($arResult['LOCATION_ITEMS'] as $id => $arElement) {

		// добавляем в url параметр set_city

		$arQuery['set_city'] = $arElement['ID'];
		$stQuery = http_build_query($arQuery);

		$arElement['URL'] = $referer['path'].'?'.$stQuery;

		if(in_array($arElement['CITY'], $arResult['LOCATION_CURRENT'])) {
			$arElement['CURRENT'] = 'Y';
			// $arResult['FAVORITE_ITEMS'][] = $arElement;
			// $arFavorireItems[$arElement['CITY']] = $arElement;
		}

		if(in_array($arElement['CITY'], $arParamsFavoriteItems)) {
			$arFavorireItems[$arElement['CITY']] = $arElement;
		}

		$arResult['LOCATION_ITEMS'][$id] = $arElement;

	}

	foreach ($arParamsFavoriteItems as $key => $arElement) {
		if(empty($arElement)) {
			continue;
		}
		$arResult['FAVORITE_ITEMS'][$key] = $arFavorireItems[$arElement];
	}

	foreach ($arFavorireItems as $key => $arElement) {
		// dump($arElement);

	}

	$this->IncludeComponentTemplate();
	die();
}

$this->IncludeComponentTemplate();
return $arResult;

?>