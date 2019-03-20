<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Модерация юридических лиц");
ini_set('display_errors','On');
error_reporting('E_ALL');
?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<?$APPLICATION->IncludeComponent(
    "kh:kh.b2b",
    "inactive_legal_entities",
    array("LEGAL_ENTITY"=>"moderate_list"),
    false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>