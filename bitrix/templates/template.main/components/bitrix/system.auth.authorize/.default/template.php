<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="b-authform">
	<? if(!empty($arParams["~AUTH_RESULT"])): ?>
		<? $text = str_replace(array("<br>", "<br>"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]); ?>
		<div class="alert alert-danger"><?=nl2br(htmlspecialcharsbx($text))?></div>
	<? endif; ?>
	<? if($arResult['ERROR_MESSAGE'] != ''): ?>
		<? $text = str_replace(array("<br>", "<br>"), "\n", $arResult['ERROR_MESSAGE']); ?>
		<div class="alert alert-danger"><?=nl2br(htmlspecialcharsbx($text))?></div>
	<? endif; ?>
	<h3><?=GetMessage("AUTH_PLEASE_AUTH")?></h3>
	<? if($arResult["AUTH_SERVICES"]): ?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:socserv.auth.form",
			"flat",
			array(
				"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
				"AUTH_URL" => $arResult["AUTH_URL"],
				"POST" => $arResult["POST"],
			),
			$component,
			array("HIDE_ICONS"=>"Y")
		);?>
	<? endif; ?>
	<form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="AUTH">
		<? if (strlen($arResult["BACKURL"]) > 0): ?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>">
		<? endif; ?>
		<? foreach ($arResult["POST"] as $key => $value): ?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>">
		<? endforeach; ?>
			<div class="b-authform__item">
				<label class="b-authform__label" for="i-auth-user-login"><?=GetMessage("AUTH_LOGIN")?></label>
				<div class="b-authform__field">
					<input type="text" name="USER_LOGIN" id="i-auth-user-login" value="<?=$arResult["LAST_LOGIN"]?>">
				</div>
			</div>
			<div class="b-authform__item">
				<label class="b-authform__label" for="i-auth-user-password"><?=GetMessage("AUTH_PASSWORD")?></label>
				<div class="b-authform__field">
					<? if($arResult["SECURE_AUTH"]): ?>
						<div class="b-authform__psw-protected" id="i-auth_secure" style="display:none">
							<div class="b-authform__psw-protected-desc">
								<span class="b-authform__psw-protected-arrow"></span><?echo GetMessage("AUTH_SECURE_NOTE")?>
							</div>
						</div>
						<script type="text/javascript">
							document.getElementById('i-auth_secure').style.display = '';
						</script>
					<? endif; ?>
					<input type="password" name="USER_PASSWORD" id="i-auth-user-password" autocomplete="off">
				</div>
			</div>
		<? if($arResult["CAPTCHA_CODE"]): ?>
			<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>">
			<div class="b-authform__item dbg_captha">
				<label class="b-authform__label" for="i-auth-captcha"><?echo GetMessage("AUTH_CAPTCHA_PROMT")?></label>
				<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA"></div>
				<div class="b-authform__field">
					<input type="text" name="captcha_word" id="i-auth-captcha" value="" autocomplete="off">
				</div>
			</div>
		<? endif; ?>
		<? if ($arResult["STORE_PASSWORD"] == "Y"): ?>
			<div class="b-authform__item">
				<label class="b-authform__label">
					<input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y">
					<?=GetMessage("AUTH_REMEMBER_ME")?>
				</label>
			</div>
		<? endif; ?>
		<div class="b-authform__item b-authform__submit">
			<button type="submit" class="g-button" name="Login"><?=GetMessage("AUTH_AUTHORIZE")?></button>
			<? if ($arParams["NOT_SHOW_LINKS"] != "Y"): ?>
				<div class="b-authform__link">
					<a class="g-decorated-link" href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow">
						<?=GetMessage("AUTH_FORGOT_PASSWORD_2")?>
					</a>
				</div>
			<? endif; ?>
		</div>
	</form>
</div>
<?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"): ?>
	<div class="b-registration">
		<h3><?=GetMessage("AUTH_FIRST_ONE")?></h3>
		<a class="g-decorated-link" href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow">
			<span><?=GetMessage("AUTH_REGISTER")?></span>
		</a>
	</div>
<? endif; ?>
<script type="text/javascript">
	<? if (strlen($arResult["LAST_LOGIN"]) > 0): ?>
		try {
			document.form_auth.USER_PASSWORD.focus();
		}
		catch(e) {

		}
	<? else: ?>
		try {
			document.form_auth.USER_LOGIN.focus();
		}
		catch(e) {

		}
	<? endif ?>
</script>