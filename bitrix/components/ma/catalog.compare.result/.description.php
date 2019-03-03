<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("IBLOCK_COMPARE_TABLE_TEMPLATE_NAME"),
	"DESCRIPTION" => GetMessage("IBLOCK_COMPARE_TABLE_TEMPLATE_DESCRIPTION"),
	"ICON" => "/images/iblock_compare_tbl.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 60,
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "ma_catalog",
			"NAME" => GetMessage("T_IBLOCK_DESC_CATALOG"),
			"SORT" => 30,
		),
	),
);

?>