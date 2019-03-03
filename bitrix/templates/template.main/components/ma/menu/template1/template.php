<? 
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); 
	$this->setFrameMode(true);
?>

<? if (!empty($arResult)): ?>

	<ul class="ul-deep-1">

	<?
		// подсчет общего количества пунктов верхнего меню
		foreach($arResult as $value)
		{
			if($value['DEPTH_LEVEL'] == 1)
				$lastIndexTopDeep = $value['ITEM_INDEX'];
		}

		$previousLevel = 0;
		foreach($arResult as $key => $arItem):

		// уникальное имя для каждого пункта меню
		$clname = substr($arItem['LINK'], 1, -1);
		$clname = str_replace('/', '-', $clname);
		$li_clname = 'li-item-'.$clname;
		$a_clname  = 'a-item-'.$clname;

		// указатель первого и последнего элемента
		if($arItem['ITEM_INDEX'] === 0){
			$li_clname.= ' li-deep-'.$arItem['DEPTH_LEVEL'].'-first';
			$a_clname.=  ' a-deep-'.$arItem['DEPTH_LEVEL'].'-first';
		}
		elseif( ($arItem['DEPTH_LEVEL'] == 1 && $arItem['ITEM_INDEX'] == $lastIndexTopDeep) || ($arItem['DEPTH_LEVEL'] > 1 && $arItem['DEPTH_LEVEL'] != $arResult[$key+1]['DEPTH_LEVEL']) ) {
			$li_clname.= ' li-deep-'.$arItem['DEPTH_LEVEL'].'-last';
			$a_clname.=  ' a-deep-'.$arItem['DEPTH_LEVEL'].'-last';
		}

	?>

		<? if($arItem['DEPTH_LEVEL'] <= $arParams['MAX_LEVEL']): ?>
			
			<? if($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel && $arItem['DEPTH_LEVEL']+1 <= $arParams['MAX_LEVEL']): ?>
				<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
			<? elseif($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel): ?>
				<?=str_repeat("</li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
			<? endif; ?>
		
			<? if($arItem["IS_PARENT"]): ?>
		
				<? if($arItem["DEPTH_LEVEL"] == 1): ?>
					<li class="li-deep-<?=$arItem["DEPTH_LEVEL"]?> <?=$li_clname?><?if($arItem["SELECTED"]):?> root-active<?endif?>">
						<a href="<?=$arItem["LINK"]?>" class="a-deep-<?=$arItem["DEPTH_LEVEL"]?><?if($arItem["SELECTED"]):?> root-active<?endif?> <?=$a_clname?>"><?=$arItem["TEXT"]?><span class="ico"></span></a>
						<? if($arItem['DEPTH_LEVEL']+1 <= $arParams['MAX_LEVEL']): ?><ul class="ul-deep-<?=$arItem["DEPTH_LEVEL"]+1?>"><? else: ?></li><? endif; ?>
				<? else: ?>
					<li class="li-deep-<?=$arItem["DEPTH_LEVEL"]?> <?=$li_clname?><?if($arItem["SELECTED"]):?> active<?endif?>">
						<a href="<?=$arItem["LINK"]?>" class="a-deep-<?=$arItem["DEPTH_LEVEL"]?><?if($arItem["SELECTED"]):?> active<?endif?> <?=$a_clname?>"><?=$arItem["TEXT"]?><span class="ico"></span></a>
						<? if($arItem['DEPTH_LEVEL']+1 <= $arParams['MAX_LEVEL']): ?><ul class="ul-deep-<?=$arItem["DEPTH_LEVEL"]+1?>"><? else: ?></li><? endif; ?>
				<? endif; ?>
		
			<? else: ?>
		
				<? if($arItem["PERMISSION"] > "D"): ?>
		
					<? if($arItem["DEPTH_LEVEL"] == 1): ?>
						<li class="li-deep-<?=$arItem["DEPTH_LEVEL"]?> <?=$li_clname?><?if($arItem["SELECTED"]):?> root-active<?endif?>">
							<a href="<?=$arItem["LINK"]?>" class="a-deep-<?=$arItem["DEPTH_LEVEL"]?><?if($arItem["SELECTED"]):?> root-active<?endif?> <?=$a_clname?>"><?=$arItem["TEXT"]?><span class="ico"></span></a>
						</li>
					<? else: ?>
						<li class="li-deep-<?=$arItem["DEPTH_LEVEL"]?> <?=$li_clname?><?if($arItem["SELECTED"]):?> active<?endif?>">
							<a href="<?=$arItem["LINK"]?>" class="a-deep-<?=$arItem["DEPTH_LEVEL"]?><?if($arItem["SELECTED"]):?> active<?endif?> <?=$a_clname?>"><?=$arItem["TEXT"]?><span class="ico"></span></a>
						</li>
					<? endif; ?>
		
				<? else: ?>
		
					<? if($arItem["DEPTH_LEVEL"] == 1): ?>
						<li class="li-deep-<?=$arItem["DEPTH_LEVEL"]?> <?=$li_clname?><?if($arItem["SELECTED"]):?> root-active<?endif?>">
							<a href="" class="a-deep-<?=$arItem["DEPTH_LEVEL"]?><?if($arItem["SELECTED"]):?> root-active<?endif?> <?=$a_clname?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?><span class="ico"></span></a>
						</li>
					<? else: ?>
						<li class="li-deep-<?=$arItem["DEPTH_LEVEL"]?> <?=$li_clname?><?if($arItem["SELECTED"]):?> active<?endif?>">
							<a href="" class="a-deep-<?=$arItem["DEPTH_LEVEL"]?> denied<?if($arItem["SELECTED"]):?> active<?endif?> <?=$a_clname?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?><span class="ico"></span></a>
						</li>
					<? endif; ?>
		
				<? endif; ?>
		
			<? endif; ?>

			<? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

		<? endif; ?>

	<? endforeach ?>

	<? if ($previousLevel > 1): //close last item tags ?>
		<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
	<? endif; ?>

	</ul>

<? endif; ?>