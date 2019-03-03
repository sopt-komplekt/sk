<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];

$arProperty = array(
	'IBLOCK_SECTION' => GetMessage('ELEMENT_IBLOCK_SECTION'),
	'NAME' => GetMessage('ELEMENT_NAME'),
	'PREVIEW_TEXT' => GetMessage('ELEMENT_PREVIEW_TEXT'),
	'DETAIL_TEXT' => GetMessage('ELEMENT_DETAIL_TEXT'),
	'PREVIEW_PICTURE' => GetMessage('ELEMENT_PREVIEW_PICTURE'),
	'DETAIL_PICTURE' => GetMessage('ELEMENT_DETAIL_PICTURE'),
	'ACTIVE_FROM' => GetMessage('ELEMENT_ACTIVE_FROM'),
	'ACTIVE_TO' => GetMessage('ELEMENT_ACTIVE_TO'),
	'SORT' => GetMessage('ELEMENT_SORT'),
);
$arProperty_LS = array();
//$arProperty_N = array();
//$arProperty_X = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr = $rsProp->Fetch())
{
	$arProperty[$arr["ID"]] = $arr["NAME"];
	if(($arr["PROPERTY_TYPE"] == 'S' || $arr['PROPERTY_TYPE'] == 'N') && $arr['USER_TYPE'] == ''){
		$arProperty_LS[$arr["ID"]] = $arr["NAME"];
	}
}

