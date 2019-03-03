<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

dump($arResult['SHIPMENT']);
foreach ($arResult['SHIPMENT'] as $key => $shipment) {
	$deliveryName = 'Деловые линии';
	if (strpos($shipment["DELIVERY_NAME"], $deliveryName) === false) continue;

	$arResult['SHIPMENT'][$key]["DELIVERY_NAME"] = $deliveryName;
}