<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];

$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr = $rsProp->Fetch())
{
	$arProperty[$arr["ID"]] = $arr["NAME"];
}

$arComponentParameters = array(
	"GROUPS" => array(),
	"PARAMETERS" => array(
		"AJAX_MODE" => array(),
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_IBLOCK_IBLOCK"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		),
		"TEXT_BUTTON_ADD" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_TEXT_BUTTON_ADD"),
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_TEXT_BUTTON_ADD_DEFAULT"),
		),
		"TEXT_BUTTON_DEL" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_TEXT_BUTTON_DEL"),
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_TEXT_BUTTON_DEL_DEFAULT"),
		),
		"TEXT_BUTTON_EDIT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_TEXT_BUTTON_EDIT"),
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_TEXT_BUTTON_EDIT_DEFAULT"),
		),
		"MESSAGE_TITLE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_MESSAGE_TITLE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"MESSAGE_DESCRIPTION" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_MESSAGE_DESCRIPTION"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"MESSAGE_RESULT_ADD_TEXT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_MESSAGE_RESULT_ADD_TEXT"),
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_MESSAGE_RESULT_ADD_TEXT_DEFAULT"),
		),
		"MESSAGE_RESULT_DEL_TEXT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_MESSAGE_RESULT_DEL_TEXT"),
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_MESSAGE_RESULT_DEL_TEXT_DEFAULT"),
		),
		"MESSAGE_RESULT_EDIT_TEXT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_MESSAGE_RESULT_EDIT_TEXT"),
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_MESSAGE_RESULT_EDIT_TEXT_DEFAULT"),
		),
		"MESSAGE_CONFIRM" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_MESSAGE_CONFIRM_DEL_PROJECT"),
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_MESSAGE_CONFIRM_DEL_PROJECT_DEFAULT"),
		),
	),
);