<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

?>

<div class="bx_profile">
	<?
	ShowError($arResult["strProfileError"]);

	if ($arResult['DATA_SAVED'] == 'Y')
	{
		ShowNote(Loc::getMessage('PROFILE_DATA_SAVED'));
	}

	?>
	<form method="post" name="form1" action="<?=$APPLICATION->GetCurUri()?>" enctype="multipart/form-data" role="form">
		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
		<input type="hidden" name="LOGIN" value=<?=$arResult["arUser"]["LOGIN"]?> />
		<div class="main-profile-block-shown" id="user_div_reg">
			<div class="main-profile-block-date-info">
				<?
				if($arResult["ID"]>0)
				{
					if (strlen($arResult["arUser"]["TIMESTAMP_X"])>0)
					{
						?>
						<div class="col-sm-12 small">
							<strong><?=Loc::getMessage('LAST_UPDATE')?></strong>
							<strong><?=$arResult["arUser"]["TIMESTAMP_X"]?></strong>
						</div>
						<?
					}

					if (strlen($arResult["arUser"]["LAST_LOGIN"])>0)
					{
						?>
						<div class="col-sm-12 small">
							<strong><?=Loc::getMessage('LAST_LOGIN')?></strong>
							<strong><?=$arResult["arUser"]["LAST_LOGIN"]?></strong>
						</div>
						<?
					}
				}
				?>
			</div>
			<?
			if (!in_array(LANGUAGE_ID,array('ru', 'ua')))
			{
				?>
				<div class="form-group">
					<label class="main-profile-form-label col-sm-12 col-md-12" for="main-profile-title"><?=Loc::getMessage('main_profile_title')?></label>
					<div class="col-sm-12">
						<input class="form-control" type="text" name="TITLE" maxlength="50" id="main-profile-title" value="<?=$arResult["arUser"]["TITLE"]?>" />
					</div>
				</div>
				<?
			}
			?>
			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-12" for="main-profile-name"><?=Loc::getMessage('NAME')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="NAME" maxlength="50" id="main-profile-name" value="<?=$arResult["arUser"]["NAME"]?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-12" for="main-profile-last-name"><?=Loc::getMessage('LAST_NAME')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-12" for="main-profile-second-name"><?=Loc::getMessage('SECOND_NAME')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="SECOND_NAME" maxlength="50" id="main-profile-second-name" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-12" for="main-profile-email"><?=Loc::getMessage('EMAIL')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="EMAIL" maxlength="50" id="main-profile-email" value="<?=$arResult["arUser"]["EMAIL"]?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="main-profile-form-label col-sm-12 col-md-12" for="main-profile-email"><?=Loc::getMessage('PHONE')?></label>
				<div class="col-sm-12">
					<input class="form-control" type="text" name="PERSONAL_PHONE" maxlength="50" id="main-profile-phone" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
				</div>
			</div>
			<?
			if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == '')
			{
				?>
				<div class="form-group">
					<p class="main-profile-form-password-annotation col-sm-12 small">
						<?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
					</p>
				</div>
				<div class="form-group">
					<label class="main-profile-form-label col-sm-12 col-md-12" for="main-profile-password"><?=Loc::getMessage('NEW_PASSWORD_REQ')?></label>
					<div class="col-sm-12">
						<input class=" form-control bx-auth-input main-profile-password" type="password" name="NEW_PASSWORD" maxlength="50" id="main-profile-password" value="" autocomplete="off"/>
					</div>
				</div>
				<div class="form-group">
					<label class="main-profile-form-label main-profile-password col-sm-12 col-md-12" for="main-profile-password-confirm">
						<?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?>
					</label>
					<div class="col-sm-12">
						<input class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off" />
					</div>
				</div>
				<?
			}
			?>
		</div>
		<p class="main-profile-form-buttons-block col-sm-12">
			<button type="submit" name="save" class="btn g-button btn-themes btn-default btn-md main-profile-submit" value="y"><?=(($arResult["ID"]>0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?></button>
			<button type="submit" class="btn g-decorated-link btn-themes btn-default btn-md"  name="reset"><span><?echo GetMessage("MAIN_RESET")?></span></button>
		</p>
	</form>
	<div class="clearfix"></div>
</div>
<script>
	$('#main-profile-phone').mask('+7 (999) 999-99-99');
</script>