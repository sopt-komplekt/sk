<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="subscribe-form">
	<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
		<?echo bitrix_sessid_post();?>
		<input type="hidden" name="PostAction" value="Add" />
		<input type="hidden" name="ID" value="" />
		<input type="hidden" name="RUB_ID[]" value="0" />
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<label for="sf_RUB_ID_<?=$itemValue["ID"]?>">
			<input type="checkbox" name="RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> /> <?=$itemValue["NAME"]?>
			</label>
		<?endforeach;?>
		<table border="0" cellspacing="0" cellpadding="2" align="center">
			<tr>
				<td><input class="text-input" type="text" name="EMAIL" size="20" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>" /></td>
				<td align="right">
					<button class="g-button" type="submit" name="Save" value="<?=GetMessage("subscr_form_button")?>"><span><?=GetMessage("subscr_form_button")?></span></button>
				</td>
			</tr>
		</table>
	</form>
</div>