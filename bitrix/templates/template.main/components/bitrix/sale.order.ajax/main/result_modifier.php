<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);


// foreach ($arResult["DELIVERY"] as $key => $arDelivery) {
// 	$deliveryName = 'Деловые линии';
// 	if (strpos($arDelivery["NAME"], $deliveryName) === false) continue;

// 	$arResult["DELIVERY"][$key]["NAME"] = trim(str_replace($arDelivery["OWN_NAME"], "", $arDelivery["NAME"]), '()');
// }