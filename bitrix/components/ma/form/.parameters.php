<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];

$arProperty = array();
$arProperty_LS = array();
$arProperty_M = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr = $rsProp->Fetch())
{
	$arProperty[$arr["ID"]] = $arr["NAME"];
	if(($arr["PROPERTY_TYPE"] == 'S' || $arr['PROPERTY_TYPE'] == 'N') && $arr['USER_TYPE'] == '') {
		$arProperty_LS[$arr["ID"]] = $arr["NAME"];
	}
	if($arr["PROPERTY_TYPE"] == "F" && $arr["MULTIPLE"] == "Y") {
		$arProperty_M[$arr["ID"]] = $arr["NAME"];
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
				"SORT" => "600",
			),
			"BITRIX24" => array(
				"NAME" => GetMessage("IBLOCK_BITRIX24"),
				"SORT" => "700",
			),
			"PERSONAL" => array(
				"NAME" => GetMessage("IBLOCK_PERSONAL"),
				"SORT" => "800",
			),
			"GOALS" => array(
				"NAME" => GetMessage("IBLOCK_GOALS"),
				"SORT" => "900",
			),
		),
		"PARAMETERS" => array(
			"AJAX_MODE" => array(),
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
		$arComponentParameters["PARAMETERS"]["EMAIL_TO"] = array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("EMAIL_TO"),
			"TYPE" => "STRING",
		);
		$arComponentParameters["PARAMETERS"]["EVENT_MESSAGE_ID"] = array(
			"NAME" => GetMessage("MFP_EMAIL_TEMPLATES"), 
			"TYPE"=>"LIST", 
			"VALUES" => $arEvent,
			"DEFAULT"=>"", 
			"MULTIPLE"=>"N",
			"PARENT" => "BASE",
    	);
	}

	$arComponentParameters['PARAMETERS']['SEND_EMAIL_FORM_USER'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("SEND_EMAIL_FORM_USER"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y",
	);

	if($arCurrentValues["SEND_EMAIL_FORM_USER"] == "Y")
	{
    	$arComponentParameters['PARAMETERS']['EMAIL_FROM_USER'] = array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("EMAIL_FROM_USER"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => $arProperty,
			"ADDITIONAL_VALUES" => "Y",
		);
		$arComponentParameters["PARAMETERS"]["EVENT_MESSAGE_ID_USER"] = array(
			"NAME" => GetMessage("MFP_EMAIL_TEMPLATES_USER"), 
			"TYPE"=>"LIST", 
			"VALUES" => $arEvent,
			"DEFAULT"=>"", 
			"MULTIPLE"=>"N",
			"PARENT" => "BASE",
    	);
	}

	$arComponentParameters['PARAMETERS']['SAVE_TO_IBLOCK'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("SAVE_TO_IBLOCK"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	);
	$arComponentParameters['PARAMETERS']['USE_FORM_ITEM_ID'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("USE_FORM_ITEM"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty,
		"ADDITIONAL_VALUES" => "Y",
		"REFRESH" => "Y",
	);
	if(is_array($arCurrentValues['USE_FORM_ITEM_ID']) && count($arCurrentValues['USE_FORM_ITEM_ID']) > 0 && $arCurrentValues['USE_FORM_ITEM_ID'][0] > 0) {
		$hiddenProperty = array();
		foreach ($arProperty as $key => $value) {
			if(in_array($key, $arCurrentValues['USE_FORM_ITEM_ID'])) {
				$hiddenProperty[$key] = $value;
			}
		}		
		$arComponentParameters['PARAMETERS']['USE_FORM_ITEM_ID_HIDDEN'] = array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("USE_FORM_ITEM_HIDDEN"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $hiddenProperty,
			"ADDITIONAL_VALUES" => "Y",
		);
	}
	foreach ($arCurrentValues['USE_FORM_ITEM_ID'] as $key => $value) {
		if(array_key_exists($value, $arProperty_M)) {
			$arComponentParameters['PARAMETERS']['MAX_FILES_'.$value] = array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("MAX_FILES", array("#FIELD_NAME#" => $arProperty_M[$value])),
				"TYPE" => "STRING",
				"DEFAULT" => "10",
			);
			$arComponentParameters['PARAMETERS']['CREATE_ZIP_FILE_'.$value] = array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("CREATE_ZIP_FILE", array("#FIELD_NAME#" => $arProperty_M[$value])),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N"
			);
		}
	}
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

	$arComponentParameters['PARAMETERS']['ADD_SUBSCRIPTION_USER'] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("ADD_SUBSCRIPTION_USER"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y",
	);
	if($arCurrentValues["ADD_SUBSCRIPTION_USER"] == "Y")
	{
    	$arComponentParameters['PARAMETERS']['SUBSCRIPTION_EMAIL_USER'] = array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SUBSCRIPTION_EMAIL_USER"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"VALUES" => $arProperty,
			"ADDITIONAL_VALUES" => "Y",
		);
	}

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

	$arComponentParameters['PARAMETERS']["USE_BITRIX24_LID"] = array(
		"PARENT" => "BITRIX24",
		"NAME" => GetMessage("USE_BITRIX24_LID"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y", 
	);
	if ($arCurrentValues["USE_BITRIX24_LID"] == "Y")
	{
		$arComponentParameters['PARAMETERS']['BITRIX24_URL'] = array(
			"PARENT" => "BITRIX24",
			"NAME" => GetMessage("BITRIX24_URL"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
		$arComponentParameters['PARAMETERS']['BITRIX24_LOGIN'] = array(
			"PARENT" => "BITRIX24",
			"NAME" => GetMessage("BITRIX24_LOGIN"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
		$arComponentParameters['PARAMETERS']['BITRIX24_PASSWORD'] = array(
			"PARENT" => "BITRIX24",
			"NAME" => GetMessage("BITRIX24_PASSWORD"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
		$arComponentParameters['PARAMETERS']['BITRIX24_LID_TITLE'] = array(
			"PARENT" => "BITRIX24",
			"NAME" => GetMessage("BITRIX24_LID_TITLE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);

		$arValidBitrix24 = array(
			'' => '',
			'COMPANY_TITLE' => GetMessage('BITRIX24_COMPANY_TITLE'),
			'NAME' => GetMessage('BITRIX24_NAME'),
			'LAST_NAME' => GetMessage('BITRIX24_LAST_NAME'),
			'SECOND_NAME' => GetMessage('BITRIX24_SECOND_NAME'),
			'POST' => GetMessage('BITRIX24_POST'),
			'ADDRESS' => GetMessage('BITRIX24_ADDRESS'),
			'COMMENTS' => GetMessage('BITRIX24_COMMENTS'),
			'SOURCE_DESCRIPTION' => GetMessage('BITRIX24_SOURCE_DESCRIPTION'),
			'STATUS_DESCRIPTION' => GetMessage('BITRIX24_STATUS_DESCRIPTION'),
			'OPPORTUNITY' => GetMessage('BITRIX24_OPPORTUNITY'),
			'PHONE_WORK' => GetMessage('BITRIX24_PHONE_WORK'),
			'PHONE_MOBILE' => GetMessage('BITRIX24_PHONE_MOBILE'),
			'PHONE_HOME' => GetMessage('BITRIX24_PHONE_HOME'),
			'PHONE_OTHER' => GetMessage('BITRIX24_PHONE_OTHER'),
			'WEB_WORK' => GetMessage('BITRIX24_WEB_WORK'),
			'EMAIL_WORK' => GetMessage('BITRIX24_EMAIL_WORK'),
			'EMAIL_HOME' => GetMessage('BITRIX24_EMAIL_HOME'),
			'EMAIL_OTHER' => GetMessage('BITRIX24_EMAIL_OTHER'),
		);

		foreach ($arProperty as $key => $title)
		{
			$arComponentParameters["PARAMETERS"]["BITRIX24_LID_".$key] = array(
				"PARENT" => "BITRIX24",
				"NAME" => $title,
				"TYPE" => "LIST",
				"VALUES" => $arValidBitrix24,
				"ADDITIONAL_VALUES" => "N",
			);
		}
	}


	$arComponentParameters['PARAMETERS']["USE_PERSONAL_DATA"] = array(
		"PARENT" => "PERSONAL",
		"NAME" => GetMessage("USE_PERSONAL_DATA"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y",
	);
	if ($arCurrentValues["USE_PERSONAL_DATA"] == "Y")
	{
		$arComponentParameters['PARAMETERS']['SITE_URL'] = array(
			"PARENT" => "PERSONAL",
			"NAME" => GetMessage("SITE_URL"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
		$arComponentParameters['PARAMETERS']['COMPANY_NAME'] = array(
			"PARENT" => "PERSONAL",
			"NAME" => GetMessage("COMPANY_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
		$arComponentParameters['PARAMETERS']['COMPANY_INN'] = array(
			"PARENT" => "PERSONAL",
			"NAME" => GetMessage("COMPANY_INN"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
		$arComponentParameters['PARAMETERS']['COMPANY_ADDRESS'] = array(
			"PARENT" => "PERSONAL",
			"NAME" => GetMessage("COMPANY_ADDRESS"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
	}

	$arComponentParameters['PARAMETERS']["USE_YM_GOALS"] = array(
		"PARENT" => "GOALS",
		"NAME" => GetMessage("USE_YM_GOALS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y",
	);
	if ($arCurrentValues["USE_YM_GOALS"] == "Y")
	{
		$arComponentParameters['PARAMETERS']['YM_GOALS_COUNTER'] = array(
			"PARENT" => "GOALS",
			"NAME" => GetMessage("YM_GOALS_COUNTER"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
		$arComponentParameters['PARAMETERS']['YM_GOALS_SEND_FORM'] = array(
			"PARENT" => "GOALS",
			"NAME" => GetMessage("YM_GOALS_SEND_FORM"), 
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
	}

	$arComponentParameters['PARAMETERS']["USE_GA_GOALS"] = array(
		"PARENT" => "GOALS",
		"NAME" => GetMessage("USE_GA_GOALS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y",
	);
	if ($arCurrentValues["USE_GA_GOALS"] == "Y")
	{
		$arComponentParameters['PARAMETERS']['GA_GOALS_GROUP'] = array(
			"PARENT" => "GOALS",
			"NAME" => GetMessage("GA_GOALS_GROUP"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
		$arComponentParameters['PARAMETERS']['GA_GOALS_SEND_FORM'] = array(
			"PARENT" => "GOALS",
			"NAME" => GetMessage("GA_GOALS_SEND_FORM"), 
			"TYPE" => "STRING",
			"DEFAULT" => "",
		);
	}

	$arComponentParameters['PARAMETERS']["USE_SERVICE_USER_FIELDS"] = array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("USE_SERVICE_USER_FIELDS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y",
	);

	if ($arCurrentValues["USE_SERVICE_USER_FIELDS"] == "Y")
	{
		$arComponentParameters['PARAMETERS']['SERVICE_USER_FIELDS_PROPERTY'] = array(
			'PARENT' => 'BASE',
			'NAME' => GetMessage('SERVICE_USER_FIELDS_PROPERTY'),
			'TYPE' => 'LIST',
			"MULTIPLE" => "N",
			"VALUES" => $arProperty,
		);
		$arComponentParameters['PARAMETERS']["USE_SERVICE_USER_PRODUCTS"] = array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("USE_SERVICE_USER_PRODUCTS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		);
		$arComponentParameters['PARAMETERS']["EMAIL_SERVICE_USER_PRODUCTS"] = array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("EMAIL_SERVICE_USER_PRODUCTS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		);
	}

?>