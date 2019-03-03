<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("MA_NEWS_NAME"),
	"DESCRIPTION" => GetMessage("MA_NEWS_DESCRIPTION"),
	"ICON" => "/images/news_all.gif",
	"COMPLEX" => "Y",
	"SORT" => 10,
	"PATH" => array(
		"ID" => "Media Army",
		"CHILD" => array(
			"ID" => "ma_news",
			"NAME" => GetMessage("MA_NEWS"),
			"SORT" => 10,
			"CHILD" => array(
				"ID" => "ma_news_cmpx",
			),
		),
	),
);

?>