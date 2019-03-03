<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Страница не найдена");
?>

<div class="b-unfound">
	<p>К сожалению, такой страницы не существует.</p>
	<p style="margin-top: 20px;"><a class="g-button" href="/">Вернуться на главную</a></p>
</div>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>