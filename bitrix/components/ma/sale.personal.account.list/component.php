<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("sale"))
{
	ShowError(GetMessage("SALE_MODULE_NOT_INSTALL"));
	return;
}

if (!$USER->IsAuthorized())
{
	$APPLICATION->AuthForm(GetMessage("SALE_ACCESS_DENIED"));
}

$arParams["SET_TITLE"] = ($arParams["SET_TITLE"] == "N" ? "N" : "Y" );
if($arParams["SET_TITLE"] == 'Y') {
	$APPLICATION->SetTitle(GetMessage("SPA_TITLE"));
}

if (!isset($arParams['ITEMS_AMOUNT'])) {
	$arParams['ITEMS_AMOUNT'] = 10;
}


$arFilter = array(
	"USER_ID" => "1"
);	
$dbTransactList = CSaleUserTransact::GetList(
		array("ID" => "desc"),
		$arFilter,
		false,
		array(
			"nTopCount" => $arParams['ITEMS_AMOUNT']
		),
		array()
	);

$arTrUsers = array();
while ($arTransact = $dbTransactList->Fetch()) {
	$arResult['TRANSACTIONS'][] = $arTransact;
}

$this->IncludeComponentTemplate();
?>