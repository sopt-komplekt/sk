<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MA_SALE_PERSONAL_ORDER_DETAIL_NAME"),
	"DESCRIPTION" => GetMessage("MA_SALE_PERSONAL_ORDER_DETAIL_DESCRIPTION"),
	"ICON" => "/images/sale_order_detail.gif",
	"SORT" => 30,
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "sale_personal",
			"NAME" => GetMessage("SPOL_NAME")
		)
	),
);
?>