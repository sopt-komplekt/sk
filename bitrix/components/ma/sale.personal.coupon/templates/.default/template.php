<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="b-personal-coupon">
	<div class="b-personal-coupon_card"></div>
	<div class="b-personal-coupon_info">
		Ваша скидка <span>2%</span>
	</div>
	<div class="b-personal-coupon_code">
		<? if($arResult[0]['COUPON']): ?>
			<?=$arResult[0]['COUPON']?>
		<? else: ?>
			XX-XXXXX-XXXXXXX
		<? endif; ?>
	</div>
</div>

<? //dump($arResult); ?>