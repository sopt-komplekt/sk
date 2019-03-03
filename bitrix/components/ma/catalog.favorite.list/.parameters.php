<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"FAVORITE_URL" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CFL_PATH_TO_FAVORITE"),
			"TYPE" => "STRING",
			"DEFAULT" => "/catalog/favorite/",
		),
		"SHOW_NUM_PRODUCTS" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CFL_SHOW_NUM_PRODUCTS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"SHOW_EMPTY_VALUES" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CFL_SHOW_EMPTY_VALUES"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
	),
);