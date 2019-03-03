<?
require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/bx_root.php');
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT.'/modules/main/include/prolog_before.php');

global $APPLICATION, $USER;
use Bitrix\Main\Config\Option;

$MODULE_ID = 'ma.comments';
$arResult = array();
$arModuleParams['USE_CAPTCHA'] = Option::get($MODULE_ID, "CAPTCHA", "off");

if ($arModuleParams['USE_CAPTCHA'] == "on") {
	$arResult["CAPTCHA_CODE"] = htmlspecialchars($APPLICATION->CaptchaGetCode()); 
}
if (is_object($USER)) {
	if ($USER->IsAuthorized()) {
		$arModuleParams['USE_CAPTCHA'] = 'off';	
	}
	$rsUser = CUser::GetByID($USER->GetId());
	$arUser = $rsUser->Fetch();
	$arResult['CUR_USER'] = $arUser;
}
?>

<form action="" method="POST">
	<div id="reply-item" class="b-comments-form_item b-comments-form_text" style="display:none;">
		<label for="REPLY_COMMENT_ID">Ответ на комментарий #</label>
		<input 
			readonly="readonly"
			id="REPLY_COMMENT_ID"
			type="hidden"
			name="REPLY_COMMENT_ID"
			placeholder="Ответ на комментарий #"
			value="<?=$_REQUEST['REPLY_COMMENT_ID']?>">
	</div>
	<div class="b-comments-form_item b-comments-form_text">
		<label for="COMMENT_NAME">Ваше имя</label>
		<input id="COMMENT_NAME" type="text" name="COMMENT_NAME" placeholder="Ваше имя" value="<?=$_REQUEST['COMMENT_NAME'] ? $_REQUEST['COMMENT_NAME'] : $arResult['CUR_USER']['NAME']?>">
	</div>
	<div class="b-comments-form_item b-comments-form_text">
		<label for="COMMENT_EMAIL">E-mail</label>
		<input id="COMMENT_EMAIL" type="text" name="COMMENT_EMAIL" placeholder="E-mail" value="<?=$_REQUEST['COMMENT_EMAIL'] ? $_REQUEST['COMMENT_EMAIL'] : $arResult['CUR_USER']['EMAIL']?>">
	</div>
	<div class="b-comments-form_item b-comments-form_text no-mrg">
		<label for="COMMENT_CITY">Город</label>
		<input id="COMMENT_CITY" type="text" name="COMMENT_CITY" placeholder="Город" value="<?=$_REQUEST['COMMENT_CITY'] ? $_REQUEST['COMMENT_CITY'] : $arResult['CUR_USER']['PERSONAL_CITY']?>">
	</div>
	<div class="g-clean"></div>
	<div class="b-comments-form_item b-comments-form_textarea">
		<label for="COMMENT_TEXT">Ваш комментарий</label>
		<textarea name="COMMENT_TEXT" id="COMMENT_TEXT" placeholder="Комментарий"><?=$_REQUEST['COMMENT_TEXT']?></textarea>
	</div>
	<?php if (!empty($arResult['CAPTCHA_CODE'])): ?>
		<div class="b-comments-form_item b-comments-form_captcha">
			<label for="COMMENT_CAPTCHA">Защита от роботов</label>
			<input type="hidden" name="captcha_sid" value="<?=$arResult['CAPTCHA_CODE']?>" />
			<img src="/bitrix/tools/captcha.php?captcha_code=<?=$arResult['CAPTCHA_CODE']?>" width="180" height="40" alt="CAPTCHA" />
			<input id="COMMENT_CAPTCHA" type="text" name="captcha_word" placeholder="Введите символы">
		</div>
	<?php endif ?>
	<div class="b-comments-form_item b-comments-form_action">
		<input class="g-button" name="submit" type="submit" value="Отправить">
	</div>
</form>