<? 
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); 
	$this->setFrameMode(true);
?>

<? if (!empty($arResult)): ?>
	
	<ul>

	<?
	$previousLevel = 0;
	foreach($arResult as $arItem):?>

		<? if($arItem['DEPTH_LEVEL'] <= $arParams['MAX_LEVEL']): ?>
			
			<? if($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel && $arItem['DEPTH_LEVEL']+1 <= $arParams['MAX_LEVEL']): ?>
				<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
			<? elseif($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel): ?>
				<?=str_repeat("</li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
			<? endif; ?>
		
			<? if($arItem["IS_PARENT"]): ?>
		
				<? if($arItem["DEPTH_LEVEL"] == 1): ?>
					<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a>
						<? if($arItem['DEPTH_LEVEL']+1 <= $arParams['MAX_LEVEL']): ?><ul class="root-item"><? else: ?></li><? endif; ?>
				<? else: ?>
					<li><a href="<?=$arItem["LINK"]?>" class="parent<?if ($arItem["SELECTED"]):?> item-selected<?endif?>"><?=$arItem["TEXT"]?></a>
						<? if($arItem['DEPTH_LEVEL']+1 <= $arParams['MAX_LEVEL']): ?><ul><? else: ?></li><? endif; ?>
				<? endif; ?>
		
			<? else: ?>
		
				<? if($arItem["PERMISSION"] > "D"): ?>
		
					<? if($arItem["DEPTH_LEVEL"] == 1): ?>
						<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-selected<?else:?>root-item<?endif?>"><?=$arItem["TEXT"]?></a></li>
					<? else: ?>
						<li><a href="<?=$arItem["LINK"]?>" <?if ($arItem["SELECTED"]):?> class="item-selected"<?endif?>><?=$arItem["TEXT"]?></a></li>
					<? endif; ?>
		
				<? else: ?>
		
					<? if($arItem["DEPTH_LEVEL"] == 1): ?>
						<li><a href="" class="<?if ($arItem["SELECTED"]):?>root-selected<?else:?>root-item<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
					<? else: ?>
						<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
					<? endif; ?>
		
				<? endif; ?>
		
			<? endif; ?>

			<? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

		<? endif; ?>

	<? endforeach ?>

	<? if ($previousLevel > 1): //close last item tags?>
		<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
	<? endif; ?>

	</ul>

<? endif; ?>