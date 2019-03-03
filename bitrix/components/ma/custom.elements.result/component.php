<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

global $USER;

if(!CModule::IncludeModule("iblock")) {
	ShowError(GetMessage("MA_SP_TEMPLATE_RESULT_IBLOCK_MODULE_NOT_INSTALLED"));
	return 0;
}

if(!isset($arParams["CACHE_TIME"])) {
	$arParams["CACHE_TIME"] = 36000000;
}

$arParams["IBLOCK_TYPE"] = trim($arParams['IBLOCK_TYPE']);
$arParams["IBLOCK_ID"] = intval($arParams['IBLOCK_ID']);

$arResult = array();

$arResult["FIELDS"] = array(
	"TEMPLATE_ID" => "",
	"TEMPLATE_NAME" => "",
	"ACTION" => "",
	"STEP" => "",
);

if($_POST["id"] || $_REQUEST["id"]) {
	$arResult["FIELDS"]["TEMPLATE_ID"] = $_POST["id"] ? $_POST["id"] : $_REQUEST["id"];
}
if($_POST["template_name"]) {
	$arResult["FIELDS"]["TEMPLATE_NAME"] = $_POST["template_name"];
}
if($_POST["action"] || $_REQUEST["action"]) {
	$arResult["FIELDS"]["ACTION"] = $_POST["action"] ? $_POST["action"] : $_REQUEST["action"];
}
if($_POST["step"] || $_REQUEST["step"]) {
	$arResult["FIELDS"]["STEP"] = $_POST["step"] ? $_POST["step"] : $_REQUEST["step"];
}

$arResult["ERRORS"] = array();

if($arResult["FIELDS"]["ACTION"] === "add") {
	if($arResult["FIELDS"]["TEMPLATE_NAME"] && $arResult["FIELDS"]["STEP"] == 1) {
		
		$el = new CIBlockElement;

		$arTemplateArray = array(
			"CREATED_BY" => $USER->GetId(),
			"ACTIVE" => "Y",
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"NAME" => $arResult["FIELDS"]["TEMPLATE_NAME"],
		);
		if($el->Add($arTemplateArray)) {
			$arResult["CHECK_FIELDS"] = "SUCCESS";
			$arResult["MESSAGE"] = $arParams["MESSAGE_RESULT_ADD_TEXT"];
		} else {
			$arResult["CHECK_FIELDS"] = "ERROR";
			$arResult["MESSAGE"] = GetMessage("MA_SP_TEMPLATE_RESULT_ADD_ERROR");
		}
	} elseif($arResult["FIELDS"]["STEP"] == 1) {
		$arResult["CHECK_FIELDS"] = "ERROR";
		$arResult["ERRORS"]["NAME"] = "Y";
		$arResult["MESSAGE"] = GetMessage("MA_SP_TEMPLATE_RESULT_EMPTY_NAME_ERROR");
		$arResult["FIELDS"]["STEP"] = 0;
	}
}
elseif($arResult["FIELDS"]["ACTION"] === "edit") {
	if($arResult["FIELDS"]["TEMPLATE_ID"] > 0 && $arResult["FIELDS"]["TEMPLATE_NAME"] && $arResult["FIELDS"]["STEP"] == 1) {
		
		$el = new CIBlockElement;

		$arFields = array(
			"NAME" => $arResult["FIELDS"]["TEMPLATE_NAME"],
		);
		if($el->Update($arResult["FIELDS"]["TEMPLATE_ID"],$arFields)) {
			$arResult["CHECK_FIELDS"] = "SUCCESS";
			$arResult["MESSAGE"] = $arParams["MESSAGE_RESULT_EDIT_TEXT"];
		} else {
			$arResult["CHECK_FIELDS"] = "ERROR";
			$arResult["MESSAGE"] = GetMessage("MA_SP_TEMPLATE_RESULT_EDIT_ERROR");
		}
	} elseif($arResult["FIELDS"]["STEP"] == 1) {
		$arResult["CHECK_FIELDS"] = "ERROR";
		$arResult["ERRORS"]["NAME"] = "Y";
		$arResult["MESSAGE"] = GetMessage("MA_SP_TEMPLATE_RESULT_EMPTY_NAME_ERROR");
		$arResult["FIELDS"]["STEP"] = 0;
	} else {
		$resItem = CIBlockElement::GetList(array(),array("ID"=>$arResult["FIELDS"]["TEMPLATE_ID"],"ACTIVE"=>"Y"),false,false,array("ID", "NAME"));
		if($arItem = $resItem->GetNext()) {
			$arResult["FIELDS"]["TEMPLATE_NAME"] = $arItem["NAME"];
		}
	}
}
elseif($arResult["FIELDS"]["ACTION"] === "del") {
	if($arResult["FIELDS"]["TEMPLATE_ID"] > 0 && $arResult["FIELDS"]["STEP"] == 2) {
		if(CIBlockElement::Delete($arResult["FIELDS"]["TEMPLATE_ID"])) {
			$arResult["CHECK_FIELDS"] = "SUCCESS";
			$arResult["MESSAGE"] = $arParams["MESSAGE_RESULT_DEL_TEXT"];
		} else {
			$arResult["CHECK_FIELDS"] = "ERROR";
			$arResult["MESSAGE"] = GetMessage("MA_SP_TEMPLATE_RESULT_DEL_ERROR");
		}

	} elseif($arResult["FIELDS"]["TEMPLATE_ID"] > 0) {
		$arResult["FIELDS"]["STEP"] = 1;
		$arResult["MESSAGE"] = $arParams["MESSAGE_CONFIRM"];
	} else {
		if($arResult["FIELDS"]["STEP"] == 1) {
			$arResult["CHECK_FIELDS"] = "ERROR";
			$arResult["MESSAGE"] = GetMessage("MA_SP_TEMPLATE_RESULT_NOT_SELECT_ERROR");
			$arResult["FIELDS"]["STEP"] = 0;
			$arResult["ERRORS"]["TEMPLATE_ID"] = "Y";
		}
		$arOrder = array(
			"created_date" => "asc"
		);
		$arFilter = array(
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"CREATED_USER_ID" => $USER->GetId(),
			"ACTIVE" => "Y"
		);
		$arSelect = array("ID","NAME");
		$res = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
		$arResult["TEMPLATES"] = array();
		while ($arr = $res->GetNext()) {
			$arResult["TEMPLATES"][] = $arr;
		}
		$arResult["FIELDS"]["STEP"] = 0;
	}
}

$this->IncludeComponentTemplate();

if($arResult["FIELDS"]["ACTION"] == "add") {
	$APPLICATION->SetTitle(GetMessage("MA_SP_TEMPLATE_RESULT_ADD_TITLE"));
} elseif($arResult["FIELDS"]["ACTION"] == "edit") {
	$APPLICATION->SetTitle(GetMessage("MA_SP_TEMPLATE_RESULT_EDIT_TITLE"));
} elseif($arResult["FIELDS"]["ACTION"] == "del") {
	$APPLICATION->SetTitle(GetMessage("MA_SP_TEMPLATE_RESULT_DEL_TITLE"));
}