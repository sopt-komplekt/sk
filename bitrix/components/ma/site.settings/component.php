<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($arParams['USE_JQUERY'] == 'Y'){	
	switch($arParams['JQUERY_VERSION']){
		case '1.8':
		// $APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/js/jquery-1.8.3.min.js');
		CJSCore::Init(array("jquery"));
		break;
			 
		case '2.1':
		// $APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/js/jquery-2.1.3.min.js');
		CJSCore::Init(array("jquery2"));
		break;
	}
}

if($arParams['USE_FANCYBOX'] == 'Y'){	
	switch($arParams['FANCYBOX_VERSION']){
		case '2.1':
		if ($arParams['MODAL_SCRIPTS_LIST'] != 'FB') {
			$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/fancybox2/jquery.fancybox.css');
			$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/fancybox2/jquery.fancybox.pack.js');
		}
		break;
			 
		case '3.1':
		$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/fancybox3/jquery.fancybox.min.css');
		$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/fancybox3/jquery.fancybox.min.js');
		break;
	}
}

// if($arParams['USE_FANCYBOX'] == 'Y' && $arParams['MODAL_SCRIPTS_LIST'] != 'FB'){
// 	$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/fancybox2/jquery.fancybox.pack.js');
// 	$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/fancybox2/jquery.fancybox.css');
// }

if($arParams['USE_MASKEDINPUT'] == 'Y'){
	$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/js/jquery.maskedinput.min.js');
}

if($arParams['USE_POSHYTIP'] == 'Y'){
	$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/poshytip/jquery.poshytip.min.js');
}

// Использование Bootstrap
if($arParams['USE_BOOTSTRAP'] == 'Y'){	
	switch($arParams['BOOTSTRAP_VERSION']){
		case 'b3_all':
		$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/bootstrap/bootstrap3_all/js/bootstrap.min.js');
		$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/bootstrap/bootstrap3_all/css/bootstrap.min.css');
		$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/bootstrap/bootstrap3_all/css/bootstrap-theme.min.css');
		break;
		
		case 'b3_com':
		$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/bootstrap/bootstrap3_com/css/bootstrap.min.css');
		$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/bootstrap/bootstrap3_com/css/bootstrap-theme.min.css');
		break;

		case 'b3_grid':
		$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/bootstrap/bootstrap3_grid/css/bootstrap.min.css');
		$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/bootstrap/bootstrap3_grid/css/bootstrap-theme.min.css');
		break;

		case 'b3_bx':
		$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/bootstrap/bootstrap3_bx/bootstrap.min.css');
		// $APPLICATION->SetAdditionalCSS('/bitrix/css/main/font-awesome.css');
		break;
	}
}

if($arParams['USE_POPUP_SCRIPTS'] == 'Y')
{
	if($arParams['MODAL_SCRIPTS_LIST'] == 'AM'){
		$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/arcticmodal/jquery.arcticmodal-0.3.min.js');
		//$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/arcticmodal/jquery.arcticmodal-0.3.css');
	} 
	elseif($arParams['MODAL_SCRIPTS_LIST'] == 'FB'){		
		$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/fancybox2/jquery.fancybox.pack.js');
		//$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/fancybox2/events.js');
		$APPLICATION->SetAdditionalCSS('/bitrix/components/ma/site.settings/fancybox2/jquery.fancybox.css');		
	}	
}
if($arParams['USE_TOP_SCROLL'] == "Y"){
	$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/js/up.js');
}

if($arParams['USE_MA_PLAGINS'] == "Y"){
	$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/js/ma_plagins.js');
}

// if($arParams['USE_POPUP_BASKET'] == 'Y') {
// 	include_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/components/ma/sale.basket.basket/get-basket-ajax.php');
// }
// if($arParams['USE_BASKET_SCRIPT'] == 'Y')
// {
// 	$APPLICATION->AddHeadScript('/bitrix/components/ma/catalog/templates/.default/script.js');
// }

$this->IncludeComponentTemplate();

?>