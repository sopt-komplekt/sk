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
				"SORT" => "110",
			),
			"SCRIPT_PARAMETRS" => array (
				"NAME" => GetMessage("SCRIPT_PARAMETRS"),
				"SORT" => "120",
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
			"ELEMENT_VISIBLE_COUNT" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("ELEMENT_VISIBLE_COUNT"),
				"TYPE" => "STRING",
				"DEFAULT" => "1",
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
			"BLOCK_WIDTH" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("BLOCK_WIDTH"),
				"TYPE" => "STRING",
				"DEFAULT" => "",
			),
			"BLOCK_HEIGHT" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("BLOCK_HEIGHT"),
				"TYPE" => "STRING",
				"DEFAULT" => "",
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
			"RESIZE_IMAGE" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("RESIZE_IMAGE"),
				"TYPE" => "LIST",
				"VALUES" => array(
					"1" => GetMessage("BX_RESIZE_IMAGE_EXACT"),
					"2" => GetMessage("BX_RESIZE_IMAGE_PROPORTIONAL"),
					"3" => GetMessage("BX_RESIZE_IMAGE_PROPORTIONAL_ALT"),
				),
				"DEFAULT" => "BX_RESIZE_IMAGE_PROPORTIONAL",
				"ADDITIONAL_VALUES" => "N",
			),
			"START_ELEMENT" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("START_ELEMENT"),
				"TYPE" => "STRING",
				"DEFAULT" => "0",
			),
			"ELEMENT_SCROLL_COUNT" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("ELEMENT_SCROLL_COUNT"),
				"TYPE" => "STRING",
				"DEFAULT" => "1",
			),
			"SCROLL_SPEED" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("SCROLL_SPEED"),
				"TYPE" => "STRING",
				"DEFAULT" => "500",
			),
			"AUTO_SPEED" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("AUTO_SPEED"),
				"TYPE" => "STRING",
				"DEFAULT" => "5000",
			),
			"MOUSE_DRAG" => array (
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("MOUSE_DRAG"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
			),
			"TOUCH_DRAG" => array (
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("TOUCH_DRAG"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
			),
			"SHOW_SWITCH_LR" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("SHOW_SWITCH_LR"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
			),
			"TEXT_PREV" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("TEXT_PREV"),
				"TYPE" => "STRING",
				"DEFAULT" => "prev",
			),
			"TEXT_NEXT" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("TEXT_NEXT"),
				"TYPE" => "STRING",
				"DEFAULT" => "next",
			),
			"NAV_SPEED" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("NAV_SPEED"),
				"TYPE" => "STRING",
				"DEFAULT" => "500",
			),
			"SHOW_SWITCH_EL" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("SHOW_SWITCH_EL"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"SHOW_SWITCH_EL_EACH" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("SHOW_SWITCH_EL_EACH"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"DOTS_SPEED" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("DOTS_SPEED"),
				"TYPE" => "STRING",
				"DEFAULT" => "500",
			),
			"CYCLIC" => array (
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("CYCLIC"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
			),
			"AUTO_PLAY_HOVER_PAUSE" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("AUTO_PLAY_HOVER_PAUSE"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"MARGIN" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("MARGIN"),
				"TYPE" => "STRING",
				"DEFAULT" => "",
			),
			"MOUSE_WHEEL" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("MOUSE_WHEEL"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
			"RIGHT_TO_LEFT" => array(
				"PARENT" => "SCRIPT_PARAMETRS",
				"NAME" => GetMessage("RIGHT_TO_LEFT"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "N",
			),
		),
	);

?>