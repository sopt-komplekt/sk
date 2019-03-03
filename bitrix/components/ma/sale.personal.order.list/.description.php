<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MA_SALE_PERSONAL_ORDER_LIST_NAME"),
	"DESCRIPTION" => GetMessage("MA_SALE_PERSONAL_ORDER_LIST_DESCRIPTION"),
	"ICON" => "/images/sale_order_tbl.gif",
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "sale_personal",
			"NAME" => GetMessage("SPOL_NAME")
		)
	),
);
?>