<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MA_CATALOG_COMPARE_LIST_NAME"),
	"DESCRIPTION" => GetMessage("MA_CATALOG_COMPARE_LIST_DESCRIPTION"),
	"ICON" => "/images/iblock_compare_list.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 50,
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "ma_catalog",
			"NAME" => GetMessage("MA_CATALOG"),
			"SORT" => 30,
		),
	),
);

?>