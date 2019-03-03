<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MA_CATALOG_SECTION_NAME"),
	"DESCRIPTION" => GetMessage("MA_CATALOG_SECTION_DESCRIPTION"),
	"ICON" => "/images/cat_list.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 30,
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "ma_catalog",
			"NAME" => GetMessage("MA_CATALOG"),
			"SORT" => 30,
			"CHILD" => array(
				"ID" => "ma_catalog_cmpx",
			),
		),
	),
);

?>