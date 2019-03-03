<?
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	$arResult["VALUES"] = $arResult["arUser"];
?>

<?=ShowError($arResult["strProfileError"]);?>

<?
if ($arResult['DATA_SAVED'] == 'Y')
	echo ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>

<div class="b-profile-form">

	<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">

		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
		<input type="hidden" name="LOGIN" value=<?=$arResult["arUser"]["LOGIN"]?> />
		<input type="hidden" name="EMAIL" value=<?=$arResult["arUser"]["EMAIL"]?> />

		<? foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>
			<div class="b-profile-form_item">
				
				<? if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true): ?>
					<?echo GetMessage("main_profile_time_zones_auto")?>
					<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
					<select name="AUTO_TIME_ZONE" onchange="this.form.elements['TIME_ZONE'].disabled=(this.value != 'N')">
						<option value=""><?echo GetMessage("main_profile_time_zones_auto_def")?></option>
						<option value="Y"<?=$arResult["VALUES"][$FIELD] == "Y" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_yes")?></option>
						<option value="N"<?=$arResult["VALUES"][$FIELD] == "N" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_no")?></option>
					</select>
					<br />
					<?echo GetMessage("main_profile_time_zones_zones")?>		
					<select name="TIME_ZONE"<?if(!isset($_REQUEST["TIME_ZONE"])) echo 'disabled="disabled"'?>>
						<?foreach($arResult["TIME_ZONE_LIST"] as $tz=>$tz_name):?>
							<option value="<?=htmlspecialcharsbx($tz)?>"<?=$arResult["VALUES"]["TIME_ZONE"] == $tz ? " selected=\"selected\"" : ""?>><?=htmlspecialcharsbx($tz_name)?></option>
						<?endforeach?>
					</select>
				<? else: ?>

					<label class="b-profile-form_label">
						<?=GetMessage("FIELD_".$FIELD)?>:
						<? if (in_array($FIELD, $arResult["REQUIRED_FIELDS"])): ?>
							<span class="required">*</span>
						<? endif; ?>
					</label>

				<? //endif; ?>

				<?
				switch ($FIELD)
				{
					case "LOGIN":
						?>
						<div class="b-profile-form_field b-profile-form_text">
							<input size="30" name="<?=$FIELD?>" value="<?=$arResult["VALUES"][$FIELD]?>" />
						</div>
						<div class="b-profile-form_item-hint">
							&mdash;&nbsp;<?=GetMessage("LOGIN_MIN_HINT")?>
						</div>
						<?
						break;

					case "NEW_PASSWORD":
						?>
						<div class="b-profile-form_field b-profile-form_text">
							<input size="30" type="password" name="<?=$FIELD?>" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" class="bx-auth-input" />
							<? if($arResult["SECURE_AUTH"]): ?>
								<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
									<div class="bx-auth-secure-icon"></div>
								</span>
								<noscript>
								<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
									<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
								</span>
								</noscript>
								<script type="text/javascript">document.getElementById('bx_auth_secure').style.display = 'inline-block';</script>
							<? endif; ?>
						</div>
						<div class="b-profile-form_item-hint">
							&mdash;&nbsp;<?=$arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
						</div>
						<?
						break;

					case "NEW_PASSWORD_CONFIRM":
						?>
						<div class="b-profile-form_field b-profile-form_text">
							<input size="30" type="password" name="<?=$FIELD?>" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" />
						</div>
						<?
						break;

					case "PERSONAL_GENDER":
						?>
						<div class="b-profile-form_field b-profile-form_dropdown">
							<select class="chzn-select-deselect" name="<?=$FIELD?>">
								<option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
								<option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
								<option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
							</select>
						</div>
						<?
						break;

					case "PERSONAL_COUNTRY":
					case "WORK_COUNTRY":
						?>
						<div class="b-profile-form_field b-profile-form_dropdown">
							<select name="<?=$FIELD?>"><?
								foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
								{
									?><option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
								<?
								}
								?>
							</select>
						</div>
						<?
						break;

					case "PERSONAL_PHOTO":
					case "WORK_LOGO":
						?>
						<div class="b-profile-form_field b-profile-form_text">
							<input size="30" type="file" name="FILES_<?=$FIELD?>" />
							<?//=$arResult["arUser"]["WORK_LOGO_INPUT"]?>
						</div>
						<?
						break;

					case "PERSONAL_NOTES":
					case "WORK_NOTES":
						?>
						<div class="b-profile-form_field b-profile-form_textarea">
							<textarea cols="30" rows="5" name="<?=$FIELD?>"><?=$arResult["VALUES"][$FIELD]?></textarea>
						</div>
						<?
						break;

					default:
						if ($FIELD == "PERSONAL_BIRTHDAY"):?>
							<small><?=$arResult["DATE_FORMAT"]?></small><br />
						<? endif; ?>
							<div class="b-profile-form_field b-profile-form_text">
								<input size="30" type="text" name="<?=$FIELD?>" value="<?=$arResult["VALUES"][$FIELD]?>" />
								<?
								if ($FIELD == "PERSONAL_BIRTHDAY")
									$APPLICATION->IncludeComponent(
										'bitrix:main.calendar',
										'',
										array(
											'SHOW_INPUT' => 'N',
											'FORM_NAME' => 'regform',
											'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
											'SHOW_TIME' => 'N'
										),
										null,
										array("HIDE_ICONS"=>"Y")
									);
								?>
							</div>
				<?
				} // endswitch
				?>
				<?endif?>
			</div>
		<? endforeach ?>

		<?// ********************* User properties ***************************************************?>
		<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
			
				<!--<?=strLen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?>-->
				<? foreach($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
					<div class="b-profile-form_item">
						<label class="b-profile-form_label">
							<?=$arUserField["EDIT_FORM_LABEL"]?>
							<?if ($arUserField["MANDATORY"]=="Y"): ?>&nbsp;<span class="required">*</span><? endif; ?>
						</label>
						<? if($FIELD_NAME == 'UF_REGION'): ?>
							<div class="b-profile-form_field b-profile-form_dropdown">
								<select class="chzn-select-deselect" name="UF_REGION">
									<option value=""></option>
									<? foreach ($arResult['REGION_SECTIONS'] as $arRegionSection): ?>
										<option value="<?=$arRegionSection['ID']?>"<? if($arRegionSection['ID']==$_POST['UF_REGION']): ?> selected<? endif ?>><?=$arRegionSection['NAME']?></option>
									<? endforeach ?>
								</select>
							</div>
						<? else: ?>
							<div class="b-profile-form_field b-profile-form_text">
								<?$APPLICATION->IncludeComponent(
									"bitrix:system.field.edit",
									$arUserField["USER_TYPE"]["USER_TYPE_ID"],
									array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?>
							</div>
						<? endif; ?>
					</div>
				<? endforeach; ?>
		<? endif; ?>

		<p><span class="required">*</span> <?=GetMessage("REQUIRED_TEXT")?></p>
		
		<div class="b-profile-form_button">
			<button class="g-button" type="submit" name="save" value="<?=GetMessage("MAIN_SAVE")?>">
				<span><?=GetMessage("MAIN_SAVE")?></span>
			</button>
		</div>

		<div class="g-clean"></div>

	</form>

</div>