$arEvent = array();
$arFilter = array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext()){
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".TruncateText($arType["SUBJECT"], 60);
}

	$arComponentParameters = array(
		"GROUPS" => array(
			"VALID" => array(
				"NAME" => GetMessage("IBLOCK_VALIDATOR"),
				"SORT" => "100",
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
			"ACTION_FORM" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("ACTION_FORM"),
				"TYPE" => "STRING",
			),
			"FORM_ID" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("FORM_ID"),
				"TYPE" => "STRING",
			),
			"CHANGE_ITS_ELEMENT" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("CHANGE_ITS_ELEMENT"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"SEND_EMAIL_FORM" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("SEND_EMAIL_FORM"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
				"REFRESH" => "Y",
			),
		),
	);

	if($arCurrentValues["SEND_EMAIL_FORM"] == "Y")
	{
		$arComponentParameters["PARAMETERS"]["EVENT_MESSAGE_ID"] = array(
			"NAME" => GetMessage("MFP_EMAIL_TEMPLATES"), 
			"TYPE"=>"LIST", 
			"VALUES" => $arEvent,
			"DEFAULT"=>"", 
			"MULTIPLE"=>"N",
			"PARENT" => "BASE",
    	);
		$arComponentParameters["PARAMETERS"]["EMAIL_TO"] = array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("EMAIL_TO"),
			"TYPE" => "STRING",
		);
	}
	$arComponentParameters['PARAMETERS']['SAVE_TO_IBLOCK'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("SAVE_TO_IBLOCK"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	);
	$arComponentParameters['PARAMETERS']['SAVE_ACTIVE'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("SAVE_ACTIVE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);
	$arComponentParameters['PARAMETERS']['USE_FORM_ITEM_ID'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("USE_FORM_ITEM"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty,
		"ADDITIONAL_VALUES" => "Y",
	);
	$arComponentParameters['PARAMETERS']['USE_CAPTCHA'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("USE_CAPTCHA"),
		"TYPE" => "LIST",
		"VALUES" => array(
			'NO_CAPTCHA' => GetMessage("NO_CAPTCHA"),
			'COLOR_CAPTCHA' => GetMessage("COLOR_CAPTCHA"),
			'GRAHIC_CAPTCHA' => GetMessage("GRAHIC_CAPTCHA"),
			'HIDDEN_CAPTCHA' => GetMessage("HIDDEN_CAPTCHA")
		),
		"ADDITIONAL_VALUES" => "N",
	);
	$arComponentParameters['PARAMETERS']['USE_JQUERY'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("USE_JQUERY"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);
	$arComponentParameters['PARAMETERS']['TEXT_BUTTON'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("TEXT_BUTTON"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("TEXT_BUTTON_DEFAULT"),
	);
	$arComponentParameters['PARAMETERS']['MESSAGE_RESULT_OK_TEXT'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("MESSAGE_RESULT_OK_TEXT"),
		"TYPE" => "STRING",
		"DEFAULT" => GetMessage("MESSAGE_RESULT_OK_TEXT_DEFAULT"),
	);

	$arComponentParameters['PARAMETERS']["FIELD_VALID"] = array(
		"PARENT" => "VALID",
		"NAME" => GetMessage("FIELD_VALID"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y",
	);

	$arValidExpPreDefined = array(
		'^[0-9a-zA-Z_\.-]+@[0-9a-zA-Z\.-]+$' => 'E-mail',
		'^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$' => GetMessage('FIELD_VALID_REG_EXP_DOMEN'),
		'^(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?$' => GetMessage('FIELD_VALID_REG_EXP_URL'),
		'^[0-9]{13,16}$' => GetMessage('FIELD_VALID_REG_EXP_NUM_CARD'),
		'^(\+?\d{1}\s?)?(\d{10})$' => GetMessage('FIELD_VALID_REG_EXP_NUM_MOBILE'),
		'^(\(\d{3}\)\s?)?(\d{7})$' => GetMessage('FIELD_VALID_REG_EXP_NUM_PHONE1'),
		'^(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{4}$' => GetMessage('FIELD_VALID_REG_EXP_DATE1'),	
		'^(0[1-9]|1[0-9]|2[0-9]|3[01])\.(0[1-9]|1[012])\.[0-9]{4}$' => GetMessage('FIELD_VALID_REG_EXP_DATE2'),	
		'^([0-1]\d|2[0-3])(:[0-5]\d){2}$' => GetMessage('FIELD_VALID_REG_EXP_TIME'),
		'^[a-zA-Z'.GetMessage("FIELD_VALID_REG_EXP_CYR_LOW").GetMessage("FIELD_VALID_REG_EXP_CYR_HIGH").']+$' => GetMessage('FIELD_VALID_REG_EXP_STRING'),
		'^[a-zA-Z'.GetMessage("FIELD_VALID_REG_EXP_CYR_LOW").GetMessage("FIELD_VALID_REG_EXP_CYR_HIGH").'\-_ \s]+$' => GetMessage('FIELD_VALID_REG_EXP_STRING_EX'),
		'^[0-9]+$' => GetMessage('FIELD_VALID_REG_EXP_NUM'),
		'^[0-9\s]+$' => GetMessage('FIELD_VALID_REG_EXP_NUM_EX'),
		'^\-?\d+(\.\d{0,})?$' => GetMessage('FIELD_VALID_REG_EXP_NUM_FLOAT'),
		'^\-?\d+(,\d{0,})?$' => GetMessage('FIELD_VALID_REG_EXP_NUM_FLOAT1'),
		'^[a-zA-Z0-9]+$' => GetMessage('FIELD_VALID_REG_EXP_STR_NUM_LAT'),
		'^['.GetMessage("FIELD_VALID_REG_EXP_CYR_LOW").GetMessage("FIELD_VALID_REG_EXP_CYR_HIGH").'a-zA-Z0-9]+$' => GetMessage('FIELD_VALID_REG_EXP_STR_NUM_LAT_CYR'),					
	);

	if ($arCurrentValues["FIELD_VALID"] == "Y"){
		foreach ($arProperty_LS as $key => $title)
		{
			$arComponentParameters["PARAMETERS"]["VALID_".$key] = array(
				"PARENT" => "VALID",
				"NAME" => $title,
				//"TYPE" => "STRING",
				"TYPE" => "LIST",
				"VALUES" => $arValidExpPreDefined,
				"ADDITIONAL_VALUES" => "Y",
			);
		}
	}

?>