<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?
	global $arTemplateParams;
	$arTemplateParams = array(
		"TEMPLATE_PATH" => "/bitrix/templates/template.mail/",
		"SITE_URL" => "http://site-name.ru/",
		"SITE_NAME" => "Название сайта",
		"SITE_PRIMARY_COLOR" => "#1f1f1f",
		"SITE_DEFAULT_COLOR" => "#eaeaea",
		"SITE_BACKGROUND_COLOR" => "#f1f1f1",
		"SITE_TEXT_COLOR" => "#1f1f1f",
		"SITE_LOGO" => "logo.png"
	);
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		body { background-color: #efefe9; }
		a { color: <?=$arTemplateParams['SITE_PRIMARY_COLOR'] ?>; }
	</style>
</head>
<body style="margin:0; padding:0;">
	<table border="0" bgcolor="<?=$arTemplateParams['SITE_BACKGROUND_COLOR']?>" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0;">
		<tr>
			<td height="100%" style="padding:30px;">
				<center style="max-width:550px; width:100%; margin:0 auto">
					<table border="0" bgcolor="#ffffff" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0; font-size:14px; line-height:21px; font-family:Arial,sans-serif; border:1px solid <?=$arTemplateParams['SITE_DEFAULT_COLOR'] ?>; border-top:none; color:<?=$arTemplateParams['SITE_TEXT_COLOR'] ?>;">
						<tr>
							<td style="border-top: 5px solid <?=$arTemplateParams['SITE_PRIMARY_COLOR'] ?>;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0;">
									<tbody>
										<tr>
											<td style="width:30px;"></td>
											<td height="80" align="left">
												<div style="line-height: 0;">
													<img
														src="<?=$arTemplateParams['SITE_URL'].$arTemplateParams['TEMPLATE_PATH']?>img/<?=$arTemplateParams['SITE_LOGO'] ?>"
														alt="<?=$arTemplateParams['SITE_NAME'] ?>"
														border="0"
														width="180"
														style="display:block; font-size:16px; line-height:100%; text-indent:10px;"
													/>
												</div>
											</td>
											<td width="140" align="right"></td>
											<td style="width:30px;"></td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0;">
									<tbody>
										<tr>
											<td style="width: 30px;"></td>
											<td style="padding-top:10px; padding-bottom:10px; border-top:1px solid <?=$arTemplateParams['SITE_DEFAULT_COLOR']?>; border-bottom:1px solid <?=$arTemplateParams['SITE_DEFAULT_COLOR']?>">