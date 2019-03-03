<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['SHIPMENT'] as $key => $shipment) {
	$deliveryName = 'Деловые линии';
	if (strpos($shipment["DELIVERY_NAME"], $deliveryName) !== false)  {
		$arResult['SHIPMENT'][$key]["DELIVERY_NAME"] = $deliveryName;
	}
}