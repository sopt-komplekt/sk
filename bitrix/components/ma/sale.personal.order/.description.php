<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MA_SPO_NAME"),
	"DESCRIPTION" => GetMessage("MA_SPO_DESCRIPTION"),
	"COMPLEX" => "Y",
	"SORT" => 20,
	"ICON" => "/images/icon.gif",
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "sale_personal",
			"NAME" => GetMessage("MA_SALE_PERSONAL")
		)
	),
);
?>