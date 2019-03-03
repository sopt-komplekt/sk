<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="b-authform">
	<? if(!empty($arParams["~AUTH_RESULT"])): ?>
	<? $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]); ?>
		<div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
	<? endif; ?>
	<h3><?=GetMessage("AUTH_GET_CHECK_STRING")?></h3>
	<p class="b-authform__description"><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></p>

	<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<? if($arResult["BACKURL"] <> ''): ?>
			<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<? endif; ?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">

		<div class="b-authform__item">
			<label class="b-authform__label" for="i-auth-login-email">
				<?echo GetMessage("AUTH_LOGIN_EMAIL")?>
			</label>
			<div class="b-authform__field">
				<input type="text" name="USER_LOGIN" id="i-auth-login-email" value="<?=$arResult["LAST_LOGIN"]?>">
				<input type="hidden" name="USER_EMAIL">
			</div>
		</div>

		<? if ($arResult["USE_CAPTCHA"]): ?>
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
			<button type="submit" class="g-button" name="send_account_info">
				<?=GetMessage("AUTH_SEND")?>
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
	document.bform.onsubmit = function(){
		document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;
	};
	document.bform.USER_LOGIN.focus();
</script>