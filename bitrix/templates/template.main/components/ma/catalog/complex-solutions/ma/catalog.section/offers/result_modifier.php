<? 
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arDefaultParams = array(
	'TEMPLATE_THEME' => 'blue',
	'PRODUCT_DISPLAY_MODE' => 'N',
	'ADD_PICT_PROP' => '-',
	'LABEL_PROP' => '-',
	'OFFER_ADD_PICT_PROP' => '-',
	'OFFER_TREE_PROPS' => array('-'),
	'PRODUCT_SUBSCRIPTION' => 'N',
	'SHOW_DISCOUNT_PERCENT' => 'N',
	'SHOW_OLD_PRICE' => 'N',
	'ADD_TO_BASKET_ACTION' => 'ADD',
	'SHOW_CLOSE_POPUP' => 'N',
	'MESS_BTN_BUY' => '',
	'MESS_BTN_ADD_TO_BASKET' => '',
	'MESS_BTN_SUBSCRIBE' => '',
	'MESS_BTN_DETAIL' => '',
	'MESS_NOT_AVAILABLE' => '',
	'MESS_BTN_COMPARE' => ''
);
$arParams = array_merge($arDefaultParams, $arParams);

if (!isset($arParams['LINE_ELEMENT_COUNT'])) {
	$arParams['LINE_ELEMENT_COUNT'] = 3;
}
$arParams['LINE_ELEMENT_COUNT'] = intval($arParams['LINE_ELEMENT_COUNT']);
if ($arParams['LINE_ELEMENT_COUNT']  < 2 || $arParams['LINE_ELEMENT_COUNT'] > 5) {
	$arParams['LINE_ELEMENT_COUNT'] = 3;
}

$arResult['NAV_STRING'] = $arResult['NAV_RESULT']->GetPageNavStringEx(
	$navComponentObject,
	$arParams['PAGER_TITLE'],
	$arParams['PAGER_TEMPLATE'],
	$arParams['PAGER_SHOW_ALWAYS'],
	$this->__component,
	$arResult['NAV_PARAM']
);

if ($arParams['PRODUCT_DISPLAY_MODE'] != 'Y')
	$arParams['PRODUCT_DISPLAY_MODE'] = 'N';

$arParams['ADD_PICT_PROP'] = trim($arParams['ADD_PICT_PROP']);
if ('-' == $arParams['ADD_PICT_PROP'])
	$arParams['ADD_PICT_PROP'] = '';
$arParams['LABEL_PROP'] = trim($arParams['LABEL_PROP']);
if ('-' == $arParams['LABEL_PROP'])
	$arParams['LABEL_PROP'] = '';
$arParams['OFFER_ADD_PICT_PROP'] = trim($arParams['OFFER_ADD_PICT_PROP']);
if ('-' == $arParams['OFFER_ADD_PICT_PROP'])
	$arParams['OFFER_ADD_PICT_PROP'] = '';
