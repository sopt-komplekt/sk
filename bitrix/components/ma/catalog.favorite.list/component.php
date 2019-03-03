<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;
$userID = 0;
if($USER->IsAuthorized()) {
	$userID = $USER->GetID();
}

$arResult = array();
$arResult["ITEMS"] = array();

if($userID > 0) {
	$rsUser = CUser::GetByID($userID);
	$arUser = $rsUser->Fetch();
	$favorites = $arUser["UF_FAVORITES"];
	if(strlen($favorites) > 0) {
		$arFavorites = unserialize($favorites);
		$favItems = $arFavorites;
	}
} else {
	$prefix = COption::GetOptionString("main", "cookie_name", "BITRIX_SM");
	$favorites = $APPLICATION->get_cookie("UF_FAVORITES", $prefix);
	if(strlen($favorites) > 0) {
		$arFavorites = unserialize($favorites);
		$favItems = $arFavorites;
	}
}

$arResult["ITEMS"] = $favItems;

$this->includeComponentTemplate();