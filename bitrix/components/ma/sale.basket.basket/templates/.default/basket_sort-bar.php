<div class="b-basket_sort bx_sort_container">
	<span><?=GetMessage("SALE_ITEMS")?></span>
	<a href="javascript:void(0)" id="basket_toolbar_button" class="current" onclick="showBasketItemsList()"><?=GetMessage("SALE_BASKET_ITEMS")?><div id="normal_count" class="b-basket_sort_count" style="display:none">&nbsp;(<?=$normalCount?>)</div></a>
	<a href="javascript:void(0)" id="basket_toolbar_button_delayed" onclick="showBasketItemsList(2)" <?=$delayHidden?>><?=GetMessage("SALE_BASKET_ITEMS_DELAYED")?><div id="delay_count" class="b-basket_sort_count">&nbsp;(<?=$delayCount?>)</div></a>
	<a href="javascript:void(0)" id="basket_toolbar_button_subscribed" onclick="showBasketItemsList(3)" <?=$subscribeHidden?>><?=GetMessage("SALE_BASKET_ITEMS_SUBSCRIBED")?><div id="subscribe_count" class="b-basket_sort_count">&nbsp;(<?=$subscribeCount?>)</div></a>
	<a href="javascript:void(0)" id="basket_toolbar_button_not_available" onclick="showBasketItemsList(4)" <?=$naHidden?>><?=GetMessage("SALE_BASKET_ITEMS_NOT_AVAILABLE")?><div id="not_available_count" class="b-basket_sort_count">&nbsp;(<?=$naCount?>)</div></a>
</div>