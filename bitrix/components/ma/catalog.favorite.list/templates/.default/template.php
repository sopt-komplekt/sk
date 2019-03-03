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
<div class="b-small-favorite">
	<a class="b-small-favorite__link" href="<? echo $arParams['FAVORITE_URL']?>">
		<? echo GetMessage('CFL_FAVORITE_TITLE'); ?>
		<? if ($arParams['SHOW_NUM_PRODUCTS'] == "Y" && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == "Y")): ?>
			<span class="b-small-favorite__count" id="js-favorite-count">
				(<? echo count($arResult['ITEMS']); ?>)
			</span>
		<? endif; ?>

	</a>
</div>