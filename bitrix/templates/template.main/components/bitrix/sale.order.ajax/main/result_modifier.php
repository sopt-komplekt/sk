<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);
global $USER;
$userArr = $USER->GetByID($USER->GetID())->Fetch();

if($userArr['WORK_COMPANY'] !== '' && $userArr['UF_INN'] !== ''){
    foreach($arResult["JS_DATA"]['ORDER_PROP']['properties'] as &$value){

        switch($value['CODE']){
            case 'COMPANY': $value['VALUE'][0] = $userArr["WORK_COMPANY"];break;
            case 'INN': $value['VALUE'][0] = $userArr["UF_INN"];break;
            case 'KPP': $value['VALUE'][0] = $userArr["UF_KPP"];break;
            case 'COMPANY_ADR': $value['VALUE'][0] = implode(", ", [$userArr["WORK_ZIP"], $userArr["WORK_CITY"], $userArr["WORK_STREET"]]);break;
            case 'CONTACT_PERSON': $value['VALUE'][0] = implode(" ", [$userArr["LAST_NAME"], $userArr["NAME"]]);break;
            case 'EMAIL': $value['VALUE'][0] = $userArr["EMAIL"];break;
            case 'PHONE': $value['VALUE'][0] = $userArr["PERSONAL_PHONE"];break;
        }

    }
}


// foreach ($arResult["DELIVERY"] as $key => $arDelivery) {
// 	$deliveryName = 'Деловые линии';
// 	if (strpos($arDelivery["NAME"], $deliveryName) === false) continue;

// 	$arResult["DELIVERY"][$key]["NAME"] = trim(str_replace($arDelivery["OWN_NAME"], "", $arDelivery["NAME"]), '()');
// }