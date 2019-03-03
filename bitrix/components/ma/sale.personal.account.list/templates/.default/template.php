<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="b-transactions">
	<table cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<td>№</td>
				<td>Дата транзакции</td>
				<td>Сумма</td>
				<td>Действие</td>
				<td>Заказ</td>
			</tr>
		</thead>
		<tbody>
			<? foreach ($arResult['TRANSACTIONS'] as $key => $arTransaction): ?>
				<tr class="<?=$arTransaction['DEBIT'] == 'Y' ? 'b-transactions-debit' : 'b-transactions-credit'?>">
					<td><?=$key+1?></td>
					<td><?=$arTransaction['TRANSACT_DATE']?></td>
					<?php if ($arTransaction['DEBIT'] == 'Y'): ?>
					<td>
						+<?=SaleFormatCurrency($arTransaction['AMOUNT'], $arTransaction['CURRENCY'])?> <br>
						(на счет)
					</td>
					<?php else: ?>
					<td>
						-<?=SaleFormatCurrency($arTransaction['AMOUNT'], $arTransaction['CURRENCY'])?> <br>
						(со счета)
					</td>
					<?php endif ?>
					<td><?=GetMessage($arTransaction['DESCRIPTION'])?></td>
					<td>
						<?php if ($arTransaction['ORDER_ID'] > 0): ?>
							<a href="/personal/order/detail/<?=$arTransaction['ORDER_ID']?>/">Заказ №<?=$arTransaction['ORDER_ID']?></a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		<tbody>
	</table>
</div>
<? //dump($arResult); ?>