<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>

<div class="l-wrapper">

	<div class="b-page-title">
		<? include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/breadcrumb.php"); ?>
		<h1><? $APPLICATION->ShowTitle(false) ?></h1>
	</div>

	<? if ($arParams['SHOW_SECTION_LIST'] == "Y"): ?>
		<?$APPLICATION->IncludeComponent(
			"ma:catalog.section.list",
			$arParams['SECTION_LIST_TEMPLATE'],
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"VARIABLES" => $arResult['VARIABLES'],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"DISPLAY_IMG_WIDTH"	 =>	$arParams["SECTION_LIST_IMG_WIDTH"],
				"DISPLAY_IMG_HEIGHT" =>	$arParams["SECTION_LIST_IMG_HEIGHT"],
				"RESIZE_IMAGE" => $arParams["SECTION_LIST_RESIZE_IMAGE"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"SEF_FOLDER" => $arParams['SEF_FOLDER'],
				"SEF_MODE" => $arParams['SEF_MODE'],
				// "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
				"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				// "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
				"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
				// "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
				"ADD_SECTIONS_CHAIN" => 'N', //(isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
				"HIDDEN_SECTION_LIST_WITHOUT_SUBSECTIONS" => $arParams["HIDDEN_SECTION_LIST_WITHOUT_SUBSECTIONS"],
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?>
	<? endif; ?>

</div>