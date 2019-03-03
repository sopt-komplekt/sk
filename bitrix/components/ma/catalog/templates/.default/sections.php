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
// $this->addExternalCss("/bitrix/css/main/bootstrap.css");

// Описание инфоблока
// $rsIblockId = CIBlock::GetByID($arParams['IBLOCK_ID']);
// if ($arIblockId = $rsIblockId->GetNext()) {
// 	$arResult['IBLOCK']['CODE'] = $arIblockId['CODE'];
// 	$arResult['IBLOCK']['DESCRIPTION'] = $arIblockId['DESCRIPTION'];
// 	$arResult['IBLOCK']['NAME'] = $arIblockId['NAME'];
// }

include_once('section.php');

?>