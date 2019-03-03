<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<div class="b-authform">
	<? if(!empty($arParams["~AUTH_RESULT"])): ?>
		<? $text = str_replace(array("<br>", "<br>"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]); ?>
		<div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
	<? endif; ?>
	<? if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"): ?>
		<div class="alert alert-success"><?echo GetMessage("AUTH_EMAIL_SENT")?></div>
	<? else: ?>

		<? if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"): ?>
			<div class="alert alert-warning"><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></div>
		<? endif; ?>
		<h3><?=GetMessage("AUTH_PLEASE_REG")?></h3>
		<form name="bform" method="post" action="<?=$arResult["AUTH_URL"]?>" enctype="multipart/form-data">
		<? if($arResult["BACKURL"] != ''): ?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>">
		<? endif; ?>
			<input type="hidden" name="AUTH_FORM" value="Y">
			<input type="hidden" name="TYPE" value="REGISTRATION">

			<div class="b-authform__item">
				<label class="b-authform__label" for="i-auth-user-name"><?=GetMessage("AUTH_NAME")?></label>
				<div class="b-authform__field">
					<input type="text" name="USER_NAME" id="i-auth-user-name" value="<?=$arResult["USER_NAME"]?>">
				</div>
			</div>

			<div class="b-authform__item">
				<label class="b-authform__label" for="i-auth-user-last-name"><?=GetMessage("AUTH_LAST_NAME")?></label>
				<div class="b-authform__field">
					<input type="text" name="USER_LAST_NAME" id="i-auth-user-last-name" value="<?=$arResult["USER_LAST_NAME"]?>">
				</div>
			</div>

			<div class="b-authform__description">
				<?echo GetMessage("AUTH_LOGIN_MIN");?>
			</div>

			<div class="b-authform__item">
				<label class="b-authform__label" for="i-auth-user-login">
					<?=GetMessage("AUTH_LOGIN")?>
					<span class="b-authform__starrequired">*</span>
				</label>
				<div class="b-authform__field">
					<input type="text" name="USER_LOGIN" id="i-auth-user-login" value="<?=$arResult["USER_LOGIN"]?>">
				</div>
			</div>

			<div class="b-authform__description">
				<?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
			</div>

			<div class="b-authform__item">
				<label class="b-authform__label" for="i-auth-user-password">
					<?=GetMessage("AUTH_PASSWORD_REQ")?>
					<span class="b-authform__starrequired">*</span>
				</label>
				<div class="b-authform__field">
					<? if($arResult["SECURE_AUTH"]): ?>
						<div class="b-authform__psw-protected" id="i-auth_secure" style="display:none">
							<div class="b-authform__psw-protected-desc">
								<span class="b-authform__psw-protected-arrow"></span>
								<?echo GetMessage("AUTH_SECURE_NOTE")?>
							</div>
						</div>
						<script type="text/javascript">
							document.getElementById('i-auth_secure').style.display = '';
						</script>
					<? endif; ?>
					<input type="password" name="USER_PASSWORD" id="i-auth-user-password" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="off">
				</div>
			</div>

			<div class="b-authform__item">
				<label class="b-authform__label" for="i-auth-user-password-conf">
					<?=GetMessage("AUTH_CONFIRM")?>
					<span class="b-authform__starrequired">*</span>
				</label>
				<div class="b-authform__field">
					<? if($arResult["SECURE_AUTH"]): ?>
						<div class="b-authform__psw-protected" id="i_auth_secure_conf" style="display:none">
							<div class="b-authform__psw-protected-desc">
								<span class="b-authform__psw-protected-arrow"></span>
								<?echo GetMessage("AUTH_SECURE_NOTE")?>
							</div>
						</div>
						<script type="text/javascript">
							document.getElementById('i_auth_secure_conf').style.display = '';
						</script>
					<? endif; ?>
					<input type="password" name="USER_CONFIRM_PASSWORD" id="i-auth-user-password-conf" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="off">
				</div>
			</div>

			<div class="b-authform__item">
				<label class="b-authform__label" for="i-auth-user-email">
					<?=GetMessage("AUTH_EMAIL")?>
					<? if($arResult["EMAIL_REQUIRED"]): ?>
						<span class="b-authform__starrequired">*</span>
					<? endif; ?>
				</label>
				<div class="b-authform__field">
					<input type="text" name="USER_EMAIL" id="i-auth-user-email" value="<?=$arResult["USER_EMAIL"]?>">
				</div>
			</div>

			<? if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
				<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
					<div class="b-authform__item">
						<label class="b-authform__label">
							<?=$arUserField["EDIT_FORM_LABEL"]?>
							<? if ($arUserField["MANDATORY"]=="Y"): ?>
								<span class="b-authform__starrequired">*</span>
							<? endif; ?>
						</label>
						<div class="b-authform__field">
							<?
							$APPLICATION->IncludeComponent(
								"bitrix:system.field.edit",
								$arUserField["USER_TYPE"]["USER_TYPE_ID"],
								array(
									"bVarsFromForm" => $arResult["bVarsFromForm"],
									"arUserField" => $arUserField,
									"form_name" => "bform"
								),
								null,
								array("HIDE_ICONS"=>"Y")
							);
							?>
						</div>
					</div>
				<?endforeach;?>
			<?endif;?>

			<? if ($arResult["USE_CAPTCHA"] == "Y"): ?>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>">
				<div class="b-authform__item">
					<label class="b-authform__label">
						<?=GetMessage("CAPTCHA_REGF_PROMT")?>
						<span class="b-authform__starrequired">*</span>
					</label>
					<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA"></div>
					<div class="b-authform__field">
						<input type="text" name="captcha_word" value="" autocomplete="off">
					</div>
				</div>
			<? endif; ?>

			<div class="b-authform__item b-authform__agreement">
				<div class="b-authform__field">
					<? $resultText = $APPLICATION->IncludeComponent("bitrix:main.userconsent.request", "",
						array(
							"ID" => COption::getOptionString("main", "new_user_agreement", ""),
							"IS_CHECKED" => "Y",
							"AUTO_SAVE" => "N",
							"IS_LOADED" => "Y",
							"ORIGINATOR_ID" => $arResult["AGREEMENT_ORIGINATOR_ID"],
							"ORIGIN_ID" => $arResult["AGREEMENT_ORIGIN_ID"],
							"INPUT_NAME" => $arResult["AGREEMENT_INPUT_NAME"],
							"REPLACE" => array(
								"button_caption" => GetMessage("AUTH_REGISTER"),
								"fields" => array(
									rtrim(GetMessage("AUTH_NAME"), ":"),
									rtrim(GetMessage("AUTH_LAST_NAME"), ":"),
									rtrim(GetMessage("AUTH_LOGIN_MIN"), ":"),
									rtrim(GetMessage("AUTH_PASSWORD_REQ"), ":"),
									rtrim(GetMessage("AUTH_EMAIL"), ":"),
								)
							),
						)
					);?>
				</div>
			</div>

			<div class="b-authform__description">
				<span class="b-authform__starrequired">*</span> –
				<?=GetMessage("AUTH_REQ")?>
			</div>

			<div class="b-authform__item b-authform__submit">
				<button type="submit" class="g-button" name="Register"><?=GetMessage("AUTH_REGISTER")?></button>
			</div>

		</form>

	<script type="text/javascript">
		try	{
			document.bform.USER_NAME.focus();
		}
		catch(e) {

		}
	</script>

<? endif; ?>
</div>
<div class="b-authorization">
	<h3><?=GetMessage("ALREADY_REGISTERED")?></h3>
	<a class="g-decorated-link" href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow">
		<span><?=GetMessage("AUTH_AUTH")?></span>
	</a>
</div>