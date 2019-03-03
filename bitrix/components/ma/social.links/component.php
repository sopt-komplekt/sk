<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

$arResult["SOCSERV"] = array();

if (isset($arParams["VKONTAKTE"]) && !empty($arParams["VKONTAKTE"]))
	$arResult["SOCSERV"]["VKONTAKTE"] = array(
		"LINK" => $arParams["VKONTAKTE"],
		"CLASS" => "vk"
	);

if (isset($arParams["FACEBOOK"]) && !empty($arParams["FACEBOOK"]))
	$arResult["SOCSERV"]["FACEBOOK"] = array(
		"LINK" => $arParams["FACEBOOK"],
		"CLASS" => "fb"
	);

if (isset($arParams["ODNOKLASSNIKI"]) && !empty($arParams["ODNOKLASSNIKI"]))
	$arResult["SOCSERV"]["ODNOKLASSNIKI"] = array(
		"LINK" => $arParams["ODNOKLASSNIKI"],
		"CLASS" => "od"
	);

if (isset($arParams["INSTAGRAM"]) && !empty($arParams["INSTAGRAM"]))
	$arResult["SOCSERV"]["INSTAGRAM"] = array(
		"LINK" => $arParams["INSTAGRAM"],
		"CLASS" => "in"
	);

if (isset($arParams["TWITTER"]) && !empty($arParams["TWITTER"]))
	$arResult["SOCSERV"]["TWITTER"] = array(
		"LINK" => $arParams["TWITTER"],
		"CLASS" => "tw"
	);

if (isset($arParams["TUMBLR"]) && !empty($arParams["TUMBLR"]))
	$arResult["SOCSERV"]["TUMBLR"] = array(
		"LINK" => $arParams["TUMBLR"],
		"CLASS" => "tu"
	);

if (isset($arParams["GOOGLE"]) && !empty($arParams["GOOGLE"]))
	$arResult["SOCSERV"]["GOOGLE"] = array(
		"LINK" => $arParams["GOOGLE"],
		"CLASS" => "gp"
	);

if (isset($arParams["YOUTUBE"]) && !empty($arParams["YOUTUBE"]))
	$arResult["SOCSERV"]["YOUTUBE"] = array(
		"LINK" => $arParams["YOUTUBE"],
		"CLASS" => "yt"
	);

if (isset($arParams["LIVE_JOURNAL"]) && !empty($arParams["LIVE_JOURNAL"]))
	$arResult["SOCSERV"]["LIVE_JOURNAL"] = array(
		"LINK" => $arParams["LIVE_JOURNAL"],
		"CLASS" => "lj"
	);


$this->IncludeComponentTemplate();
?>