if ('Y' == $arParams['PRODUCT_DISPLAY_MODE'])
{
	if (!is_array($arParams['OFFER_TREE_PROPS']))
		$arParams['OFFER_TREE_PROPS'] = array($arParams['OFFER_TREE_PROPS']);
	foreach ($arParams['OFFER_TREE_PROPS'] as $key => $value)
	{
		$value = (string)$value;
		if ('' == $value || '-' == $value)
			unset($arParams['OFFER_TREE_PROPS'][$key]);
	}
	if (empty($arParams['OFFER_TREE_PROPS']) && isset($arParams['OFFERS_CART_PROPERTIES']) && is_array($arParams['OFFERS_CART_PROPERTIES']))
	{
		$arParams['OFFER_TREE_PROPS'] = $arParams['OFFERS_CART_PROPERTIES'];
		foreach ($arParams['OFFER_TREE_PROPS'] as $key => $value)
		{
			$value = (string)$value;
			if ('' == $value || '-' == $value)
				unset($arParams['OFFER_TREE_PROPS'][$key]);
		}
	}
}
else
{
	$arParams['OFFER_TREE_PROPS'] = array();
}
if ($arParams['PRODUCT_SUBSCRIPTION'] != 'Y') {
	$arParams['PRODUCT_SUBSCRIPTION'] = 'N';
}
if ($arParams['SHOW_DISCOUNT_PERCENT'] != 'Y') {
	$arParams['SHOW_DISCOUNT_PERCENT'] = 'N';
}
if ($arParams['SHOW_OLD_PRICE'] != 'Y') {
	$arParams['SHOW_OLD_PRICE'] = 'N';
}
if ($arParams['ADD_TO_BASKET_ACTION'] != 'BUY') {
	$arParams['ADD_TO_BASKET_ACTION'] = 'ADD';
}
if ($arParams['SHOW_CLOSE_POPUP'] != 'Y') {
	$arParams['SHOW_CLOSE_POPUP'] = 'N';
}
$arParams['MESS_BTN_BUY'] = trim($arParams['MESS_BTN_BUY']);
$arParams['MESS_BTN_ADD_TO_BASKET'] = trim($arParams['MESS_BTN_ADD_TO_BASKET']);
$arParams['MESS_BTN_SUBSCRIBE'] = trim($arParams['MESS_BTN_SUBSCRIBE']);
$arParams['MESS_BTN_DETAIL'] = trim($arParams['MESS_BTN_DETAIL']);
$arParams['MESS_NOT_AVAILABLE'] = trim($arParams['MESS_NOT_AVAILABLE']);
$arParams['MESS_BTN_COMPARE'] = trim($arParams['MESS_BTN_COMPARE']);

if($arParams['RESIZE_IMAGE'] == 1) {
	$arParams['RESIZE_IMAGE'] = BX_RESIZE_IMAGE_EXACT;
}
elseif($arParams['RESIZE_IMAGE'] == 2) {
	$arParams['RESIZE_IMAGE'] = BX_RESIZE_IMAGE_PROPORTIONAL;
}
elseif($arParams['RESIZE_IMAGE'] == 3) {
	$arParams['RESIZE_IMAGE'] = BX_RESIZE_IMAGE_PROPORTIONAL_ALT;
}
else {
	$arParams['RESIZE_IMAGE'] = BX_RESIZE_IMAGE_PROPORTIONAL;
}

if($arParams["DISPLAY_IMG_WIDTH"] <= 0) {
	$arParams["DISPLAY_IMG_WIDTH"] = 100;
}
if($arParams["DISPLAY_IMG_HEIGHT"] <= 0) {
	$arParams["DISPLAY_IMG_HEIGHT"] = 100;
}

$arFilter = '';
if($arParams["SHARPEN"] != 0) {
	$arFilter = array(array("name" => "sharpen", "precision" => $arParams["SHARPEN"]));
}

