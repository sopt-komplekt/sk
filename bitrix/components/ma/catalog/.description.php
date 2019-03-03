<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MA_CATALOG_NAME"),
	"DESCRIPTION" => GetMessage("MA_CATALOG_DESCRIPTION"),
	"ICON" => "/images/catalog.gif",
	"COMPLEX" => "Y",
	"SORT" => 10,
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "ma_catalog",
			"NAME" => GetMessage("MA_CATALOG"),
			"SORT" => 10,
			"CHILD" => array(
				"ID" => "ma_catalog_cmpx",
			),
		),
	),
);

?>