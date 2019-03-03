<? 
use \Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>

<div class="b-custom-elements-form">

	<? if($arResult["CHECK_FIELDS"] === "ERROR"): ?>
		<? ShowMessage($arResult['MESSAGE']); ?>
	<? elseif($arResult["CHECK_FIELDS"] === "SUCCESS"): ?>
		<? ShowMessage(Array('TYPE'=>'OK', 'MESSAGE'=>$arResult['MESSAGE'])); ?>
	<? else: ?>
		<?
		if($arResult["FIELDS"]["ACTION"] === "del") {
			$buttonText = Loc::getMessage("MA_CUSTOM_ELEMENT_RESULT_TEXT_BUTTON_DEL");
			$action = "del";
		} elseif($arResult["FIELDS"]["ACTION"] === "edit") {
			$buttonText = Loc::getMessage("MA_CUSTOM_ELEMENT_RESULT_TEXT_BUTTON_EDIT");
			$action = "edit";
		} else {
			$buttonText = Loc::getMessage("MA_CUSTOM_ELEMENT_RESULT_TEXT_BUTTON_ADD");
			$action = "add";
		}
		?>
		<div class="b-custom-elements-form_holder">
			<form action="<?=$APPLICATION->GetCurPage(false);?>" method="POST" <? if($_REQUEST['redirect']): ?> data-redirect="<? echo $_REQUEST['redirect']?>"<? endif; ?>>
				<input type="hidden" value="<?=$action?>" name="action">
				<? if($action === "del"): ?>
					<? if($arResult["FIELDS"]["STEP"] == 0): ?>
						<input type="hidden" value="<?$_REQUEST["id"]?>" name="id">
						<input type="hidden" value="<?=$arResult["FIELDS"]["STEP"] + 1?>" name="step">
						<div class="b-custom-elements-form_item<?if($arResult["ERRORS"]["TEMPLATE_ID"]=="Y"):?> error<?endif;?>">
							<div class="b-custom-elements-form_field">
								<select name="id" id="template">
									<option value="def"><?= Loc::getMessage("PROJ_PROJ_DEFAULT_OPTION");?></option>
									<? foreach($arResult["TEMPLATES"] as $arTemplate): ?>
										<option value="<?=$arTemplate["ID"]?>"<?if($_POST["template"] == $arTemplate["ID"]):?> selected<?endif;?>><?=htmlspecialcharsBack($arTemplate["NAME"]);?></option>
									<? endforeach; ?>
								</select>
							</div>
						</div>
					<? elseif($arResult["FIELDS"]["STEP"] == 1): ?>
						<input type="hidden" value="<?=$arResult["FIELDS"]["TEMPLATE_ID"]?>" name="id">
						<input type="hidden" value="<?=$arResult["FIELDS"]["STEP"] + 1?>" name="step">
						<div class="b-templates-confirm-text">
							<?=$arResult["MESSAGE"]?>
						</div>
					<? endif; ?>
				<? elseif($action === "edit"): ?>
					<input type="hidden" value="<?=$arResult["FIELDS"]["STEP"] + 1?>" name="step">
					<input type="hidden" value="<?=$arResult["FIELDS"]["TEMPLATE_ID"]?>" name="id">
					<div class="b-custom-elements-form_item<?if($arResult["ERRORS"]["NAME"]=="Y"):?> error<?endif;?>">
						<label class="b-custom-elements-form_label" for="edit-template-name"><?= Loc::getMessage("MA_CUSTOM_ELEMENT_RESULT_EDIT_ELEMENT")?></label>
						<div class="b-custom-elements-form_field">
							<input type="text" name="template_name" id="edit-template-name" value="<?=$arResult["FIELDS"]["TEMPLATE_NAME"]?>" placeholder="<?= Loc::getMessage("MA_CUSTOM_ELEMENT_RESULT_EDIT_ELEMENT")?>">
						</div>
					</div>
				<? elseif($action === "add"): ?>
					<input type="hidden" value="<?=$arResult["FIELDS"]["STEP"] + 1?>" name="step">
					<div class="b-custom-elements-form_description">
						<?=htmlspecialcharsBack($arParams["MESSAGE_DESCRIPTION"])?>
					</div>
					<div class="b-custom-elements-form_item<?if($arResult["ERRORS"]["NAME"]=="Y"):?> error<?endif;?>">
						<label class="b-custom-elements-form_label" for="edit-template-name"><?= Loc::getMessage("MA_CUSTOM_ELEMENT_RESULT_ADD_ELEMENT")?></label>
						<div class="b-custom-elements-form_field">
							<input type="text" name="template_name" id="edit-template-name" placeholder="<?= Loc::getMessage("MA_CUSTOM_ELEMENT_RESULT_ADD_ELEMENT")?>">
						</div>
					</div>
				<? endif; ?>
				<div class="b-custom-elements-form_submit">
					<button type="submit" class="g-button">
						<?=$buttonText?>
					</button>
					<? if($action === "del"): ?>
						<button class="g-button arcticmodal-close">
							Нет
						</button>
					<? endif; ?>
				</div>
			</form>
		</div>
	<? endif; ?>
</div>