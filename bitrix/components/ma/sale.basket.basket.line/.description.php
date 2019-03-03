<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("SBBS_DEFAULT_TEMPLATE_NAME"),
	"DESCRIPTION" => GetMessage("SBBS_DEFAULT_TEMPLATE_DESCRIPTION"),
	"ICON" => "/images/sale_basket.gif",
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "ma_catalog",
			"NAME" => GetMessage("SBBL_NAME"),
			"SORT" => 30,
			"CHILD" => array(
				"ID" => "ma_catalog_cmpx",
			),
		),
	),
);
?>