if (!empty($arResult['ITEMS']))
{
	$arEmptyPreview = false;
	$strEmptyPreview = $this->GetFolder().'/images/no_photo@1x.png';
	if (file_exists($_SERVER['DOCUMENT_ROOT'].$strEmptyPreview))
	{
		$arSizes = getimagesize($_SERVER['DOCUMENT_ROOT'].$strEmptyPreview);
		if (!empty($arSizes))
		{
			$arEmptyPreview = array(
				'SRC' => $strEmptyPreview,
				'WIDTH' => intval($arSizes[0]),
				'HEIGHT' => intval($arSizes[1])
			);
		}
		unset($arSizes);
	}
	unset($strEmptyPreview);

	$arSKUPropList = array();
	$arSKUPropIDs = array();
	$arSKUPropKeys = array();
	$boolSKU = false;
	$strBaseCurrency = '';
	$boolConvert = isset($arResult['CONVERT_CURRENCY']['CURRENCY_ID']);

	if ($arResult['MODULES']['catalog'])
	{
		if (!$boolConvert)
			$strBaseCurrency = CCurrency::GetBaseCurrency();

		$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
		$boolSKU = !empty($arSKU) && is_array($arSKU);
		if ($boolSKU && !empty($arParams['OFFER_TREE_PROPS']) && 'Y' == $arParams['PRODUCT_DISPLAY_MODE'])
		{
			$arSKUPropList = CIBlockPriceTools::getTreeProperties(
				$arSKU,
				$arParams['OFFER_TREE_PROPS'],
				array(
					'PICT' => $arEmptyPreview,
					'NAME' => '-'
				)
			);

			$arNeedValues = array();
			CIBlockPriceTools::getTreePropertyValues($arSKUPropList, $arNeedValues);
			$arSKUPropIDs = array_keys($arSKUPropList);
			if (empty($arSKUPropIDs))
				$arParams['PRODUCT_DISPLAY_MODE'] = 'N';
			else
				$arSKUPropKeys = array_fill_keys($arSKUPropIDs, false);
		}
	}

	
	$arNewItemsList = array();
	
	foreach ($arResult['ITEMS'] as $key => $arItem) 
	{
		$arItem['CHECK_QUANTITY'] = false;
		if (!isset($arItem['CATALOG_MEASURE_RATIO'])) {
			$arItem['CATALOG_MEASURE_RATIO'] = 1;
		}
		if (!isset($arItem['CATALOG_QUANTITY'])) {
			$arItem['CATALOG_QUANTITY'] = 0;
		}
		$arItem['CATALOG_QUANTITY'] = (
			0 < $arItem['CATALOG_QUANTITY'] && is_float($arItem['CATALOG_MEASURE_RATIO'])
			? floatval($arItem['CATALOG_QUANTITY'])
			: intval($arItem['CATALOG_QUANTITY'])
		);
		$arItem['CATALOG'] = false;
		if (!isset($arItem['CATALOG_SUBSCRIPTION']) || 'Y' != $arItem['CATALOG_SUBSCRIPTION']) {
			$arItem['CATALOG_SUBSCRIPTION'] = 'N';
		}

		CIBlockPriceTools::getLabel($arItem, $arParams['LABEL_PROP']);

		// $productPictures = CIBlockPriceTools::getDoublePicturesForItem($arItem, $arParams['ADD_PICT_PROP']);
		// if (empty($productPictures['PICT'])) 
		// 	$productPictures['PICT'] = $arEmptyPreview;
		// if (empty($productPictures['SECOND_PICT']))
		// 	$productPictures['SECOND_PICT'] = $productPictures['PICT'];

		// $arItem['PREVIEW_PICTURE'] = $productPictures['PICT'];
		// $arItem['PREVIEW_PICTURE_SECOND'] = $productPictures['SECOND_PICT'];
		// $arItem['SECOND_PICT'] = true;
		$arItem['SECOND_PICT'] = false;
		// $arItem['PRODUCT_PREVIEW'] = $productPictures['PICT'];
		// $arItem['PRODUCT_PREVIEW_SECOND'] = $productPictures['SECOND_PICT'];

		if(empty($arItem["PREVIEW_PICTURE"]) && is_array($arItem["DETAIL_PICTURE"])) {
			$arItem["PREVIEW_PICTURE"] = $arItem["DETAIL_PICTURE"];
		}

		if(is_array($arItem["PREVIEW_PICTURE"]))
		{
			$arFileTmp = CFile::ResizeImageGet(
				$arItem["PREVIEW_PICTURE"],
				array("width" => $arParams["DISPLAY_IMG_WIDTH"], "height" => $arParams["DISPLAY_IMG_HEIGHT"]),
				$arParams['RESIZE_IMAGE'],
				true, 
				$arFilter
			);
			$arItem['PREVIEW_PICTURE']['SRC'] = $arFileTmp["src"];
			$arItem['PREVIEW_PICTURE']['WIDTH'] = $arFileTmp["width"];
			$arItem['PREVIEW_PICTURE']['HEIGHT'] = $arFileTmp["height"];
		}

		if ($arResult['MODULES']['catalog'])
		{
			$arItem['CATALOG'] = true;
			if (!isset($arItem['CATALOG_TYPE']))
				$arItem['CATALOG_TYPE'] = CCatalogProduct::TYPE_PRODUCT;
			if (
				(CCatalogProduct::TYPE_PRODUCT == $arItem['CATALOG_TYPE'] || CCatalogProduct::TYPE_SKU == $arItem['CATALOG_TYPE'])
				&& !empty($arItem['OFFERS'])
			)
			{
				$arItem['CATALOG_TYPE'] = CCatalogProduct::TYPE_SKU;
			}
			switch ($arItem['CATALOG_TYPE'])
			{
				case CCatalogProduct::TYPE_SET:
					$arItem['OFFERS'] = array();
					$arItem['CHECK_QUANTITY'] = ('Y' == $arItem['CATALOG_QUANTITY_TRACE'] && 'N' == $arItem['CATALOG_CAN_BUY_ZERO']);
					break;
				case CCatalogProduct::TYPE_SKU:
					break;
				case CCatalogProduct::TYPE_PRODUCT:
				default:
					$arItem['CHECK_QUANTITY'] = ('Y' == $arItem['CATALOG_QUANTITY_TRACE'] && 'N' == $arItem['CATALOG_CAN_BUY_ZERO']);
					break;
			}
		}
		else
		{
			$arItem['CATALOG_TYPE'] = 0;
			$arItem['OFFERS'] = array();
		}

		if ($arItem['CATALOG'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
		{
			if ($arParams['PRODUCT_DISPLAY_MODE'] == 'Y')
			{
				$arMatrixFields = $arSKUPropKeys;
				$arMatrix = array();

				$arNewOffers = array();
				$boolSKUDisplayProperties = false;
				$arItem['OFFERS_PROP'] = false;
				$arItem['SKU_TREE_VALUES'] = array();

				$arDouble = array();
				foreach ($arItem['OFFERS'] as $keyOffer => $arOffer)
				{
					$arOffer['ID'] = (int)$arOffer['ID'];
					if (isset($arDouble[$arOffer['ID']]))
						continue;
					$arRow = array();
					foreach ($arSKUPropIDs as $propkey => $strOneCode)
					{
						$arCell = array(
							'VALUE' => 0,
							'SORT' => PHP_INT_MAX,
							'NA' => true
						);
						if (isset($arOffer['DISPLAY_PROPERTIES'][$strOneCode]))
						{
							$arMatrixFields[$strOneCode] = true;
							$arCell['NA'] = false;
							if ('directory' == $arSKUPropList[$strOneCode]['USER_TYPE'])
							{
								$intValue = $arSKUPropList[$strOneCode]['XML_MAP'][$arOffer['DISPLAY_PROPERTIES'][$strOneCode]['VALUE']];
								$arCell['VALUE'] = $intValue;
							}
							elseif ('L' == $arSKUPropList[$strOneCode]['PROPERTY_TYPE'])
							{
								$arCell['VALUE'] = intval($arOffer['DISPLAY_PROPERTIES'][$strOneCode]['VALUE_ENUM_ID']);
							}
							elseif ('E' == $arSKUPropList[$strOneCode]['PROPERTY_TYPE'])
							{
								$arCell['VALUE'] = intval($arOffer['DISPLAY_PROPERTIES'][$strOneCode]['VALUE']);
							}
							$arCell['SORT'] = $arSKUPropList[$strOneCode]['VALUES'][$arCell['VALUE']]['SORT'];
						}
						$arRow[$strOneCode] = $arCell;
					}
					$arMatrix[$keyOffer] = $arRow;
					unset($arRow);

					CIBlockPriceTools::clearProperties($arOffer['DISPLAY_PROPERTIES'], $arParams['OFFER_TREE_PROPS']);

					CIBlockPriceTools::setRatioMinPrice($arOffer, false);

					// $arOfferPictures = CIBlockPriceTools::getDoublePicturesForItem($arOffer, $arParams['OFFER_ADD_PICT_PROP']);
					// $arOffer['OWNER_PICT'] = empty($arOfferPictures['PICT']);
					// $arOffer['PREVIEW_PICTURE'] = false;
					// $arOffer['PREVIEW_PICTURE_SECOND'] = false;
					// $arOffer['SECOND_PICT'] = true;
					$arOffer['SECOND_PICT'] = false;

					// if (!$arOffer['OWNER_PICT'])
					// {
						// if (empty($arOfferPictures['SECOND_PICT'])) {
						// 	$arOfferPictures['SECOND_PICT'] = $arOfferPictures['PICT'];
						// }
						// $arOffer['PREVIEW_PICTURE'] = $arOfferPictures['PICT'];
						// $arOffer['PREVIEW_PICTURE_SECOND'] = $arOfferPictures['SECOND_PICT'];
					// }

					if(empty($arOffer["PREVIEW_PICTURE"]) && is_array($arOffer["DETAIL_PICTURE"])) {
						$arOffer['PREVIEW_PICTURE'] = $arOffer["DETAIL_PICTURE"];
					}

					if(is_array($arOffer['PREVIEW_PICTURE']))
					{
						$arFileTmp = CFile::ResizeImageGet(
							$arOffer['PREVIEW_PICTURE'],
							array("width" => $arParams["DISPLAY_IMG_WIDTH"], "height" => $arParams["DISPLAY_IMG_HEIGHT"]),
							$arParams['RESIZE_IMAGE'],
							true, 
							$arFilter
						);
						$arOffer['PREVIEW_PICTURE']['SRC'] = $arFileTmp["src"];
						$arOffer['PREVIEW_PICTURE']['WIDTH'] = $arFileTmp["width"];
						$arOffer['PREVIEW_PICTURE']['HEIGHT'] = $arFileTmp["height"];
					}

					if ('' != $arParams['OFFER_ADD_PICT_PROP'] && isset($arOffer['DISPLAY_PROPERTIES'][$arParams['OFFER_ADD_PICT_PROP']]))
						unset($arOffer['DISPLAY_PROPERTIES'][$arParams['OFFER_ADD_PICT_PROP']]);

					$arDouble[$arOffer['ID']] = true;
					$arNewOffers[$keyOffer] = $arOffer;
				}
				unset($keyOffer, $arOffer);
				$arItem['OFFERS'] = $arNewOffers;

				$arUsedFields = array();
				$arSortFields = array();

				$matrixKeys = array_keys($arMatrix);
				foreach ($arSKUPropIDs as $propkey => $propCode)
				{
					$boolExist = $arMatrixFields[$propCode];
					foreach ($matrixKeys as $keyOffer)
					{
						if ($boolExist)
						{
							if (!isset($arItem['OFFERS'][$keyOffer]['TREE']))
								$arItem['OFFERS'][$keyOffer]['TREE'] = array();
							$propId = $arSKUPropList[$propCode]['ID'];
							$value = $arMatrix[$keyOffer][$propCode]['VALUE'];
							if (!isset($arItem['SKU_TREE_VALUES'][$propId]))
								$arItem['SKU_TREE_VALUES'][$propId] = array();
							$arItem['SKU_TREE_VALUES'][$propId][$value] = true;
							$arItem['OFFERS'][$keyOffer]['TREE']['PROP_'.$propId] = $value;
							$arItem['OFFERS'][$keyOffer]['SKU_SORT_'.$propCode] = $arMatrix[$keyOffer][$propCode]['SORT'];
							$arUsedFields[$propCode] = true;
							$arSortFields['SKU_SORT_'.$propCode] = SORT_NUMERIC;
							unset($value, $propId);
						}
						else
						{
							unset($arMatrix[$keyOffer][$propCode]);
						}
					}
					unset($keyOffer);
				}
				unset($propkey, $propCode);
				unset($matrixKeys);
				$arItem['OFFERS_PROP'] = $arUsedFields;
				$arItem['OFFERS_PROP_CODES'] = (!empty($arUsedFields) ? base64_encode(serialize(array_keys($arUsedFields))) : '');

				Collection::sortByColumn($arItem['OFFERS'], $arSortFields);

				$arMatrix = array();
				$intSelected = -1;
				$arItem['MIN_PRICE'] = false;
				$arItem['MIN_BASIS_PRICE'] = false;
				foreach ($arItem['OFFERS'] as $keyOffer => $arOffer)
				{

					// Ссылка на добавление в корзину
					$arItem['OFFERS']['ADD_TO_BASKET_URL'] = $arParams['SEF_FOLDER'].'add-to-basket/?action=add&id='.$arOffer['ID'];
					
					if (empty($arItem['MIN_PRICE']))
					{
						if ($arItem['OFFER_ID_SELECTED'] > 0)
							$foundOffer = ($arItem['OFFER_ID_SELECTED'] == $arOffer['ID']);
						else
							$foundOffer = $arOffer['CAN_BUY'];
						if ($foundOffer)
						{
							$intSelected = $keyOffer;
							$arItem['MIN_PRICE'] = (isset($arOffer['RATIO_PRICE']) ? $arOffer['RATIO_PRICE'] : $arOffer['MIN_PRICE']);
							$arItem['MIN_BASIS_PRICE'] = $arOffer['MIN_PRICE'];
						}
						unset($foundOffer);
					}

					$arSKUProps = false;
					if (!empty($arOffer['DISPLAY_PROPERTIES']))
					{
						$boolSKUDisplayProperties = true;
						$arSKUProps = array();
						foreach ($arOffer['DISPLAY_PROPERTIES'] as &$arOneProp)
						{
							if ('F' == $arOneProp['PROPERTY_TYPE'])
								continue;
							$arSKUProps[] = array(
								'NAME' => $arOneProp['NAME'],
								'VALUE' => $arOneProp['DISPLAY_VALUE']
							);
						}
						unset($arOneProp);
					}

					$arOneRow = array(
						'ID' => $arOffer['ID'],
						'NAME' => $arOffer['~NAME'],
						'TREE' => $arOffer['TREE'],
						'DISPLAY_PROPERTIES' => $arSKUProps,
						'PRICE' => (isset($arOffer['RATIO_PRICE']) ? $arOffer['RATIO_PRICE'] : $arOffer['MIN_PRICE']),
						'BASIS_PRICE' => $arOffer['MIN_PRICE'],
						'SECOND_PICT' => $arOffer['SECOND_PICT'],
						'OWNER_PICT' => $arOffer['OWNER_PICT'],
						'PREVIEW_PICTURE' => $arOffer['PREVIEW_PICTURE'],
						'PREVIEW_PICTURE_SECOND' => $arOffer['PREVIEW_PICTURE_SECOND'],
						'CHECK_QUANTITY' => $arOffer['CHECK_QUANTITY'],
						'MAX_QUANTITY' => $arOffer['CATALOG_QUANTITY'],
						'STEP_QUANTITY' => $arOffer['CATALOG_MEASURE_RATIO'],
						'QUANTITY_FLOAT' => is_double($arOffer['CATALOG_MEASURE_RATIO']),
						'MEASURE' => $arOffer['~CATALOG_MEASURE_NAME'],
						'CAN_BUY' => $arOffer['CAN_BUY'],
					);
					$arMatrix[$keyOffer] = $arOneRow;
				}
				if (-1 == $intSelected)
				{
					$intSelected = 0;
					$arItem['MIN_PRICE'] = (isset($arItem['OFFERS'][0]['RATIO_PRICE']) ? $arItem['OFFERS'][0]['RATIO_PRICE'] : $arItem['OFFERS'][0]['MIN_PRICE']);
					$arItem['MIN_BASIS_PRICE'] = $arItem['OFFERS'][0]['MIN_PRICE'];
				}
				if (!$arMatrix[$intSelected]['OWNER_PICT'])
				{
					$arItem['PREVIEW_PICTURE'] = $arMatrix[$intSelected]['PREVIEW_PICTURE'];
					// $arItem['PREVIEW_PICTURE_SECOND'] = $arMatrix[$intSelected]['PREVIEW_PICTURE_SECOND'];
				}
				$arItem['JS_OFFERS'] = $arMatrix;
				$arItem['OFFERS_SELECTED'] = $intSelected;
				$arItem['OFFERS_PROPS_DISPLAY'] = $boolSKUDisplayProperties;
			}
			else
			{
				$arItem['MIN_PRICE'] = CIBlockPriceTools::getMinPriceFromOffers(
					$arItem['OFFERS'],
					$boolConvert ? $arResult['CONVERT_CURRENCY']['CURRENCY_ID'] : $strBaseCurrency
				);
			}
		}

		if (
			$arResult['MODULES']['catalog']
			&& $arItem['CATALOG']
			&&
				($arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_PRODUCT
				|| $arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_SET)
		)
		{
			CIBlockPriceTools::setRatioMinPrice($arItem, false);
			$arItem['MIN_BASIS_PRICE'] = $arItem['MIN_PRICE'];
		}

		if (!empty($arItem['DISPLAY_PROPERTIES']))
		{
			foreach ($arItem['DISPLAY_PROPERTIES'] as $propKey => $arDispProp)
			{
				if ('F' == $arDispProp['PROPERTY_TYPE'])
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
			}
		}
		$arItem['LAST_ELEMENT'] = 'N';

		// Ссылка на добавление в корзину
		$arItem['ADD_TO_BASKET_URL'] = $arParams['SEF_FOLDER'].'add-to-basket/?action=add&id='.$arItem['ID'];

		// Ссылка на добавление в сравнение
		$arItem['ADD_TO_COMPARE_URL'] = $arParams['SEF_FOLDER'].'add-to-compare/?action=ADD_TO_COMPARE_LIST&id='.$arItem['ID'];

		// Ссылка на добавление и удаление из избранного
		$arItem['ADD_TO_FAVORITE_URL'] = $arParams['SEF_FOLDER'].'add-to-favorite/?action=add&id='.$arItem['ID'];
		$arItem['DEL_FROM_FAVORITE_URL'] = $arParams['SEF_FOLDER'].'favorite/?action=del&id='.$arItem['ID'];

		$arNewItemsList[$key] = $arItem;	
	}


	$arNewItemsList[$key]['LAST_ELEMENT'] = 'Y';
	$arResult['ITEMS'] = $arNewItemsList;
	$arResult['SKU_PROPS'] = $arSKUPropList;
	$arResult['DEFAULT_PICTURE'] = $arEmptyPreview;

	$arResult['CURRENCIES'] = array();
	if ($arResult['MODULES']['currency'])
	{
		if ($boolConvert)
		{
			$currencyFormat = CCurrencyLang::GetFormatDescription($arResult['CONVERT_CURRENCY']['CURRENCY_ID']);
			$arResult['CURRENCIES'] = array(
				array(
					'CURRENCY' => $arResult['CONVERT_CURRENCY']['CURRENCY_ID'],
					'FORMAT' => array(
						'FORMAT_STRING' => $currencyFormat['FORMAT_STRING'],
						'DEC_POINT' => $currencyFormat['DEC_POINT'],
						'THOUSANDS_SEP' => $currencyFormat['THOUSANDS_SEP'],
						'DECIMALS' => $currencyFormat['DECIMALS'],
						'THOUSANDS_VARIANT' => $currencyFormat['THOUSANDS_VARIANT'],
						'HIDE_ZERO' => $currencyFormat['HIDE_ZERO']
					)
				)
			);
			unset($currencyFormat);
		}
		else
		{
			$currencyIterator = CurrencyTable::getList(array(
				'select' => array('CURRENCY')
			));
			while ($currency = $currencyIterator->fetch())
			{
				$currencyFormat = CCurrencyLang::GetFormatDescription($currency['CURRENCY']);
				$arResult['CURRENCIES'][] = array(
					'CURRENCY' => $currency['CURRENCY'],
					'FORMAT' => array(
						'FORMAT_STRING' => $currencyFormat['FORMAT_STRING'],
						'DEC_POINT' => $currencyFormat['DEC_POINT'],
						'THOUSANDS_SEP' => $currencyFormat['THOUSANDS_SEP'],
						'DECIMALS' => $currencyFormat['DECIMALS'],
						'THOUSANDS_VARIANT' => $currencyFormat['THOUSANDS_VARIANT'],
						'HIDE_ZERO' => $currencyFormat['HIDE_ZERO']
					)
				);
			}
			unset($currencyFormat, $currency, $currencyIterator);
		}
	}
}