<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>
<div class="b-small-basket bx-hdr-profile">
	<a href="<?=$arParams['PATH_TO_BASKET']?>"><?=GetMessage('TSB1_CART')?></a>
	<?php if (!$compositeStub): ?>
		<?php if ($arParams['SHOW_NUM_PRODUCTS'] == "Y" && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == "Y")): ?>
			<div class="b-small-basket_num">
				<?=$arResult['NUM_PRODUCTS']?> <?=$arResult['PRODUCT(S)'] ?>
			</div>
		<?php endif ?>
		<?php if ($arParams['SHOW_TOTAL_PRICE'] == "Y"): ?>
			<div class="b-small-basket_total">
				<span class="b-small-basket_total-label">
					<?=GetMessage('TSB1_TOTAL_PRICE') ?>
				</span>
				<?php if ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == "Y"): ?>
					<span class="b-small-basket_total-val">
						<?=$arResult['TOTAL_PRICE'];?>
					</span>
				<?php endif ?>
			</div>
		<?php endif ?>
	<?php endif ?>
</div>