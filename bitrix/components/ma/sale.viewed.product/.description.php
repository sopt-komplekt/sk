<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("VIEWED_NAME"),
	"DESCRIPTION" => GetMessage("VIEWED_DESCRIPTION"),
	"ICON" => "/images/sale_viewed.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 30,
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "ma_catalog",
			"NAME" => GetMessage("VIEWED_MAIN"),
			"SORT" => 30,
			"CHILD" => array(
				"ID" => "ma_catalog_cmpx",
			),
		),
	),
);

?>