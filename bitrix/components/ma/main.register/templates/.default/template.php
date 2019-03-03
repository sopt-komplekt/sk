<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>
<div class="b-register-form">

	<?if($USER->IsAuthorized()):?>

		<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>

	<?else:?>

		<?
		if (count($arResult["ERRORS"]) > 0):
			foreach ($arResult["ERRORS"] as $key => $error)
				if (intval($key) == 0 && $key !== 0) 
					$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

			ShowError(implode("<br />", $arResult["ERRORS"]));

		elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
		?>
		<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
		
		<? endif ?>

		<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
			<input type="hidden" name="register_submit_button" value="Y">
			<?
			if($arResult["BACKURL"] <> ''):
			?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
			<?
			endif;
			?>

			<? foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>
				<div class="b-register-form_item">
					
					<? if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true): ?>
						<?echo GetMessage("main_profile_time_zones_auto")?>
						<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?>
						<select name="REGISTER[AUTO_TIME_ZONE]" onchange="this.form.elements['REGISTER[TIME_ZONE]'].disabled=(this.value != 'N')">
							<option value=""><?echo GetMessage("main_profile_time_zones_auto_def")?></option>
							<option value="Y"<?=$arResult["VALUES"][$FIELD] == "Y" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_yes")?></option>
							<option value="N"<?=$arResult["VALUES"][$FIELD] == "N" ? " selected=\"selected\"" : ""?>><?echo GetMessage("main_profile_time_zones_auto_no")?></option>
						</select>
						<br />
						<?echo GetMessage("main_profile_time_zones_zones")?>		
						<select name="REGISTER[TIME_ZONE]"<?if(!isset($_REQUEST["REGISTER"]["TIME_ZONE"])) echo 'disabled="disabled"'?>>
							<?foreach($arResult["TIME_ZONE_LIST"] as $tz=>$tz_name):?>
								<option value="<?=htmlspecialcharsbx($tz)?>"<?=$arResult["VALUES"]["TIME_ZONE"] == $tz ? " selected=\"selected\"" : ""?>><?=htmlspecialcharsbx($tz_name)?></option>
							<?endforeach?>
						</select>
					<? else: ?>

						<label class="b-register-form_label">
							<?=GetMessage("REGISTER_FIELD_".$FIELD)?>:
							<? if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"): ?>
								<span class="required">*</span>
							<? endif; ?>
						</label>

					<? //endif; ?>

					<?
					switch ($FIELD)
					{
						case "LOGIN":
							?>
							<div class="b-register-form_field b-register-form_text">
								<input size="30" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
							</div>
							<div class="b-register-form_item-hint">
								&mdash;&nbsp;<?=GetMessage("AUTH_LOGIN_MIN_HINT")?>
							</div>
							<?
							break;

						case "PASSWORD":
							?>
							<div class="b-register-form_field b-register-form_text">
								<input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" class="bx-auth-input" />
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
							<div class="b-register-form_item-hint">
								&mdash;&nbsp;<?=$arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
							</div>
							<?
							break;

						case "CONFIRM_PASSWORD":
							?>
							<div class="b-register-form_field b-register-form_text">
								<input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" autocomplete="off" />
							</div>
							<?
							break;

						case "PERSONAL_GENDER":
							?>
							<div class="b-register-form_field b-register-form_dropdown">
								<select class="chzn-select-deselect" name="REGISTER[<?=$FIELD?>]">
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
							<div class="b-register-form_field b-register-form_dropdown">
								<select name="REGISTER[<?=$FIELD?>]"><?
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
							<div class="b-register-form_field b-register-form_text">
								<input size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" />
							</div>
							<?
							break;

						case "PERSONAL_NOTES":
						case "WORK_NOTES":
							?>
							<div class="b-register-form_field b-register-form_textarea">
								<textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea>
							</div>
							<?
							break;

						default:
							if ($FIELD == "PERSONAL_BIRTHDAY"):?>
								<small><?=$arResult["DATE_FORMAT"]?></small><br />
							<? endif; ?>
								<div class="b-register-form_field b-register-form_text">
									<input size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" />
									<?
									if ($FIELD == "PERSONAL_BIRTHDAY")
										$APPLICATION->IncludeComponent(
											'bitrix:main.calendar',
											'',
											array(
												'SHOW_INPUT' => 'N',
												'FORM_NAME' => 'regform',
												'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
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
						<div class="b-register-form_item">
							<label class="b-register-form_label">
								<?=$arUserField["EDIT_FORM_LABEL"]?>
								<?if ($arUserField["MANDATORY"]=="Y"): ?>&nbsp;<span class="required">*</span><? endif; ?>
							</label>
							<? if($FIELD_NAME == 'UF_REGION'): ?>
								<div class="b-register-form_field b-register-form_dropdown">
									<select class="chzn-select-deselect" name="UF_REGION">
										<option value=""></option>
										<? foreach ($arResult['REGION_SECTIONS'] as $arRegionSection): ?>
											<option value="<?=$arRegionSection['ID']?>"<? if($arRegionSection['ID']==$_POST['UF_REGION']): ?> selected<? endif ?>><?=$arRegionSection['NAME']?></option>
										<? endforeach ?>
									</select>
								</div>
							<? elseif($arUserField['USER_TYPE_ID'] == 'enumeration' && $arUserField['SETTINGS']['DISPLAY'] == 'CHECKBOX'): ?>
								<div class="b-register-form_field b-register-form_checkbox">
									<?$APPLICATION->IncludeComponent(
										"bitrix:system.field.edit",
										$arUserField["USER_TYPE"]["USER_TYPE_ID"],
										array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?>
								</div>
							<? else: ?>
								<div class="b-register-form_field b-register-form_text">
									<?$APPLICATION->IncludeComponent(
										"bitrix:system.field.edit",
										$arUserField["USER_TYPE"]["USER_TYPE_ID"],
										array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?>
								</div>
							<? endif; ?>
						</div>
					<? endforeach; ?>
			<? endif; ?>


			<? if($arResult["USE_CAPTCHA"] == "Y"): ?>
				<div class="b-register-form_item">
					<label class="b-register-form_label">
						<?=GetMessage("CAPTCHA_REGF_TITLE")?>&nbsp;<span class="required">*</span>
					</label>
					<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
					<div class="b-register-form_field b-register-form_captcha">
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
						<input type="text" name="captcha_word" maxlength="50" value="" />
					</div>
					<div class="b-register-form_item-hint">
						&mdash;&nbsp;<?=GetMessage("CAPTCHA_REGF_PROMT")?>
					</div>
				</div>
			<? endif; ?>

			<p><span class="required">*</span> <?=GetMessage("AUTH_REQ")?></p>

			<div class="b-register-form_eula-accepted">
				<?=GetMessage("REGISTER_EULA_ACCEPTED")?>
			</div>
			
			<div class="b-register-form_button">
				<button class="g-button" type="submit" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>">
					<span><?=GetMessage("AUTH_REGISTER")?></span>
				</button>
			</div>
			<p><a href="/auth/<?//=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_AUTH")?></a></p>
			<div class="g-clean"></div>

			<?//echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
		</form>
	<?endif?>
</div>