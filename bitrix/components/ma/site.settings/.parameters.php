<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;


// $arIBlockType = CIBlockParameters::GetIBlockTypes();

// $rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
// while($arr=$rsIBlock->Fetch())
// 	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];

// $arProperty_LNS = array();
// $arProperty_N = array();
// $arProperty_X = array();
// $rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
// while ($arr=$rsProp->Fetch())
// {
// 	if($arr["PROPERTY_TYPE"] != "F")
// 		$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];

// 	if($arr["PROPERTY_TYPE"]=="N")
// 		$arProperty_N[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];

// 	if($arr["PROPERTY_TYPE"]!="F")
// 	{
// 		if($arr["MULTIPLE"] == "Y")
// 			$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
// 		elseif($arr["PROPERTY_TYPE"] == "L")
// 			$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
// 		elseif($arr["PROPERTY_TYPE"] == "E" && $arr["LINK_IBLOCK_ID"] > 0)
// 			$arProperty_X[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
// 	}
// }

// $arProperty_UF = array();
// $arSProperty_LNS = array();
// $arUserFields = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("IBLOCK_".$arCurrentValues["IBLOCK_ID"]."_SECTION");
// foreach($arUserFields as $FIELD_NAME=>$arUserField)
// {
// 	$arProperty_UF[$FIELD_NAME] = $arUserField["LIST_COLUMN_LABEL"]? $arUserField["LIST_COLUMN_LABEL"]: $FIELD_NAME;
// 	if($arUserField["USER_TYPE"]["BASE_TYPE"]=="string")
// 		$arSProperty_LNS[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
// }

// $arOffers = CIBlockPriceTools::GetOffersIBlock($arCurrentValues["IBLOCK_ID"]);
// $OFFERS_IBLOCK_ID = is_array($arOffers)? $arOffers["OFFERS_IBLOCK_ID"]: 0;
// $arProperty_Offers = array();
// if($OFFERS_IBLOCK_ID)
// {
// 	$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$OFFERS_IBLOCK_ID));
// 	while($arr=$rsProp->Fetch())
// 	{
// 		if($arr["PROPERTY_TYPE"] != "F")
// 			$arProperty_Offers[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
// 	}
// }

// $arPrice = array();
// if(CModule::IncludeModule("catalog"))
// {
// 	$rsPrice=CCatalogGroup::GetList($v1="sort", $v2="asc");
// 	while($arr=$rsPrice->Fetch()) $arPrice[$arr["NAME"]] = "[".$arr["NAME"]."] ".$arr["NAME_LANG"];
// }
// else
// {
// 	$arPrice = $arProperty_N;
// }

// $arAscDesc = array(
// 	"asc" => GetMessage("IBLOCK_SORT_ASC"),
// 	"desc" => GetMessage("IBLOCK_SORT_DESC"),
// );

$arjQueryVersion = array(
    '1.8' => GetMessage("JQUERY_1.8"),
    '2.1' => GetMessage("JQUERY_2.1"),
);
$arFancyboxVersion = array(
    '2.1' => GetMessage("FANCYBOX_2.1"),
    '3.1' => GetMessage("FANCYBOX_3.1"),
);

