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
//$arProperty_N = array();
$arProperty_X = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr = $rsProp->Fetch())
{
	$arProperty[$arr["ID"]] = $arr["NAME"];
	if(($arr["PROPERTY_TYPE"] == 'S' || $arr['PROPERTY_TYPE'] == 'N') && $arr['USER_TYPE'] == ''){
		$arProperty_LS[$arr["ID"]] = $arr["NAME"];
	}
	elseif($arr["PROPERTY_TYPE"] == "L"){
		$arProperty_X[$arr["ID"]] = $arr["NAME"];
	}
}

	$arComponentParameters = array(
		"GROUPS" => array(
			"DISPLAY" => array(
				"NAME" => GetMessage("DISPLAY"),
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
			"SECTION_ID" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("SECTION_ID"),
				"TYPE" => "STRING",
			),
			"ELEMENT_SORT_FIELD" => array(
				"PARENT" => "DATA_SOURCE",
				"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD"),
				"TYPE" => "LIST",
				"VALUES" => array(
					"shows" => GetMessage("IBLOCK_SORT_SHOWS"),
					"sort" => GetMessage("IBLOCK_SORT_SORT"),
					"timestamp_x" => GetMessage("IBLOCK_SORT_TIMESTAMP"),
					"name" => GetMessage("IBLOCK_SORT_NAME"),
					"id" => GetMessage("IBLOCK_SORT_ID"),
					"active_from" => GetMessage("IBLOCK_SORT_ACTIVE_FROM"),
					"active_to" => GetMessage("IBLOCK_SORT_ACTIVE_TO"),
					"rand" => GetMessage("IBLOCK_SORT_RAND"),
				),
				"ADDITIONAL_VALUES" => "Y",
				"DEFAULT" => "sort",
			),
			"ELEMENT_SORT_ORDER" => array(
				"PARENT" => "DATA_SOURCE",
				"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER"),
				"TYPE" => "LIST",
				"VALUES" => array(
					"asc" => GetMessage("IBLOCK_SORT_ASC"),
					"desc" => GetMessage("IBLOCK_SORT_DESC"),
				),
				"DEFAULT" => "asc",
				"ADDITIONAL_VALUES" => "Y",
			),
			"ELEMENT_FLAG_LIMIT" => array(
				"PARENT" => "DATA_SOURCE",
				"NAME" => GetMessage("ELEMENT_FLAG_LIMIT"),
				"TYPE" => "LIST",
				"ADDITIONAL_VALUES" => "Y",
				"VALUES" => $arProperty_X,
			),
			"ELEMENT_COUNT" => array(
				"PARENT" => "DATA_SOURCE",
				"NAME" => GetMessage("ELEMENT_COUNT"),
				"TYPE" => "STRING",
				"DEFAULT" => "10",
			),
			"USE_JQUERY" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("USE_JQUERY"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
			),
			"USE_CAROUSEL_SCRIPT" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("USE_CAROUSEL_SCRIPT"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
			),
			"USE_PHOTOGALLERY" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("USE_PHOTOGALLERY"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"USE_FANCYBOX" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("USE_FANCYBOX"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),

			"ELEMENT_VISIBLE_COUNT" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("ELEMENT_VISIBLE_COUNT"),
				"TYPE" => "STRING",
				"DEFAULT" => "1",
			),
			"SCROLL_SPEED" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("SCROLL_SPEED"),
				"TYPE" => "STRING",
				"DEFAULT" => "500",
			),
			"AUTO_SPEED" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("AUTO_SPEED"),
				"TYPE" => "STRING",
			),
			"AUTO_SPEED_HOVER_PAUSE" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("AUTO_SPEED_HOVER_PAUSE"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"NOT_CYCLIC" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("NOT_CYCLIC"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"SHOW_SWITCH_LR" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("SHOW_SWITCH_LR"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
			),
			"SHOW_SWITCH_EL" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("SHOW_SWITCH_EL"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"CAROUSEL_DISPOSITION" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("CAROUSEL_DISPOSITION"),
				"TYPE" => "LIST",
				"VALUES" => array(
					"hor" => GetMessage("CAROUSEL_DISPOSITION_HOR"),
					"ver" => GetMessage("CAROUSEL_DISPOSITION_VER"),
				),
				"DEFAULT" => "hor",
				"ADDITIONAL_VALUES" => "N",
			),
			"ELEMENT_WIDTH" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("ELEMENT_WIDTH"),
				"TYPE" => "STRING",
				"DEFAULT" => "",
			),
			"ELEMENT_HEIGHT" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("ELEMENT_HEIGHT"),
				"TYPE" => "STRING",
				"DEFAULT" => "",
			),
			"IMG_WIDTH" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("IMG_WIDTH"),
				"TYPE" => "STRING",
				"DEFAULT" => "",
			),
			"IMG_HEIGHT" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("IMG_HEIGHT"),
				"TYPE" => "STRING",
				"DEFAULT" => "100",
			),
			"RESIZE_IMAGE" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("RESIZE_IMAGE"),
				"TYPE" => "LIST",
				"VALUES" => array(
					"1" => GetMessage("BX_RESIZE_IMAGE_EXACT"),
					"2" => GetMessage("BX_RESIZE_IMAGE_PROPORTIONAL"),
					"3" => GetMessage("BX_RESIZE_IMAGE_PROPORTIONAL_ALT"),
				),
				"DEFAULT" => "BX_RESIZE_IMAGE_EXACT",
				"ADDITIONAL_VALUES" => "N",
			),
		),
	);


?>