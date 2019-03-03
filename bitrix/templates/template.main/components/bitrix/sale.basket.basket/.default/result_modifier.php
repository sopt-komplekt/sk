<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;

$defaultParams = array(
	'TEMPLATE_THEME' => 'blue'
);
$arParams = array_merge($defaultParams, $arParams);
unset($defaultParams);

$arParams['TEMPLATE_THEME'] = (string)($arParams['TEMPLATE_THEME']);
if ('' != $arParams['TEMPLATE_THEME'])
{
	$arParams['TEMPLATE_THEME'] = preg_replace('/[^a-zA-Z0-9_\-\(\)\!]/', '', $arParams['TEMPLATE_THEME']);
	if ('site' == $arParams['TEMPLATE_THEME'])
	{
		$templateId = (string)Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', SITE_ID);
		$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? 'eshop_adapt' : $templateId;
		$arParams['TEMPLATE_THEME'] = (string)Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', SITE_ID);
	}
	if ('' != $arParams['TEMPLATE_THEME'])
	{
		if (!is_file($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
			$arParams['TEMPLATE_THEME'] = '';
	}
}
if ('' == $arParams['TEMPLATE_THEME'])
	$arParams['TEMPLATE_THEME'] = 'blue';


#--- show complect items ---
// file_put_contents(__DIR__.'/info.log', '');
$itemIdList = array();
$IBLOCK_ID = 5;// Комплексные решения
foreach ($arResult['ITEMS'] as $groupName => $productGroup) {
	foreach ($productGroup as $productId => $arProduct) {
		$itemIdList[] = $arProduct['PRODUCT_ID'];
	}
}

\Bitrix\Main\Loader::includeModule('iblock');
$rsElementList = \CIblockElement::getList(
	$order=array(),
	$filter=array(
		'ID' => $itemIdList,
		'IBLOCK_ID' => $IBLOCK_ID,
	),
	false, false,
	$select=array(
		'ID', 'IBLOCK_ID',
		'PROPERTY_LINKED_ITEMS',
	)
);
$arElementList = array();
while ($arElement = $rsElementList->Fetch()) {
	if ($arElement['ID'] <= 0) continue;

	$rsPropertyList = \CIBlockElement::GetProperty($IBLOCK_ID, $arElement['ID'], $order=array(), $filter=array('CODE' => 'LINKED_ITEMS'));
	$arPropertyList = array();
	while ($arProperty = $rsPropertyList->Fetch()) {
		$arPropertyList[] = array('VALUE' => $arProperty['VALUE'], 'DESCRIPTION' => $arProperty['DESCRIPTION']);
	}

	$linkItems = array();
	foreach ($arPropertyList as $arProperty) {
		$rsElement = \CIBlockElement::GetList(
			$order=array(),
			$filter=array(
				'ID' => $arProperty['VALUE'],
			),
			false, false//,
			// $select=array(
			// 	'ID', 'IBLOCK_ID',
			// 	'PROPERTY_LINKED_ITEMS',
			// )
		);
		if ($arLinkedItem = $rsElement->GetNext()) {
			$linkItems[] = array('ITEM' => $arLinkedItem, 'QYANTITY' => $arProperty['DESCRIPTION']);
		}
	}

	$arElementList[$arElement['ID']]['LINKED_ITEMS'] = $linkItems;
}

// $linkedItemHtml = <<<HTML
// 	<span data-entity="basket-item-name">#NAME#, #QTY# шт.</span>
// HTML;

foreach ($arResult['ITEMS'] as $groupName => $productGroup) {
	foreach ($productGroup as $productId => $arProduct) {
		// if (in_array($arProduct['PRODUCT_ID'], array_keys($arElementList))) {
		// 	$arResult['ITEMS'][$groupName][$productId]['LINKED_ITEMS'] = $arElementList[$arProduct['PRODUCT_ID']]['LINKED_ITEMS'];
		// 	$html = '<div class="basket-item-linked-items">';
		// 	foreach ($arElementList[$arProduct['PRODUCT_ID']]['LINKED_ITEMS'] as $arLinkedItem) {
		// 		$html .= str_replace(array('#NAME#', '#QTY#'), array($arLinkedItem['ITEM']['NAME'], $arLinkedItem['QYANTITY']), $linkedItemHtml);
		// 	}
		// 	$html .= '</div>';
		// 	$arResult['ITEMS'][$groupName][$productId]['LINKED_ITEMS_HTML'] = $arElementList[$arProduct['PRODUCT_ID']]['LINKED_ITEMS_HTML'];
		// }

		foreach ($arProduct['PROPERTY_LINKED_ITEMS_VALUE_LINK'] as $indx => $value) {
			$value = str_replace('<a ', '<a class="g-decorated-link"', $value);
			$arResult['ITEMS'][$groupName][$productId]['PROPERTY_LINKED_ITEMS_VALUE_LINK'][$indx] = '•&nbsp;'.$value;
		}
	}
}

foreach ($arResult['BASKET_ITEM_RENDER_DATA'] as $indx => $basketItem) {
	foreach ($basketItem['COLUMN_LIST'] as $indx2 => $column) {
		$first = true;
		foreach ($column['VALUE'] as $indx3 => $value) {
			$arElementList_ = array_filter($arElementList[$basketItem['PRODUCT_ID']]['LINKED_ITEMS'], function($arItem) use ($value) {
				return (strpos($value['LINK'], $arItem['ITEM']['DETAIL_PAGE_URL']) !== false);
			});

			if (is_array($arElementList_) && 0 < count($arElementList_)) {
				$qty = reset($arElementList_);
				$qty = $qty['QYANTITY'];
			}
			$value = str_replace(array('<a ', '">', '</a>'), array('<a class="g-decorated-link"', '"><span>', '</span></a>'), $value);
			$arResult['BASKET_ITEM_RENDER_DATA'][$indx]['COLUMN_LIST'][$indx2]['VALUE'][$indx3]['LINK'] = '<span class="basket-item-property-bullet">—</span>&nbsp;'.$value['LINK'].', '.$qty.' шт.';
		}
	}
}
