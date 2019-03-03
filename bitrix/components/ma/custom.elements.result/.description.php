<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_NAME"),
	"DESCRIPTION" => GetMessage("MA_CUSTOM_ELEMENT_RESULT_DESCREPTION"),
	"ICON" => "/images/form.png",
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "sale_personal",
			"NAME" => GetMessage("MA_SALE_PERSONAL"),
		),
	),
);

?>