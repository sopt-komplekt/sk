<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;

if ($arParams['SHOW_PRIVATE_PAGE'] !== 'Y')
{
	LocalRedirect($arParams['SEF_FOLDER']);
}

// $APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_PRIVATE"));
if ($arParams['SET_TITLE'] == 'Y')
{
	$APPLICATION->SetTitle(Loc::getMessage("SPS_TITLE_PRIVATE"));
}

?>
<?/* if (!empty($_REQUEST["register"])): ?>
	<?$APPLICATION->IncludeComponent( 
	   "bitrix:main.register", 
	   "", 
	   Array( 
	      "USER_PROPERTY_NAME" => "", 
	      "SEF_MODE" => "N", 
	      "SHOW_FIELDS" => Array(), 
	      "REQUIRED_FIELDS" => Array(), 
	      "AUTH" => "Y", 
	      "USE_BACKURL" => "Y", 
	      "SUCCESS_PAGE" => $APPLICATION->GetCurPageParam('',array('backurl')), 
	      "SET_TITLE" => "N", 
	      "USER_PROPERTY" => Array() 
	   ) 
	);?>
<? else: */?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.profile",
		"",
		Array(
			"SET_TITLE" =>$arParams["SET_TITLE"],
			"AJAX_MODE" => $arParams['AJAX_MODE_PRIVATE'],
			"SEND_INFO" => $arParams["SEND_INFO_PRIVATE"],
			"CHECK_RIGHTS" => $arParams['CHECK_RIGHTS_PRIVATE'],
		),
		$component
	);?>
<?// endif; ?>