<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("IBLOCK_ELEMENT_TEMPLATE_NAME"),
	"DESCRIPTION" => GetMessage("IBLOCK_ELEMENT_TEMPLATE_DESCRIPTION"),
	"ICON" => "/images/cat_detail.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 40,
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "ma_catalog",
			"NAME" => GetMessage("T_IBLOCK_DESC_CATALOG"),
			"SORT" => 30,
			"CHILD" => array(
				"ID" => "ma_catalog_cmpx",
			),
		),
	),
);

?>