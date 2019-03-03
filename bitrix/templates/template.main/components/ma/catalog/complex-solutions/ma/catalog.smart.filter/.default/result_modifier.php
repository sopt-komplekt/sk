<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParams["FILTER_VIEW_MODE"] = (isset($arParams["FILTER_VIEW_MODE"]) && toUpper($arParams["FILTER_VIEW_MODE"]) == "HORIZONTAL") ? "HORIZONTAL" : "VERTICAL";
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "right";

// Get Select Values

$arResult["SELECT_ITEMS"] = array();

foreach($arResult["ITEMS"] as $key => $arItem) {

	if(isset($arItem["PRICE"])) {
		if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
			continue;

		if ($arItem["VALUES"]["MIN"]["HTML_VALUE"]) {
			$selectItem = array();

			$selectItem["NAME"] = "Цена от"; //$arItem["NAME"];
			$selectItem["VALUES"] = number_format($arItem["VALUES"]["MIN"]["HTML_VALUE"], 2,  ",", " ");
			$arResult["SELECT_ITEMS"][] = $selectItem;
		}

		if ($arItem["VALUES"]["MAX"]["HTML_VALUE"]) {
			$selectItem = array();

			$selectItem["NAME"] = "Цена до"; $arItem["NAME"];
			$selectItem["VALUES"] = number_format($arItem["VALUES"]["MAX"]["HTML_VALUE"], 2,  ",", " ");
			$arResult["SELECT_ITEMS"][] = $selectItem;
		}
	}

	switch ($arItem["DISPLAY_TYPE"]) {
		case "A"://NUMBERS_WITH_SLIDER
			break;

		case "B"://NUMBERS
			break;

		case "G"://CHECKBOXES_WITH_PICTURES
			break;

		case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
			break;

		case "P"://DROPDOWN
			break;

		case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
			break;

		case "K"://RADIO_BUTTONS
			break;

		case "U"://CALENDAR
			break;

		default://CHECKBOXES
			$selectItem = array();

			foreach($arItem["VALUES"] as $val => $ar) {
				if ($ar["CHECKED"]) {
					$selectItem["NAME"] = $arItem["NAME"];
					$selectItem["VALUES"][$val] = $ar["VALUE"];
					$arResult["SELECT_ITEMS"][$key] = $selectItem;
				}
			}
	}

}
// dump($arResult["SELECT_ITEMS"]);
