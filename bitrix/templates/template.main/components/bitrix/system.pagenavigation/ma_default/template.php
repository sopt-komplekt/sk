<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
?>
<div class="b-page-navigation">
	<?
		$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
		$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
	?>
	<span class="b-page-navigation_title"><?=GetMessage("pages")?></span>
	
	<?
	if($arResult["bDescPageNumbering"] === true):
		$bFirst = true;
		if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
			if($arResult["bSavePage"]):
	?>
				
		<a class="b-page-navigation_previous" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_prev")?></a>
	<?
			else:
				if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):
	?>
				<a class="b-page-navigation_previous" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_prev")?></a>
	<?
				else:
	?>
				<a class="b-page-navigation_previous" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_prev")?></a>
	<?
				endif;
			endif;
			
			if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
				$bFirst = false;
				if($arResult["bSavePage"]):
	?>
				<a class="b-page-navigation_first" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">1</a>
	<?
				else:
	?>
				<a class="b-page-navigation_first" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
	<?
				endif;
				if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
	/*?>
				<span class="b-page-navigation_dots">...</span>
	<?*/
	?>	
				<a class="b-page-navigation_dots" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=intVal($arResult["nStartPage"] + ($arResult["NavPageCount"] - $arResult["nStartPage"]) / 2)?>">...</a>
	<?
				endif;
			endif;
		endif;
		do
		{
			$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;
			
			if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
	?>
			<span class="<?=($bFirst ? "b-page-navigation_first " : "")?>b-page-navigation_current"><?=$NavRecordGroupPrint?></span>
	<?
			elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
	?>
			<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="<?=($bFirst ? "b-page-navigation_first" : "")?>"><?=$NavRecordGroupPrint?></a>
	<?
			else:
	?>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
				?> class="<?=($bFirst ? "b-page-navigation_first" : "")?>"><?=$NavRecordGroupPrint?></a>
	<?
			endif;
			
			$arResult["nStartPage"]--;
			$bFirst = false;
		} while($arResult["nStartPage"] >= $arResult["nEndPage"]);
		
		if ($arResult["NavPageNomer"] > 1):
			if ($arResult["nEndPage"] > 1):
				if ($arResult["nEndPage"] > 2):
	/*?>
			<span class="b-page-navigation_dots">...</span>
	<?*/
	?>
			<a class="b-page-navigation_dots" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] / 2)?>">...</a>
	<?
				endif;
	?>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=$arResult["NavPageCount"]?></a>
	<?
			endif;
		
	?>
			<a class="b-page-navigation_next"href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_next")?></a>
	<?
		endif; 

	else:
		$bFirst = true;

		if ($arResult["NavPageNomer"] > 1):
			if($arResult["bSavePage"]):
	?>
				<a class="b-page-navigation_previous" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_prev")?></a>
	<?
			else:
				if ($arResult["NavPageNomer"] > 2):
	?>
				<a class="b-page-navigation_previous" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_prev")?></a>
	<?
				else:
	?>
				<a class="b-page-navigation_previous" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_prev")?></a>
	<?
				endif;
			
			endif;
			
			if ($arResult["nStartPage"] > 1):
				$bFirst = false;
				if($arResult["bSavePage"]):
	?>
				<a class="b-page-navigation_first" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
	<?
				else:
	?>
				<a class="b-page-navigation_first" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
	<?
				endif;
				if ($arResult["nStartPage"] > 2):
	/*?>
				<span class="b-page-navigation_dots">...</span>
	<?*/
	?>
				<a class="b-page-navigation_dots" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nStartPage"] / 2)?>">...</a>
	<?
				endif;
			endif;
		endif;

		do
		{
			if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
	?>
			<span class="<?=($bFirst ? "b-page-navigation_first " : "")?>b-page-navigation_current"><?=$arResult["nStartPage"]?></span>
	<?
			elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
	?>
			<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="<?=($bFirst ? "b-page-navigation_first" : "")?>"><?=$arResult["nStartPage"]?></a>
	<?
			else:
	?>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
				?> class="<?=($bFirst ? "b-page-navigation_first" : "")?>"><?=$arResult["nStartPage"]?></a>
	<?
			endif;
			$arResult["nStartPage"]++;
			$bFirst = false;
		} while($arResult["nStartPage"] <= $arResult["nEndPage"]);
		
		if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
			if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
				if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
	/*?>
			<span class="b-page-navigation_dots">...</span>
	<?*/
	?>
			<a class="b-page-navigation_dots" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?>">...</a>
	<?
				endif;
	?>
			<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
	<?
			endif;
	?>
			<a class="b-page-navigation_next" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_next")?></a>
	<?
		endif;
	endif;

	if ($arResult["bShowAll"]):
		if ($arResult["NavShowAll"]):
	?>
			<a class="b-page-navigation_pagen" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0"><?=GetMessage("nav_paged")?></a>
	<?
		else:
	?>
			<a class="b-page-navigation_all" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_all")?></a>
	<?
		endif;
	endif
	?>
</div>
