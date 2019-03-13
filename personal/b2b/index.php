<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Профили юр.лиц");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.maskedinput.js");
ini_set('display_errors','On');
error_reporting('E_ALL');
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?$APPLICATION->IncludeComponent(
    "kh:kh.b2b",
    "",
    array(),
    false
);?>

<script type="text/javascript">
    jQuery(function($){
        $("#phone").mask("+7(999)999-99-99");
    });
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
