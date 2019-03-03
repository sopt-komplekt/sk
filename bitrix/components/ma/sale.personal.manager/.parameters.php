<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch()) {
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$arUserProperty = array();
$rsProp = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("USER", 0, LANGUAGE_ID);
if (!empty($rsProp)) {
	foreach ($rsProp as $key => $val) {
		$arUserProperty[$val["FIELD_NAME"]] = (strLen($val["EDIT_FORM_LABEL"]) > 0 ? $val["EDIT_FORM_LABEL"] : $val["FIELD_NAME"]);
	}
}

$arProperty = array();
$rsProp = CIBlockProperty::GetList(
	array("sort"=>"asc", "name"=>"asc"), 
	array("IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"], "PROPERTY_TYPE"=>"S", "ACTIVE"=>"Y", ));
while ($arr=$rsProp->Fetch()){
	$arProperty[$arr["CODE"]] = $arr["NAME"]." [".$arr["CODE"]."]";
}

$arComponentParameters = array(
	"GROUPS" => array(
		"PERSONAL_PHOTO" => array(
			"NAME" => GetMessage("SPM_PERSONAL_PHOTO_NAME"),
			"SORT" => "200",
		),
		"FEEDBACK" => array(
			"NAME" => GetMessage("SPM_FEEDBACK_NAME"),
			"SORT" => "300",
		),
		"CONTACTS" => array(
			"NAME" => GetMessage("SPM_CONTACTS_NAME"),
			"SORT" => "400",
		),
	),
	"PARAMETERS" => array(
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_IBLOCK"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		),
		"PROPERTY_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SPM_PROPERTY_CODE"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arUserProperty,
		),
		"DISPLAY_IMAGE" => array(
			"PARENT" => "PERSONAL_PHOTO",
			"NAME" => GetMessage("SPM_DISPLAY_IMAGE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		"PATH_TO_MESSAGE_FORM" => array(
			"PARENT" => "FEEDBACK",
			"NAME" => GetMessage("SPM_PATH_TO_MESSAGE_FORM"),
			"TYPE" => "SRTING",
			"DEFAULT" => "",
		),
		"PATH_TO_ORDER_CALL_FORM" => array(
			"PARENT" => "FEEDBACK",
			"NAME" => GetMessage("SPM_PATH_TO_ORDER_CALL_FORM"),
			"TYPE" => "SRTING",
			"DEFAULT" => "",
		),
		"DISPLAY_CONTACTS" => array(
			"PARENT" => "CONTACTS",
			"NAME" => GetMessage("SPM_DISPLAY_CONTACTS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		
	),
);

if ($arCurrentValues["DISPLAY_IMAGE"] == "Y") {
	$arComponentParameters['PARAMETERS']["IMAGE_WIDTH"] = array(
		"PARENT" => "PERSONAL_PHOTO",
		"NAME" => GetMessage("SPM_IMAGE_WIDTH"),
		"TYPE" => "STRING",
		"DEFAULT" => "100",
	);
	$arComponentParameters['PARAMETERS']["IMAGE_HEIGHT"] = array(
		"PARENT" => "PERSONAL_PHOTO",
		"NAME" => GetMessage("SPM_IMAGE_HEIGHT"),
		"TYPE" => "STRING",
		"DEFAULT" => "100",
	);
	$arComponentParameters['PARAMETERS']["RESIZE_IMAGE"] = array(
		"PARENT" => "PERSONAL_PHOTO",
		"NAME" => GetMessage("RESIZE_IMAGE"),
		"TYPE" => "LIST",
		"VALUES" => array(
			"1" => GetMessage("RESIZE_IMAGE_EXACT"),
			"2" => GetMessage("RESIZE_IMAGE_PROPORTIONAL"),
			"3" => GetMessage("RESIZE_IMAGE_PROPORTIONAL_ALT"),
		),
		"DEFAULT" => "BX_RESIZE_IMAGE_EXACT",
		"ADDITIONAL_VALUES" => "N",
	);
}

if ($arCurrentValues["DISPLAY_CONTACTS"] == "Y") {
	$arComponentParameters['PARAMETERS']["IBLOCK_PROPERTY_EMAIL"] = array(
		"PARENT" => "CONTACTS",
		"NAME" => GetMessage("SPM_IBLOCK_PROPERTY_EMAIL"),
		"TYPE" => "LIST",
		"VALUES" => $arProperty,
	);
	$arComponentParameters['PARAMETERS']["IBLOCK_PROPERTY_SKYPE"] = array(
		"PARENT" => "CONTACTS",
		"NAME" => GetMessage("SPM_IBLOCK_PROPERTY_SKYPE"),
		"TYPE" => "LIST",
		"VALUES" => $arProperty,
	);
	$arComponentParameters['PARAMETERS']["IBLOCK_PROPERTY_PHONE"] = array(
		"PARENT" => "CONTACTS",
		"NAME" => GetMessage("SPM_IBLOCK_PROPERTY_PHONE"),
		"TYPE" => "LIST",
		"VALUES" => $arProperty,
	);
}

?>