<? 
/**
 * Bitrix Framework
 * @copyright 20018 Media Army
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$this->setFrameMode(false);

use Bitrix\Main\Loader;
use Bitrix\Iblock;

if (!Loader::includeModule('iblock')) return;
if (!$arParams["PROPERTY_CODE"]) return;

$arResult = array();
$arResult["USER_ID"] = intval($USER->GetID());

if ($arResult["USER_ID"] <= 0) return;

$rsUser = CUser::GetByID($arResult["USER_ID"]);
$arUser = $rsUser->Fetch();

$arSort = array();
$arFilter = array("IBLOCK_ID"=>$arParams["IBLOCK_ID"],"ID"=>$arUser[$arParams["PROPERTY_CODE"]]);
$arSelect = array(
	"ID",
	"IBLOCK_ID",
	"NAME",
	"PREVIEW_PICTURE",
	"DETAIL_PICTURE"
);

$res = CIBlockElement::GetList(
	$arSort,
	$arFilter,
	false,
	false,
	$arSelect
);

if($obElement = $res->GetNextElement()) {

	$arFields = $obElement->GetFields();

	if ($arParams["DISPLAY_CONTACTS"] === "Y") {

		$arProps = $obElement->GetProperties();

		$arContacts = array();
		if (!empty($arProps[$arParams["IBLOCK_PROPERTY_EMAIL"]]["VALUE"])) {
			if (is_array($arProps[$arParams["IBLOCK_PROPERTY_EMAIL"]]["VALUE"])) {
				foreach ($arProps[$arParams["IBLOCK_PROPERTY_EMAIL"]]["VALUE"] as $val) {
					$arEmail[] = array("TYPE"=>"EMAIL","VALUE"=>$val,"HREF"=>"mailto:".$val);
				}
			} else {
				$arEmail[] = array("TYPE"=>"EMAIL","VALUE"=>$arProps[$arParams["IBLOCK_PROPERTY_EMAIL"]]["VALUE"],"HREF"=>"mailto:".$arProps[$arParams["IBLOCK_PROPERTY_EMAIL"]]["VALUE"]);
			}
			$arContacts = array_merge($arContacts, $arEmail);
		}
		if (!empty($arProps[$arParams["IBLOCK_PROPERTY_SKYPE"]]["VALUE"])) {
			if (is_array($arProps[$arParams["IBLOCK_PROPERTY_SKYPE"]]["VALUE"])) {
				foreach ($arProps[$arParams["IBLOCK_PROPERTY_SKYPE"]]["VALUE"] as $val) {
					$arSkype[] = array("TYPE"=>"SKYPE","VALUE"=>$val,"HREF"=>"skype:".$val);
				}
			} else {
				$arSkype[] = array("TYPE"=>"SKYPE","VALUE"=>$arProps[$arParams["IBLOCK_PROPERTY_SKYPE"]]["VALUE"],"HREF"=>"skype:".$arProps[$arParams["IBLOCK_PROPERTY_SKYPE"]]["VALUE"]);
			}
			$arContacts = array_merge($arContacts, $arSkype);
		}
		if (!empty($arProps[$arParams["IBLOCK_PROPERTY_PHONE"]]["VALUE"])) {
			if (is_array($arProps[$arParams["IBLOCK_PROPERTY_PHONE"]]["VALUE"])) {
				foreach ($arProps[$arParams["IBLOCK_PROPERTY_PHONE"]]["VALUE"] as $val) {
					$arPhone[] = array("TYPE"=>"PHONE","VALUE"=>$val,"HREF"=>"tel:".preg_replace("/[^0-9+]/", "", $val));
				}
			} else {
				$arPhone[] = array("TYPE"=>"PHONE","VALUE"=>$arProps[$arParams["IBLOCK_PROPERTY_PHONE"]]["VALUE"],"HREF"=>"tel:".preg_replace("/[^0-9+]/", "", $arProps[$arParams["IBLOCK_PROPERTY_PHONE"]]));
			}
			$arContacts = array_merge($arContacts, $arPhone);
		}

		$arFields["CONTACTS"] = $arContacts;
	}

	$arResult = $arFields;
}

$this->IncludeComponentTemplate();

?>