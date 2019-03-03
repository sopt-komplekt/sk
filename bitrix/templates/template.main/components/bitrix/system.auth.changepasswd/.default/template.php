<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<div class="b-authform">
	<? if(!empty($arParams["~AUTH_RESULT"])): ?>
		<? $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]); ?>
		<div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
	<? endif; ?>
	<h3><?=GetMessage("AUTH_CHANGE_PASSWORD")?></h3>

	<form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
	<? if($arResult["BACKURL"] != ''): ?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<? endif ?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="CHANGE_PWD">

		<div class="b-authform__item">
			<label class="b-authform__label" for="i-auth-user-login">
				<?=GetMessage("AUTH_LOGIN")?>
			</label>
			<div class="b-authform__field">
				<input type="text" name="USER_LOGIN" id="i-auth-user-login" value="<?=$arResult["LAST_LOGIN"]?>" />
			</div>
		</div>

		<div class="b-authform__item">
			<label class="b-authform__label" for="i-auth-checkword">
				<?=GetMessage("AUTH_CHECKWORD")?>
			</label>
			<div class="b-authform__field">
				<input type="text" name="USER_CHECKWORD" id="i-auth-checkword" value="<?=$arResult["USER_CHECKWORD"]?>" />
			</div>
		</div>

		<div class="b-authform__description">
			<?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
		</div>

		<div class="b-authform__item">
			<label class="b-authform__label" for="i-auth-user-password">
				<?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>
			</label>
			<div class="b-authform__field">
				<?if($arResult["SECURE_AUTH"]):?>
					<div class="b-authform__psw-protected" id="bx_auth_secure" style="display:none">
						<div class="b-authform__psw-protected-desc">
							<span class="b-authform__psw-protected-arrow"></span>
							<?echo GetMessage("AUTH_SECURE_NOTE")?>
						</div>
					</div>
					<script type="text/javascript">
						document.getElementById('bx_auth_secure').style.display = '';
					</script>
				<? endif; ?>
				<input type="password" name="USER_PASSWORD" id="i-auth-user-password" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="off" />
			</div>
		</div>

		<div class="b-authform__item">
			<label class="b-authform__label" for="i-auth-user-password-conf">
				<?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>
			</label>
			<div class="b-authform__field">
				<?if($arResult["SECURE_AUTH"]):?>
					<div class="b-authform__psw-protected" id="bx_auth_secure_conf" style="display:none">
						<div class="b-authform__psw-protected-desc">
							<span class="b-authform__psw-protected-arrow"></span>
							<?echo GetMessage("AUTH_SECURE_NOTE")?>
						</div>
					</div>
					<script type="text/javascript">
						document.getElementById('bx_auth_secure_conf').style.display = '';
					</script>
				<? endif; ?>
				<input type="password" name="USER_CONFIRM_PASSWORD" id="i-auth-user-password-conf" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="off">
			</div>
		</div>

		<? if ($arResult["USE_CAPTCHA"]):?>
			<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>">
			<div class="b-authform__item">
				<label class="b-authform__label">
					<?echo GetMessage("system_auth_captcha")?>
				</label>
				<div class="bx-captcha">
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA">
				</div>
				<div class="b-authform__field">
					<input type="text" name="captcha_word" value="" autocomplete="off">
				</div>
			</div>
		<? endif; ?>

		<div class="b-authform__item b-authform__submit">
			<button type="submit" class="g-button" name="change_pwd" >
				<?=GetMessage("AUTH_CHANGE")?>
			</button>
		</div>

	</form>

</div>

<div class="b-authorization">
	<h3><?=GetMessage("BACK_TO_AUTH")?></h3>
	<a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow">
		<?=GetMessage("AUTH_AUTH")?>
	</a>
</div>

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