$arComponentParameters = array(
	"GROUPS" => array(
		"SCRIPTS" => array(
			"NAME" => GetMessage("SECTION_NAME_SCRIPTS"),
		),
		"CSS" => array(
			"NAME" => GetMessage("SECTION_NAME_CSS"),
		),
        "UP_BUTTON" => array(
			"NAME" => GetMessage("SECTION_UP_BUTTON"),
		),
        "MODALS" => array(
            "NAME" => GetMessage("SECTION_NAME_MODALS")
        )
        
	),
	"PARAMETERS" => array(
		"USE_JQUERY" => Array(
			"PARENT" => "SCRIPTS",
			"NAME" => GetMessage("USE_JQUERY"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
        "JQUERY_VERSION" => array(
    		"PARENT" => "SCRIPTS",
    		"NAME" => GetMessage("JQUERY_VERSION"),
    		"TYPE" => "LIST",
    		"DEFAULT" => "1.8",
    		"REFRESH" => "N",
            "VALUES" => array_merge($arjQueryVersion)
        ),
        "USE_MA_PLAGINS" => Array(
			"PARENT" => "SCRIPTS",
			"NAME" => GetMessage("USE_MA_PLAGINS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "N",
		),
        "USE_FANCYBOX" => Array(
			"PARENT" => "SCRIPTS",
			"NAME" => GetMessage("USE_FANCYBOX"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		"FANCYBOX_VERSION" => array(
    		"PARENT" => "SCRIPTS",
    		"NAME" => GetMessage("FANCYBOX_VERSION"),
    		"TYPE" => "LIST",
    		"DEFAULT" => "2.1",
    		"REFRESH" => "N",
            "VALUES" => array_merge($arFancyboxVersion)
        ),
		"USE_MASKEDINPUT" => Array(
			"PARENT" => "SCRIPTS",
			"NAME" => GetMessage("USE_MASKEDINPUT"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "N",
		),
		"USE_POSHYTIP" => Array(
			"PARENT" => "SCRIPTS",
			"NAME" => GetMessage("USE_POSHYTIP"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "N",
		),
		"USE_BOOTSTRAP" => Array(
			"PARENT" => "CSS",
			"NAME" => GetMessage("USE_BOOTSTRAP"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		"BOOTSTRAP_VERSION" => array(
    		"PARENT" => "CSS",
    		"NAME" => GetMessage("BOOTSTRAP_VERSION"),
    		"TYPE" => "LIST",
    		"DEFAULT" => "",
    		"REFRESH" => "N",
            "VALUES" => array(
			    'b3_all' => GetMessage("BOOTSTRAP_3_ALL"),
			    'b3_com' => GetMessage("BOOTSTRAP_3_COM"),
			    'b3_grid' => GetMessage("BOOTSTRAP_3_GRID"),
			    'b3_bx' => GetMessage("BOOTSTRAP_3_BITRIX"),
			),
        ),

		"USE_POPUP_SCRIPTS" => Array(
			"PARENT" => "MODALS",
			"NAME" => GetMessage("USE_POPUP_SCRIPTS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
        "USE_TOP_SCROLL" => Array(
			"PARENT" => "UP_BUTTON",
			"NAME" => GetMessage("USE_TOP_SCROLL"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		// "USE_BASKET_SCRIPT" => Array(
		// 	"PARENT" => "SCRIPTS",
		// 	"NAME" => GetMessage("USE_BASKET_SCRIPT"),
		// 	"TYPE" => "CHECKBOX",
		// 	"DEFAULT" => "N",
		// 	"REFRESH" => "N",
		// ),
	),
);

$arScriptsList = array(
    
    'AM' => GetMessage("AM_SCRIPT"),
    'FB' => GetMessage("FB_SCRIPT")

);

if($arCurrentValues['USE_POPUP_SCRIPTS'] == 'Y'){
    
    $arComponentParameters['PARAMETERS']['MODAL_SCRIPTS_LIST'] = array(
    
        "PARENT" => "MODALS",
		"NAME" => GetMessage("USE_OPTION_PLAGIN"),
		"TYPE" => "LIST",
		"DEFAULT" => "-",
		"REFRESH" => "Y",
        "VALUES" => array_merge($arScriptsList)
    );
    
    $arComponentParameters['PARAMETERS']['MODAL_CLASS'] = array(
    
        "PARENT" => "MODALS",
		"NAME" => GetMessage("USE_MODAL_CLASS"),
		"TYPE" => "STRING",
		"DEFAULT" => "g-ajax-data",
		"REFRESH" => "N"
    );
    
    //if($arCurrentValues['MODAL_SCRIPTS_LIST'] == 'AM'){
    
        $arComponentParameters['PARAMETERS']['MODAL_FORM'] = array(
            "PARENT" => "MODALS",
    		"NAME" => GetMessage("USE_MODAL_FORM"),
    		"TYPE" => "CHECKBOX",
    		"DEFAULT" => "N",
    		"REFRESH" => "N",
        );

    //}

    if($arCurrentValues['MODAL_SCRIPTS_LIST'] == 'AM'){
    
	    $arComponentParameters['PARAMETERS']['MODAL_FORM_DESKTOP'] = array(
	        "PARENT" => "MODALS",
			"NAME" => GetMessage("DONT_USE_MODAL_FORM_ON_MOBILE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "N",
	    );

    }
    
    
}

if($arCurrentValues['USE_TOP_SCROLL'] == 'Y'){
    
    $arComponentParameters['PARAMETERS']['USE_TOP_ALWAYS'] = array(
    
        "PARENT" => "UP_BUTTON",
		"NAME" => GetMessage("USE_TOP_ALWAYS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
		"REFRESH" => "Y",
    );
    
    if($arCurrentValues['USE_TOP_ALWAYS'] != 'Y'){
    
        $arComponentParameters['PARAMETERS']['USE_TOP_SCROLL_HEIGHT'] = array(
        
            "PARENT" => "UP_BUTTON",
    		"NAME" => GetMessage("USE_TOP_SCROLL_HEIGHT"),
    		"TYPE" => "STRING",
    		"DEFAULT" => "300",
    		"REFRESH" => "N",
        );
    
    }
    
}

if($arCurrentValues['USE_JQUERY'] != 'Y'){
    unset($arComponentParameters['PARAMETERS']['JQUERY_VERSION']);   
}
if($arCurrentValues['USE_FANCYBOX'] != 'Y'){
    unset($arComponentParameters['PARAMETERS']['FANCYBOX_VERSION']);   
}
if($arCurrentValues['USE_BOOTSTRAP'] != 'Y'){
    unset($arComponentParameters['PARAMETERS']['BOOTSTRAP_VERSION']);   
}



//CIBlockParameters::AddPagerSettings($arComponentParameters, GetMessage("T_IBLOCK_DESC_PAGER_CATALOG"), true, true);

/// Цены: если не установлен модуль магазина //////////////////////////////////////////////
// if(!IsModuleInstalled("sale"))
// {
// 	unset($arComponentParameters["GROUPS"]['PRICES']);
// }


?>