<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>
<div class="b-small-basket bx-hdr-profile">
	<a class="cart" href="<?=$arParams['PATH_TO_BASKET']?>">
		<span class="b-small-basket-quantity"><?=$arResult['NUM_PRODUCTS']?></span>
	</a>
</div>