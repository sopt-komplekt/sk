<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */
/** @global CUserTypeManager $USER_FIELD_MANAGER */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Iblock;
use Bitrix\Currency;

global $USER_FIELD_MANAGER;

if (!Loader::includeModule('iblock'))
	return;

// Получение шаблонов 
$exclude_list = array('.','..');

$arSectionListTemplates = array();
$path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/ma/catalog.section.list/templates/';
$arDir = array_diff(scandir($path), $exclude_list);
foreach ($arDir as $key => $name) {
	if(is_dir($path.$name)){
		$arSectionListTemplates[$name] = $name;
	}
}

$arSmartFilterTemplates = array();
$path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/ma/catalog.smart.filter/templates/';
$arDir = array_diff(scandir($path), $exclude_list);
foreach ($arDir as $key => $name) {
	if(is_dir($path.$name)){
		$arSmartFilterTemplates[$name] = $name;
	}
}

$arElementListTemplates = array();
$path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/ma/catalog.section/templates/';
$arDir = array_diff(scandir($path), $exclude_list);
foreach ($arDir as $key => $name) {
	if(is_dir($path.$name)){
		$arElementListTemplates[$name] = $name;
	}
}

$arElementDetailTemplates = array();
$path = $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/ma/catalog.element/templates/';
$arDir = array_diff(scandir($path), $exclude_list);
foreach ($arDir as $key => $name) {
	if(is_dir($path.$name)){
		$arElementDetailTemplates[$name] = $name;
	}
}

$catalogIncluded = Loader::includeModule('catalog');
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$iblockFilter = (
	!empty($arCurrentValues['IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y')
);
$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
while ($arr = $rsIBlock->Fetch())
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
unset($arr, $rsIBlock, $iblockFilter);

$arProperty = array();
$arProperty_N = array();
$arProperty_X = array();
$arProperty_F = array();
if ($iblockExists)
{
	$propertyIterator = Iblock\PropertyTable::getList(array(
		'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE'),
		'filter' => array('=IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], '=ACTIVE' => 'Y'),
		'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
	));
	while ($property = $propertyIterator->fetch())
	{
		$propertyCode = (string)$property['CODE'];
		if ($propertyCode == '')
			$propertyCode = $property['ID'];
		$propertyName = '['.$propertyCode.'] '.$property['NAME'];

		if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
		{
			$arProperty[$propertyCode] = $propertyName;

			if ($property['MULTIPLE'] == 'Y')
				$arProperty_X[$propertyCode] = $propertyName;
			elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_LIST)
				$arProperty_X[$propertyCode] = $propertyName;
			elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_ELEMENT && (int)$property['LINK_IBLOCK_ID'] > 0)
				$arProperty_X[$propertyCode] = $propertyName;
		}
		else
		{
			if ($property['MULTIPLE'] == 'N')
				$arProperty_F[$propertyCode] = $propertyName;
		}

		if ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_NUMBER)
			$arProperty_N[$propertyCode] = $propertyName;
	}
	unset($propertyCode, $propertyName, $property, $propertyIterator);
}
$arProperty_LNS = $arProperty;

$arIBlock_LINK = array();
$iblockFilter = (
	!empty($arCurrentValues['LINK_IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['LINK_IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y')
);
$rsIblock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
while ($arr = $rsIblock->Fetch())
	$arIBlock_LINK[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
unset($iblockFilter);

$arProperty_LINK = array();
if (!empty($arCurrentValues['LINK_IBLOCK_ID']) && (int)$arCurrentValues['LINK_IBLOCK_ID'] > 0)
{
	$propertyIterator = Iblock\PropertyTable::getList(array(
		'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE'),
		'filter' => array('=IBLOCK_ID' => $arCurrentValues['LINK_IBLOCK_ID'], '=PROPERTY_TYPE' => Iblock\PropertyTable::TYPE_ELEMENT, '=ACTIVE' => 'Y'),
		'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
	));
	while ($property = $propertyIterator->fetch())
	{
		$propertyCode = (string)$property['CODE'];
		if ($propertyCode == '')
			$propertyCode = $property['ID'];
		$arProperty_LINK[$propertyCode] = '['.$propertyCode.'] '.$property['NAME'];
	}
	unset($propertyCode, $property, $propertyIterator);
}

$arUserFields_S = array("-"=>" ");
$arUserFields_F = array("-"=>" ");
if ($iblockExists)
{
	$arUserFields = $USER_FIELD_MANAGER->GetUserFields('IBLOCK_'.$arCurrentValues['IBLOCK_ID'].'_SECTION', 0, LANGUAGE_ID);
	foreach ($arUserFields as $FIELD_NAME => $arUserField)
	{
		$arUserField['LIST_COLUMN_LABEL'] = (string)$arUserField['LIST_COLUMN_LABEL'];
		$arProperty_UF[$FIELD_NAME] = $arUserField['LIST_COLUMN_LABEL'] ? '['.$FIELD_NAME.']'.$arUserField['LIST_COLUMN_LABEL'] : $FIELD_NAME;
		if ($arUserField["USER_TYPE"]["BASE_TYPE"] == "string")
			$arUserFields_S[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
		if ($arUserField["USER_TYPE"]["BASE_TYPE"] == "file" && $arUserField['MULTIPLE'] == 'N')
			$arUserFields_F[$FIELD_NAME] = $arProperty_UF[$FIELD_NAME];
	}
	unset($arUserFields);
}

$offers = false;
$arProperty_Offers = array();
$arProperty_OffersWithoutFile = array();
if ($catalogIncluded && $iblockExists)
{
	$offers = CCatalogSKU::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	if (!empty($offers))
	{
		$propertyIterator = Iblock\PropertyTable::getList(array(
			'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE'),
			'filter' => array('=IBLOCK_ID' => $offers['IBLOCK_ID'], '=ACTIVE' => 'Y', '!=ID' => $offers['SKU_PROPERTY_ID']),
			'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
		));
		while ($property = $propertyIterator->fetch())
		{
			$propertyCode = (string)$property['CODE'];
			if ($propertyCode == '')
				$propertyCode = $property['ID'];
			$propertyName = '['.$propertyCode.'] '.$property['NAME'];

			$arProperty_Offers[$propertyCode] = $propertyName;
			if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
				$arProperty_OffersWithoutFile[$propertyCode] = $propertyName;
		}
		unset($propertyCode, $propertyName, $property, $propertyIterator);
	}
}

$arSort = CIBlockParameters::GetElementSortFields(
	array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
	array('KEY_LOWERCASE' => 'Y')
);

$arPrice = array();
if ($catalogIncluded) {
	$arSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
	$arPrice = CCatalogIBlockParameters::getPriceTypesList();
}
else {
	$arPrice = $arProperty_N;
}

$arAscDesc = array(
	"asc" => GetMessage("IBLOCK_SORT_ASC"),
	"desc" => GetMessage("IBLOCK_SORT_DESC"),
);

$detailPictMode = array(
	// 'IMG' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_IMG'),
	'NONE' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_NONE'),
	'POPUP' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_POPUP'),
	'MAGNIFIER' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_MAGNIFIER'),
	// 'GALLERY' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_GALLERY') 
);

$arComponentParameters = array(
	"GROUPS" => array(
		
		"REVIEW_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_REVIEW_SETTINGS"),
		),
		"ACTION_SETTINGS" => array(
			"NAME" => GetMessage('IBLOCK_ACTIONS')
		),
		"PRICES" => array(
			"NAME" => GetMessage("IBLOCK_PRICES"),
			"SORT" => 605,
		),
		"FILTER_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_FILTER_SETTINGS"),
			"SORT" => 610
		),
		"BASKET" => array(
			"NAME" => GetMessage("IBLOCK_BASKET"),
		),
		"SECTIONS_SETTINGS" => array(
			"NAME" => GetMessage("CP_BC_SECTIONS_SETTINGS"),
			"SORT" => 615,
		),
		"LIST_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_SETTINGS"),
			"SORT" => 620,
		),
		"DETAIL_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_DETAIL_SETTINGS"),
			"SORT" => 625,
		),
		"LINKED_ELEMENTS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_LINKED_ELEMS_SETTINGS"),
			"SORT" => 627,
		),
		"COMPARE_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_COMPARE_SETTINGS_EXT"),
			"SORT" => 630,
		),
		"FAVORITE_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_FAVORITE_SETTINGS_EXT"),
			"SORT" => 635,
		),
		// "LINK" => array(
		// 	"NAME" => GetMessage("IBLOCK_LINK"),
		// ),
		"BIG_DATA_SETTINGS" => array(
			"NAME" => GetMessage("CP_BC_GROUP_BIG_DATA_SETTINGS"),
			"SORT" => 640
		),
		"ALSO_BUY_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_ALSO_BUY_SETTINGS"),
			"SORT" => 645
		),
		"GIFTS_SETTINGS" => array(
			"NAME" => GetMessage("SALE_T_DESC_GIFTS_SETTINGS"),
			"SORT" => 650
		),
		"STORE_SETTINGS" => array(
			"NAME" => GetMessage("T_IBLOCK_DESC_STORE_SETTINGS"),
			"SORT" => 655,
		),
		"OFFERS_SETTINGS" => array(
			"NAME" => GetMessage("CP_BC_OFFERS_SETTINGS"),
		),
		"EXTENDED_SETTINGS" => array(
			"NAME" => GetMessage("IBLOCK_EXTENDED_SETTINGS"),
			"SORT" => 665
		)
	),
	"PARAMETERS" => array(
		"VARIABLE_ALIASES" => array(
			"ELEMENT_ID" => array(
				"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_ELEMENT_ID"),
			),
			"SECTION_ID" => array(
				"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_SECTION_ID"),
			),

		),
		"AJAX_MODE" => array(),
		"SEF_MODE" => array(
			"sections" => array(
				"NAME" => GetMessage("SECTIONS_TOP_PAGE"),
				"DEFAULT" => "",
				"VARIABLES" => array(
				),
			),
			"section" => array(
				"NAME" => GetMessage("SECTION_PAGE"),
				"DEFAULT" => "#SECTION_CODE_PATH#/",
				"VARIABLES" => array(
					"SECTION_ID",
					"SECTION_CODE",
					"SECTION_CODE_PATH",
				),
			),
			"element" => array(
				"NAME" => GetMessage("DETAIL_PAGE"),
				"DEFAULT" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
				"VARIABLES" => array(
					"ELEMENT_ID",
					"ELEMENT_CODE",
					"SECTION_ID",
					"SECTION_CODE",
					"SECTION_CODE_PATH",
				),
			),
			"compare" => array(
				"NAME" => GetMessage("COMPARE_PAGE"),
				"DEFAULT" => "compare/?action=#ACTION_CODE#",
				"VARIABLES" => array(
					"action",
				),
			),
		),
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_IBLOCK"),
			"TYPE" => "LIST",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		),
		"USE_FILTER" => array(
			"PARENT" => "FILTER_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_USE_FILTER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		// "USE_REVIEW" => array(
		// 	"PARENT" => "REVIEW_SETTINGS",
		// 	"NAME" => GetMessage("T_IBLOCK_DESC_USE_REVIEW"),
		// 	"TYPE" => "CHECKBOX",
		// 	"DEFAULT" => "N",
		// 	"REFRESH" => "Y",
		// ),
		"USE_COMPARE" => array(
			"PARENT" => "COMPARE_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_USE_COMPARE_EXT"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		"USE_FAVORITE" => array(
			"PARENT" => "FAVORITE_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_USE_FAVORITE_EXT"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "N",
		),
		// "SECTION_COUNT_ELEMENTS" => array(
		// 	"PARENT" => "SECTIONS_SETTINGS",
		// 	"NAME" => GetMessage('CP_BC_SECTION_COUNT_ELEMENTS'),
		// 	"TYPE" => "CHECKBOX",
		// 	"DEFAULT" => "Y",
		// ),
		"SECTION_LIST_TEMPLATE" => array(
			"PARENT" => "SECTIONS_SETTINGS",
			"NAME" => GetMessage("SECTION_LIST_TEMPLATE"),
			"TYPE" => "LIST",
			"VALUES" => $arSectionListTemplates,
			"DEFAULT" => "tree",
		),
		"SECTION_TOP_DEPTH" => array(
			"PARENT" => "SECTIONS_SETTINGS",
			"NAME" => GetMessage('CP_BC_SECTION_TOP_DEPTH'),
			"TYPE" => "STRING",
			"DEFAULT" => "2",
		),
		"SHOW_SECTION_LIST" => array(
			"PARENT" => "SECTIONS_SETTINGS",
			"NAME" => GetMessage('SHOW_SECTION_LIST_IN_MAIN'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"HIDDEN_SECTION_LIST_IN_SECTION" => array(
			"PARENT" => "SECTIONS_SETTINGS",
			"NAME" => GetMessage('SECTIONS_HIDDEN_LIST_IN_SECTION'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"HIDDEN_SECTION_LIST_WITHOUT_SUBSECTIONS" => array(
			"PARENT" => "SECTIONS_SETTINGS",
			"NAME" => GetMessage('SECTIONS_HIDDEN_WITHOUT_SUBSECTIONS'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"SECTION_LIST_IMG_WIDTH" => array(
			"PARENT" => "SECTIONS_SETTINGS",
			"NAME" => GetMessage("SECTION_LIST_IMG_WIDTH"),
			"TYPE" => "STRING",
			"DEFAULT" => "220",
		),
		"SECTION_LIST_IMG_HEIGHT" => array(
			"PARENT" => "SECTIONS_SETTINGS",
			"NAME" => GetMessage("SECTION_LIST_IMG_HEIGHT"),
			"TYPE" => "STRING",
			"DEFAULT" => "220",
		),
		"SECTION_LIST_RESIZE_IMAGE" => array(
			"PARENT" => "SECTIONS_SETTINGS",
			"NAME" => GetMessage("ELEMENT_LIST_RESIZE_IMAGE"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"1" => GetMessage("BX_RESIZE_IMAGE_EXACT"),
				"2" => GetMessage("BX_RESIZE_IMAGE_PROPORTIONAL"),
				"3" => GetMessage("BX_RESIZE_IMAGE_PROPORTIONAL_ALT"),
			),
			"DEFAULT" => "2",
			"ADDITIONAL_VALUES" => "N",
		),
		"ELEMENT_LIST_TEMPLATE" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("ELEMENT_LIST_TEMPLATE"),
			"TYPE" => "LIST",
			"VALUES" => $arElementListTemplates,
			"DEFAULT" => ".default",
		),
		"PAGE_ELEMENT_COUNT" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("IBLOCK_PAGE_ELEMENT_COUNT"),
			"TYPE" => "STRING",
			"DEFAULT" => "30",
		),
		"ELEMENT_LIST_IN_MAIN" => Array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("ELEMENT_LIST_IN_MAIN"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"ELEMENT_LIST_IMG_WIDTH" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("ELEMENT_LIST_IMG_WIDTH"),
			"TYPE" => "STRING",
			"DEFAULT" => "220",
		),
		"ELEMENT_LIST_IMG_HEIGHT" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("ELEMENT_LIST_IMG_HEIGHT"),
			"TYPE" => "STRING",
			"DEFAULT" => "220",
		),
		"ELEMENT_LIST_RESIZE_IMAGE" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("ELEMENT_LIST_RESIZE_IMAGE"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"1" => GetMessage("BX_RESIZE_IMAGE_EXACT"),
				"2" => GetMessage("BX_RESIZE_IMAGE_PROPORTIONAL"),
				"3" => GetMessage("BX_RESIZE_IMAGE_PROPORTIONAL_ALT"),
			),
			"DEFAULT" => "2",
			"ADDITIONAL_VALUES" => "N",
		),
		"USE_SECTION_SORT" => Array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("USE_SECTION_SORT"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"USE_SECTION_SORT_VIEW" => Array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("USE_SECTION_SORT_VIEW"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"ELEMENT_SORT_FIELD" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD"),
			"TYPE" => "LIST",
			"VALUES" => $arSort,
			"ADDITIONAL_VALUES" => "Y",
			"DEFAULT" => "sort",
		),
		"ELEMENT_SORT_ORDER" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER"),
			"TYPE" => "LIST",
			"VALUES" => $arAscDesc,
			"DEFAULT" => "asc",
			"ADDITIONAL_VALUES" => "Y",
		),
		"ELEMENT_SORT_FIELD2" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD2"),
			"TYPE" => "LIST",
			"VALUES" => $arSort,
			"ADDITIONAL_VALUES" => "Y",
			"DEFAULT" => "id",
		),
		"ELEMENT_SORT_ORDER2" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER2"),
			"TYPE" => "LIST",
			"VALUES" => $arAscDesc,
			"DEFAULT" => "desc",
			"ADDITIONAL_VALUES" => "Y",
		),
		"LIST_PROPERTY_CODE" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("IBLOCK_PROPERTY"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arProperty_LNS,
		),
		// "INCLUDE_SUBSECTIONS" => array(
		// 	"PARENT" => "LIST_SETTINGS",
		// 	"NAME" => GetMessage("CP_BC_INCLUDE_SUBSECTIONS"),
		// 	"TYPE" => "LIST",
		// 	"VALUES" => array(
		// 		"Y" => GetMessage('CP_BC_INCLUDE_SUBSECTIONS_ALL'),
		// 		"A" => GetMessage('CP_BC_INCLUDE_SUBSECTIONS_ACTIVE'),
		// 		"N" => GetMessage('CP_BC_INCLUDE_SUBSECTIONS_NO'),
		// 	),
		// 	"DEFAULT" => "Y",
		// ),
		// "USE_MAIN_ELEMENT_SECTION" => array(
		// 	"PARENT" => "ADDITIONAL_SETTINGS",
		// 	"NAME" => GetMessage("CP_BC_USE_MAIN_ELEMENT_SECTION"),
		// 	"TYPE" => "CHECKBOX",
		// 	"DEFAULT" => "N",
		// ),
		"LIST_META_KEYWORDS" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("CP_BC_LIST_META_KEYWORDS"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"ADDITIONAL_VALUES" => "N",
			"VALUES" => $arUserFields_S,
		),
		"LIST_META_DESCRIPTION" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("CP_BC_LIST_META_DESCRIPTION"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"ADDITIONAL_VALUES" => "N",
			"VALUES" => $arUserFields_S,
		),
		"LIST_BROWSER_TITLE" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("CP_BC_LIST_BROWSER_TITLE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"DEFAULT" => "-",
			"VALUES" => array_merge(array("-"=>" ", "NAME" => GetMessage("IBLOCK_FIELD_NAME")), $arUserFields_S),
		),
		"LIST_SET_CANONICAL_URL" => array(
			"PARENT" => "LIST_SETTINGS",
			"NAME" => GetMessage("LIST_SET_CANONICAL_URL"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		// "SECTION_BACKGROUND_IMAGE" =>array(
		// 	"PARENT" => "LIST_SETTINGS",
		// 	"NAME" => GetMessage("CP_BC_BACKGROUND_IMAGE"),
		// 	"TYPE" => "LIST",
		// 	"DEFAULT" => "-",
		// 	"MULTIPLE" => "N",
		// 	"VALUES" => array_merge(array("-"=>" "), $arUserFields_F)
		// ),
		"ELEMENT_DETAIL_TEMPLATE" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("ELEMENT_DETAIL_TEMPLATE"),
			"TYPE" => "LIST",
			"VALUES" => $arElementDetailTemplates,
			"DEFAULT" => ".default",
		),
		"ELEMENT_DETAIL_IMG_WIDTH" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("ELEMENT_DETAIL_IMG_WIDTH"),
			"TYPE" => "STRING",
			"DEFAULT" => "350",
		),
		"ELEMENT_DETAIL_IMG_HEIGHT" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("ELEMENT_DETAIL_IMG_HEIGHT"),
			"TYPE" => "STRING",
			"DEFAULT" => "1000",
		),

		"ELEMENT_DETAIL_DOP_IMG_WIDTH" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("ELEMENT_DETAIL_DOP_IMG_WIDTH"),
			"TYPE" => "STRING",
			"DEFAULT" => "70",
		),
		"ELEMENT_DETAIL_DOP_IMG_HEIGHT" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("ELEMENT_DETAIL_DOP_IMG_HEIGHT"),
			"TYPE" => "STRING",
			"DEFAULT" => "70",
		),
		"ELEMENT_DETAIL_RESIZE_IMAGE" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("ELEMENT_DETAIL_RESIZE_IMAGE"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"1" => GetMessage("BX_RESIZE_IMAGE_EXACT"),
				"2" => GetMessage("BX_RESIZE_IMAGE_PROPORTIONAL"),
				"3" => GetMessage("BX_RESIZE_IMAGE_PROPORTIONAL_ALT"),
			),
			"DEFAULT" => "2",
			"ADDITIONAL_VALUES" => "N",
		),
		"DETAIL_DETAIL_PICTURE_MODE" => array(
			'PARENT' => 'DETAIL_SETTINGS',
			'NAME' => GetMessage('CP_BC_TPL_DETAIL_DETAIL_PICTURE_MODE'),
			'TYPE' => 'LIST',
			'DEFAULT' => 'IMG',
			'VALUES' => $detailPictMode
		),
		
		"DETAIL_PROPERTY_CODE" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("IBLOCK_PROPERTY"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $arProperty_LNS,
		),
		"DETAIL_META_KEYWORDS" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("CP_BC_DETAIL_META_KEYWORDS"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"ADDITIONAL_VALUES" => "N",
			"VALUES" => array_merge(array("-"=>" "),$arProperty_LNS),
		),
		"DETAIL_META_DESCRIPTION" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("CP_BC_DETAIL_META_DESCRIPTION"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"ADDITIONAL_VALUES" => "N",
			"VALUES" => array_merge(array("-"=>" "),$arProperty_LNS),
		),
		"DETAIL_BROWSER_TITLE" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("CP_BC_DETAIL_BROWSER_TITLE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"DEFAULT" => "-",
			"VALUES" => array_merge(array("-"=>" ", "NAME" => GetMessage("IBLOCK_FIELD_NAME")), $arProperty_LNS),
		),
		"DETAIL_SET_CANONICAL_URL" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage("CP_BC_DETAIL_SET_CANONICAL_URL"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		// "SECTION_ID_VARIABLE" => array(
		// 	"PARENT" => "DETAIL_SETTINGS",
		// 	"NAME"		=> GetMessage("IBLOCK_SECTION_ID_VARIABLE"),
		// 	"TYPE"		=> "STRING",
		// 	"DEFAULT"	=> "SECTION_ID"
		// ),
		// "DETAIL_CHECK_SECTION_ID_VARIABLE" => array(
		// 	"PARENT" => "DETAIL_SETTINGS",
		// 	"NAME" => GetMessage("CP_BC_DETAIL_CHECK_SECTION_ID_VARIABLE"),
		// 	"TYPE" => "CHECKBOX",
		// 	"DEFAULT" => "N"
		// ),
		// "DETAIL_BACKGROUND_IMAGE" =>array(
		// 	"PARENT" => "DETAIL_SETTINGS",
		// 	"NAME" => GetMessage("CP_BC_BACKGROUND_IMAGE"),
		// 	"TYPE" => "LIST",
		// 	"MULTIPLE" => "N",
		// 	"DEFAULT" => "-",
		// 	"VALUES" => array_merge(array("-"=>" "),$arProperty_F)
		// ),

		"SHOW_DEACTIVATED" => array(
			"PARENT" => "DETAIL_SETTINGS",
			"NAME" => GetMessage('CP_BC_SHOW_DEACTIVATED'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N"
		),

		"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		"CACHE_FILTER" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("IBLOCK_CACHE_FILTER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BC_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"USE_URL_IN_SETTINGS" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("USE_URL_IN_SETTINGS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"SET_LAST_MODIFIED" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("CP_BC_SET_LAST_MODIFIED"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"SET_TITLE" => array(),
		"ADD_SECTIONS_CHAIN" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("CP_BC_ADD_SECTIONS_CHAIN"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y"
		),
		"ADD_ELEMENT_CHAIN" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("CP_BC_ADD_ELEMENT_CHAIN"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N"
		),
		"PRICE_CODE" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_PRICE_CODE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arPrice,
		),
		"USE_PRICE_COUNT" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_USE_PRICE_COUNT"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			),
		"SHOW_PRICE_COUNT" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_SHOW_PRICE_COUNT"),
			"TYPE" => "STRING",
			"DEFAULT" => "1"
		),
		"PRICE_VAT_INCLUDE" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_VAT_INCLUDE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"PRICE_VAT_SHOW_VALUE" => array(
			"PARENT" => "PRICES",
			"NAME" => GetMessage("IBLOCK_VAT_SHOW_VALUE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"BASKET_URL" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("IBLOCK_BASKET_URL"),
			"TYPE" => "STRING",
			"DEFAULT" => "/personal/basket.php",
		),
		// "ACTION_VARIABLE" => array(
		// 	"PARENT" => "ACTION_SETTINGS",
		// 	"NAME"		=> GetMessage("IBLOCK_ACTION_VARIABLE"),
		// 	"TYPE"		=> "STRING",
		// 	"DEFAULT"	=> "action"
		// ),
		// "PRODUCT_ID_VARIABLE" => array(
		// 	"PARENT" => "ACTION_SETTINGS",
		// 	"NAME"		=> GetMessage("IBLOCK_PRODUCT_ID_VARIABLE"),
		// 	"TYPE"		=> "STRING",
		// 	"DEFAULT"	=> "id"
		// ),
		"USE_PRODUCT_QUANTITY" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("CP_BC_USE_PRODUCT_QUANTITY"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		"PRODUCT_QUANTITY_VARIABLE" => array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("CP_BC_PRODUCT_QUANTITY_VARIABLE"),
			"TYPE" => "STRING",
			"DEFAULT" => "quantity",
			"HIDDEN" => (isset($arCurrentValues['USE_PRODUCT_QUANTITY']) && $arCurrentValues['USE_PRODUCT_QUANTITY'] == 'Y' ? 'N' : 'Y')
		),
		// "ADD_PROPERTIES_TO_BASKET" => array(
		// 	"PARENT" => "BASKET",
		// 	"NAME" => GetMessage("CP_BC_ADD_PROPERTIES_TO_BASKET"),
		// 	"TYPE" => "CHECKBOX",
		// 	"DEFAULT" => "Y",
		// 	"REFRESH" => "Y"
		// ),
		// "PRODUCT_PROPS_VARIABLE" => array(
		// 	"PARENT" => "BASKET",
		// 	"NAME" => GetMessage("CP_BC_PRODUCT_PROPS_VARIABLE"),
		// 	"TYPE" => "STRING",
		// 	"DEFAULT" => "prop",
		// 	"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
		// ),
		// "PARTIAL_PRODUCT_PROPERTIES" => array(
		// 	"PARENT" => "BASKET",
		// 	"NAME" => GetMessage("CP_BC_PARTIAL_PRODUCT_PROPERTIES"),
		// 	"TYPE" => "CHECKBOX",
		// 	"DEFAULT" => "N",
		// 	"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
		// ),
		// "PRODUCT_PROPERTIES" => array(
		// 	"PARENT" => "BASKET",
		// 	"NAME" => GetMessage("CP_BC_PRODUCT_PROPERTIES"),
		// 	"TYPE" => "LIST",
		// 	"MULTIPLE" => "Y",
		// 	"VALUES" => $arProperty_X,
		// 	"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
		// ),


		"USE_GIFTS_DETAIL" => array(
			"PARENT" => "GIFTS_SETTINGS",
			"NAME" => GetMessage("SALE_T_DESC_USE_GIFTS_DETAIL"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),

		"USE_GIFTS_SECTION" => array(
			"PARENT" => "GIFTS_SETTINGS",
			"NAME" => GetMessage("SALE_T_DESC_USE_GIFTS_SECTION_LIST"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),

		"USE_GIFTS_MAIN_PR_SECTION_LIST" => array(
			"PARENT" => "GIFTS_SETTINGS",
			"NAME" => GetMessage("SALE_T_DESC_USE_GIFTS_MAIN_PR_DETAIL"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),

		"USE_STORE" => array(
			"PARENT" => "STORE_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_USE_STORE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		"USE_ELEMENT_COUNTER" => array(
			"PARENT" => "EXTENDED_SETTINGS",
			"NAME" => GetMessage('CP_BC_USE_ELEMENT_COUNTER'),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y"
		),
		// "DISABLE_INIT_JS_IN_COMPONENT" => array(
		// 	"PARENT" => "EXTENDED_SETTINGS",
		// 	"NAME" => GetMessage('CP_BC_DISABLE_INIT_JS_IN_COMPONENT'),
		// 	"TYPE" => "CHECKBOX",
		// 	"DEFAULT" => "N"
		// )
	),
);

if($arCurrentValues["IBLOCK_ID"] == "14") {
	$arComponentParameters["PARAMETERS"]["DETAIL_PROPERTY_CODE_2"] = array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => "Электрические параметры", //GetMessage("IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arProperty_LNS,
	);
	$arComponentParameters["PARAMETERS"]["DETAIL_PROPERTY_CODE_3"] = array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => "Механические параметры", //GetMessage("IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arProperty_LNS,
	);
	$arComponentParameters["PARAMETERS"]["DETAIL_PROPERTY_CODE_4"] = array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => "Условия окружающей среды", //GetMessage("IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arProperty_LNS,
	);
	$arComponentParameters["PARAMETERS"]["DETAIL_PROPERTY_CODE_5"] = array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => "Защита", //GetMessage("IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arProperty_LNS,
	);
}



if($arCurrentValues["SEF_MODE"]=="Y")
{
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"] = array();
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["ELEMENT_ID"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_ELEMENT_ID"),
		"TEMPLATE" => "#ELEMENT_ID#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["ELEMENT_CODE"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_ELEMENT_CODE"),
		"TEMPLATE" => "#ELEMENT_CODE#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["SECTION_ID"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_SECTION_ID"),
		"TEMPLATE" => "#SECTION_ID#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["SECTION_CODE"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_SECTION_CODE"),
		"TEMPLATE" => "#SECTION_CODE#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["SECTION_CODE_PATH"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_SECTION_CODE_PATH"),
		"TEMPLATE" => "#SECTION_CODE_PATH#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["SMART_FILTER_PATH"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_SMART_FILTER_PATH"),
		"TEMPLATE" => "#SMART_FILTER_PATH#",
	);
	$arComponentParameters["PARAMETERS"]["VARIABLE_ALIASES"]["BASKET_PATH"] = array(
		"NAME" => GetMessage("CP_BC_VARIABLE_ALIASES_BASKET_PATH"),
		"TEMPLATE" => "/basket.php",
	);

	$smartBase = ($arCurrentValues["SEF_URL_TEMPLATES"]["section"]? $arCurrentValues["SEF_URL_TEMPLATES"]["section"]: "#SECTION_ID#/");
	$arComponentParameters["PARAMETERS"]["SEF_MODE"]["smart_filter"] = array(
		"NAME" => GetMessage("CP_BC_SEF_MODE_SMART_FILTER"),
		"DEFAULT" => $smartBase."filter/#SMART_FILTER_PATH#/apply/",
		"VARIABLES" => array(
			"SECTION_ID",
			"SECTION_CODE",
			"SECTION_CODE_PATH",
			"SMART_FILTER_PATH",
		),
	);
}

/*
	Блок со связанными товарами
*/
$arComponentParameters['PARAMETERS']['ELEMENT_LINKED_DISPLAY'] = Array(
	"PARENT" => "LINKED_ELEMENTS",
	"NAME" => GetMessage("ELEMENT_LINKED_DISPLAY"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
	"REFRESH" => "Y",
);
if ($arCurrentValues['ELEMENT_LINKED_DISPLAY'] == "Y") {
	$arComponentParameters['PARAMETERS']["LINK_IBLOCK_TYPE"] = array(
		"PARENT" => "LINKED_ELEMENTS",
		"NAME" => GetMessage("IBLOCK_LINK_IBLOCK_TYPE"),
		"TYPE" => "LIST",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arIBlockType,
		"REFRESH" => "Y",
	);
	$arComponentParameters['PARAMETERS']["LINK_IBLOCK_ID"] = array(
		"PARENT" => "LINKED_ELEMENTS",
		"NAME" => GetMessage("IBLOCK_LINK_IBLOCK_ID"),
		"TYPE" => "LIST",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arIBlock_LINK,
		"REFRESH" => "Y",
	);
	$arComponentParameters['PARAMETERS']["LINK_PROPERTY_SID"] = array(
		"PARENT" => "LINKED_ELEMENTS",
		"NAME" => GetMessage("IBLOCK_LINK_PROPERTY_SID"),
		"TYPE" => "LIST",
		"ADDITIONAL_VALUES" => "Y",
		"VALUES" => $arProperty_LINK,
	);
	$arComponentParameters['PARAMETERS']["LINK_ELEMENTS_URL"] = array(
		"PARENT" => "LINKED_ELEMENTS",
		"NAME" => GetMessage("IBLOCK_LINK_ELEMENTS_URL"),
		"TYPE" => "STRING",
		"DEFAULT" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
	);
}

/*
	Блок с похожими элементами
*/
$arComponentParameters['PARAMETERS']['ELEMENT_SIMILAR_DISPLAY'] = Array(
	"PARENT" => "LINKED_ELEMENTS",
	"NAME" => GetMessage("ELEMENT_SIMILAR_DISPLAY"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
	"REFRESH" => "Y",
);
if ($arCurrentValues['ELEMENT_SIMILAR_DISPLAY'] == "Y") {
	$arComponentParameters['PARAMETERS']['ELEMENT_SIMILAR_COUNT'] = array(
		"PARENT" => "LINKED_ELEMENTS",
		"NAME" => GetMessage("ELEMENT_SIMILAR_COUNT"),
		"TYPE" => "STRING",
		"DEFAULT" => "12",
	);
}



/*
	Блок с уже просмотренными товарами
*/
$arComponentParameters['PARAMETERS']['ELEMENT_VIEWED_DISPLAY'] = Array(
	"PARENT" => "LINKED_ELEMENTS",
	"NAME" => GetMessage("ELEMENT_VIEWED_DISPLAY"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
	"REFRESH" => "Y",
);
if ($arCurrentValues['ELEMENT_VIEWED_DISPLAY'] == "Y") {
	$arComponentParameters['PARAMETERS']['ELEMENT_VIEWED_DISPLAY_COUNT'] = array(
		"PARENT" => "LINKED_ELEMENTS",
		"NAME" => GetMessage("ELEMENT_VIEWED_DISPLAY_COUNT"),
		"TYPE" => "STRING",
		"DEFAULT" => "12",
	);
}


if($arCurrentValues["USE_COMPARE"]=="Y")
{
	$arComponentParameters["PARAMETERS"]["COMPARE_NAME"] = array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("IBLOCK_COMPARE_NAME"),
		"TYPE" => "STRING",
		"DEFAULT" => "CATALOG_COMPARE_LIST"
	);
	$arComponentParameters["PARAMETERS"]["COMPARE_FIELD_CODE"] = CIBlockParameters::GetFieldCode(GetMessage("IBLOCK_FIELD"), "COMPARE_SETTINGS");
	$arComponentParameters["PARAMETERS"]["COMPARE_PROPERTY_CODE"] = array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_LNS,
		"ADDITIONAL_VALUES" => "Y",
	);
	if(!empty($offers))
	{
		$arComponentParameters["PARAMETERS"]["COMPARE_OFFERS_FIELD_CODE"] = CIBlockParameters::GetFieldCode(GetMessage("CP_BC_COMPARE_OFFERS_FIELD_CODE"), "COMPARE_SETTINGS");
		$arComponentParameters["PARAMETERS"]["COMPARE_OFFERS_PROPERTY_CODE"] = array(
			"PARENT" => "COMPARE_SETTINGS",
			"NAME" => GetMessage("CP_BC_COMPARE_OFFERS_PROPERTY_CODE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty_OffersWithoutFile,
			"ADDITIONAL_VALUES" => "Y",
		);
	}
	$arComponentParameters["PARAMETERS"]["COMPARE_ELEMENT_SORT_FIELD"] = array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("CP_BC_COMPARE_ELEMENT_SORT_FIELD"),
		"TYPE" => "LIST",
		"VALUES" => $arSort,
		"ADDITIONAL_VALUES" => "Y",
		"DEFAULT" => "sort",
	);
	$arComponentParameters["PARAMETERS"]["COMPARE_ELEMENT_SORT_ORDER"] = array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME" => GetMessage("CP_BC_COMPARE_ELEMENT_SORT_ORDER"),
		"TYPE" => "LIST",
		"VALUES" => $arAscDesc,
		"DEFAULT" => "asc",
		"ADDITIONAL_VALUES" => "Y",
	);
	$arComponentParameters["PARAMETERS"]["DISPLAY_ELEMENT_SELECT_BOX"] = array(
		"PARENT" => "COMPARE_SETTINGS",
		"NAME"=>GetMessage("T_IBLOCK_DESC_ELEMENT_BOX"),
		"TYPE"=>"CHECKBOX",
		"DEFAULT"=>"N",
		"REFRESH"=>"Y",
	);
	if($arCurrentValues["DISPLAY_ELEMENT_SELECT_BOX"]=="Y")
	{
		$arComponentParameters["PARAMETERS"]["ELEMENT_SORT_FIELD_BOX"] = array(
			"PARENT" => "COMPARE_SETTINGS",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD_BOX"),
			"TYPE" => "LIST",
			"VALUES" => $arSort,
			"ADDITIONAL_VALUES" => "Y",
			"DEFAULT" => "name",
		);
		$arComponentParameters["PARAMETERS"]["ELEMENT_SORT_ORDER_BOX"] = array(
			"PARENT" => "COMPARE_SETTINGS",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER_BOX"),
			"TYPE" => "LIST",
			"VALUES" => $arAscDesc,
			"DEFAULT" => "asc",
			"ADDITIONAL_VALUES" => "Y",
		);
		$arComponentParameters["PARAMETERS"]["ELEMENT_SORT_FIELD_BOX2"] = array(
			"PARENT" => "COMPARE_SETTINGS",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD_BOX2"),
			"TYPE" => "LIST",
			"VALUES" => $arSort,
			"ADDITIONAL_VALUES" => "Y",
			"DEFAULT" => "id",
		);
		$arComponentParameters["PARAMETERS"]["ELEMENT_SORT_ORDER_BOX2"] = array(
			"PARENT" => "COMPARE_SETTINGS",
			"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER_BOX2"),
			"TYPE" => "LIST",
			"VALUES" => $arAscDesc,
			"DEFAULT" => "desc",
			"ADDITIONAL_VALUES" => "Y",
		);
	}
}

if (!empty($offers))
{
	$arComponentParameters["PARAMETERS"]["LIST_OFFERS_FIELD_CODE"] = CIBlockParameters::GetFieldCode(GetMessage("CP_BC_LIST_OFFERS_FIELD_CODE"), "LIST_SETTINGS");
	$arComponentParameters["PARAMETERS"]["LIST_OFFERS_PROPERTY_CODE"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("CP_BC_LIST_OFFERS_PROPERTY_CODE"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_Offers,
		"ADDITIONAL_VALUES" => "Y",
	);
	$arComponentParameters["PARAMETERS"]["LIST_OFFERS_LIMIT"] = array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("CP_BC_LIST_OFFERS_LIMIT"),
		"TYPE" => "STRING",
		"DEFAULT" => 5,
	);

	$arComponentParameters["PARAMETERS"]["DETAIL_OFFERS_FIELD_CODE"] = CIBlockParameters::GetFieldCode(GetMessage("CP_BC_DETAIL_OFFERS_FIELD_CODE"), "DETAIL_SETTINGS");
	$arComponentParameters["PARAMETERS"]["DETAIL_OFFERS_PROPERTY_CODE"] = array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("CP_BC_DETAIL_OFFERS_PROPERTY_CODE"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_Offers,
		"ADDITIONAL_VALUES" => "Y",
	);
}

if($arCurrentValues["USE_FILTER"]=="Y")
{
	$arComponentParameters["PARAMETERS"]["FILTER_NAME"] = array(
		"PARENT" => "FILTER_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_FILTER"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
	$arComponentParameters["PARAMETERS"]["FILTER_FIELD_CODE"] = CIBlockParameters::GetFieldCode(GetMessage("IBLOCK_FIELD"), "FILTER_SETTINGS");
	$arComponentParameters["PARAMETERS"]["FILTER_PROPERTY_CODE"] = array(
		"PARENT" => "FILTER_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_PROPERTY"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_LNS,
		"ADDITIONAL_VALUES" => "Y",
	);
	$arComponentParameters["PARAMETERS"]["FILTER_PRICE_CODE"] = array(
			"PARENT" => "FILTER_SETTINGS",
			"NAME" => GetMessage("IBLOCK_PRICE_CODE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arPrice,
	);
	if(!empty($offers))
	{
		$arComponentParameters["PARAMETERS"]["FILTER_OFFERS_FIELD_CODE"] = CIBlockParameters::GetFieldCode(GetMessage("CP_BC_FILTER_OFFERS_FIELD_CODE"), "FILTER_SETTINGS");
		$arComponentParameters["PARAMETERS"]["FILTER_OFFERS_PROPERTY_CODE"] = array(
			"PARENT" => "FILTER_SETTINGS",
			"NAME" => GetMessage("CP_BC_FILTER_OFFERS_PROPERTY_CODE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty_OffersWithoutFile,
			"ADDITIONAL_VALUES" => "Y",
		);
	}
}


if ($catalogIncluded && $arCurrentValues["USE_STORE"]=='Y')
{
	$storeIterator = CCatalogStore::GetList(
		array(),
		array('SHIPPING_CENTER' => 'Y'),
		false,
		false,
		array('ID', 'TITLE')
	);
	while ($store = $storeIterator->GetNext())
		$arStore[$store['ID']] = "[".$store['ID']."] ".$store['TITLE'];

	$userFields = $USER_FIELD_MANAGER->GetUserFields("CAT_STORE", 0, LANGUAGE_ID);
	$propertyUF = array();

	foreach($userFields as $fieldName => $userField)
		$propertyUF[$fieldName] = $userField["LIST_COLUMN_LABEL"] ? $userField["LIST_COLUMN_LABEL"] : $fieldName;

	$arComponentParameters["PARAMETERS"]['STORES'] = array(
		'PARENT' => 'STORE_SETTINGS',
		'NAME' => GetMessage('STORES'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'Y',
		'VALUES' => $arStore
	);
	$arComponentParameters["PARAMETERS"]['USE_MIN_AMOUNT'] = array(
		'PARENT' => 'STORE_SETTINGS',
		'NAME' => GetMessage('USE_MIN_AMOUNT'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		"REFRESH" => "Y",
	);
	$arComponentParameters["PARAMETERS"]['USER_FIELDS'] = array(
			"PARENT" => "STORE_SETTINGS",
			"NAME" => GetMessage("STORE_USER_FIELDS"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y",
			"VALUES" => $propertyUF,
		);
	$arComponentParameters["PARAMETERS"]['FIELDS'] = array(
		'NAME' => GetMessage("STORE_FIELDS"),
		'PARENT' => 'STORE_SETTINGS',
		'TYPE'  => 'LIST',
		'MULTIPLE' => 'Y',
		'ADDITIONAL_VALUES' => 'Y',
		'VALUES'    => Array(
			'TITLE'  => GetMessage("STORE_TITLE"),
			'ADDRESS'  => GetMessage("ADDRESS"),
			'DESCRIPTION'  => GetMessage('DESCRIPTION'),
			'PHONE'  => GetMessage('PHONE'),
			'SCHEDULE'  => GetMessage('SCHEDULE'),
			'EMAIL'  => GetMessage('EMAIL'),
			'IMAGE_ID'  => GetMessage('IMAGE_ID'),
			'COORDINATES'  => GetMessage('COORDINATES'),
		)
	);
	if ($arCurrentValues['USE_MIN_AMOUNT']!="N")
	{
		$arComponentParameters["PARAMETERS"]["MIN_AMOUNT"] = array(
				"PARENT" => "STORE_SETTINGS",
				"NAME"		=> GetMessage("MIN_AMOUNT"),
				"TYPE"		=> "STRING",
				"DEFAULT"	=> 10,
			);
	}
	$arComponentParameters["PARAMETERS"]['SHOW_EMPTY_STORE'] = array(
		'PARENT' => 'STORE_SETTINGS',
		'NAME' => GetMessage('SHOW_EMPTY_STORE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	);
	$arComponentParameters["PARAMETERS"]['SHOW_GENERAL_STORE_INFORMATION'] = array(
		'PARENT' => 'STORE_SETTINGS',
		'NAME' => GetMessage('SHOW_GENERAL_STORE_INFORMATION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N'
	);
	$arComponentParameters["PARAMETERS"]['STORE_PATH'] = array(
		'PARENT' => 'STORE_SETTINGS',
		'NAME' => GetMessage('STORE_PATH'),
		"TYPE"		=> "STRING",
		"DEFAULT"	=> "/store/#store_id#",
	);
	$arComponentParameters["PARAMETERS"]['MAIN_TITLE'] = array(
		'PARENT' => 'STORE_SETTINGS',
		'NAME' => GetMessage('MAIN_TITLE'),
		"TYPE"		=> "STRING",
		"DEFAULT"	=> GetMessage('MAIN_TITLE_VALUE'),
	);
}

/*
	Блоки связных элеметов
*/

if ($arCurrentValues['ELEMENT_SIMILAR_DISPLAY'] == "Y") {
	
}

$arComponentParameters['PARAMETERS']['USE_ALSO_BUY'] = array(
	"PARENT" => "LINKED_ELEMENTS",
	"NAME" => GetMessage("T_IBLOCK_DESC_USE_ALSO_BUY"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
	"REFRESH" => "Y",
);

if(!ModuleManager::isModuleInstalled("sale"))
{
	unset($arComponentParameters["PARAMETERS"]["USE_ALSO_BUY"]);
	unset($arComponentParameters["GROUPS"]["ALSO_BUY_SETTINGS"]);

	unset($arComponentParameters["PARAMETERS"]["USE_GIFTS_DETAIL"]);
	unset($arComponentParameters["PARAMETERS"]["USE_GIFTS_SECTION"]);
	unset($arComponentParameters["PARAMETERS"]["USE_GIFTS_MAIN_PR_SECTION_LIST"]);
	unset($arComponentParameters["GROUPS"]["GIFTS_SETTINGS"]);
}
else
{
	if($arCurrentValues["USE_ALSO_BUY"] == "Y")
	{
		$arComponentParameters["PARAMETERS"]["ALSO_BUY_ELEMENT_COUNT"] = array(
				"PARENT" => "LINKED_ELEMENTS",
				"NAME"		=> GetMessage("T_IBLOCK_DESC_ALSO_BUY_ELEMENT_COUNT"),
				"TYPE"		=> "STRING",
				"DEFAULT"	=> 5
			);
		$arComponentParameters["PARAMETERS"]["ALSO_BUY_MIN_BUYES"] = array(
				"PARENT" => "LINKED_ELEMENTS",
				"NAME"		=> GetMessage("T_IBLOCK_DESC_ALSO_BUY_MIN_BUYES"),
				"TYPE"		=> "STRING",
				"DEFAULT"	=> 1
			);
	}

	// $useGiftsDetail = $arCurrentValues["USE_GIFTS_DETAIL"] === null && $arComponentParameters['PARAMETERS']['USE_GIFTS_DETAIL']['DEFAULT'] == 'Y' || $arCurrentValues["USE_GIFTS_DETAIL"] == "Y";
	// $useGiftsSection = $arCurrentValues["USE_GIFTS_SECTION"] === null && $arComponentParameters['PARAMETERS']['USE_GIFTS_SECTION']['DEFAULT'] == 'Y' || $arCurrentValues["USE_GIFTS_SECTION"] == "Y";
	// $useGiftsMainPrSectionList = $arCurrentValues["USE_GIFTS_MAIN_PR_SECTION_LIST"] === null && $arComponentParameters['PARAMETERS']['USE_GIFTS_MAIN_PR_SECTION_LIST']['DEFAULT'] == 'Y' || $arCurrentValues["USE_GIFTS_MAIN_PR_SECTION_LIST"] == "Y";
	// if($useGiftsDetail || $useGiftsSection || $useGiftsMainPrSectionList)
	// {
	// 	if($useGiftsDetail)
	// 	{
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_DETAIL_PAGE_ELEMENT_COUNT"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_PAGE_ELEMENT_COUNT_DETAIL"),
	// 			"TYPE" => "STRING",
	// 			"DEFAULT" => "3",
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_DETAIL_HIDE_BLOCK_TITLE"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_PARAMS_HIDE_BLOCK_TITLE_DETAIL"),
	// 			"TYPE" => "CHECKBOX",
	// 			"DEFAULT" => "",
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_DETAIL_BLOCK_TITLE"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_PARAMS_BLOCK_TITLE_DETAIL"),
	// 			"TYPE" => "STRING",
	// 			"DEFAULT" => GetMessage("SGB_PARAMS_BLOCK_TITLE_DETAIL_DEFAULT"),
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_DETAIL_TEXT_LABEL_GIFT"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_PARAMS_TEXT_LABEL_GIFT_DETAIL"),
	// 			"TYPE" => "STRING",
	// 			"DEFAULT" => GetMessage("SGP_PARAMS_TEXT_LABEL_GIFT_DEFAULT"),
	// 		);
	// 	}
	// 	if($useGiftsSection)
	// 	{
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_PAGE_ELEMENT_COUNT_SECTION_LIST"),
	// 			"TYPE" => "STRING",
	// 			"DEFAULT" => "3",
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_PARAMS_HIDE_BLOCK_TITLE_SECTION_LIST"),
	// 			"TYPE" => "CHECKBOX",
	// 			"DEFAULT" => "",
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_SECTION_LIST_BLOCK_TITLE"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_PARAMS_BLOCK_TITLE_SECTION_LIST"),
	// 			"TYPE" => "STRING",
	// 			"DEFAULT" => GetMessage("SGB_PARAMS_BLOCK_TITLE_SECTION_LIST_DEFAULT"),
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_SECTION_LIST_TEXT_LABEL_GIFT"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_PARAMS_TEXT_LABEL_GIFT_SECTION_LIST"),
	// 			"TYPE" => "STRING",
	// 			"DEFAULT" => GetMessage("SGP_PARAMS_TEXT_LABEL_GIFT_DEFAULT"),
	// 		);
	// 	}

	// 	if($useGiftsDetail || $useGiftsSection)
	// 	{
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_SHOW_DISCOUNT_PERCENT"] = array(
	// 			'PARENT' => 'GIFTS_SETTINGS',
	// 			'NAME' => GetMessage('CVP_SHOW_DISCOUNT_PERCENT'),
	// 			'TYPE' => 'CHECKBOX',
	// 			'DEFAULT' => 'Y'
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_SHOW_OLD_PRICE"] = array(
	// 			'PARENT' => 'GIFTS_SETTINGS',
	// 			'NAME' => GetMessage('CVP_SHOW_OLD_PRICE'),
	// 			'TYPE' => 'CHECKBOX',
	// 			'DEFAULT' => 'Y'
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_SHOW_NAME"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("CVP_SHOW_NAME"),
	// 			"TYPE" => "CHECKBOX",
	// 			"DEFAULT" => "Y",
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_SHOW_IMAGE"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("CVP_SHOW_IMAGE"),
	// 			"TYPE" => "CHECKBOX",
	// 			"DEFAULT" => "Y",
	// 		);
	// 		$arComponentParameters["PARAMETERS"]['GIFTS_MESS_BTN_BUY'] = array(
	// 			'PARENT' => 'GIFTS_SETTINGS',
	// 			'NAME' => GetMessage('CVP_MESS_BTN_BUY_GIFT'),
	// 			'TYPE' => 'STRING',
	// 			'DEFAULT' => GetMessage('CVP_MESS_BTN_BUY_GIFT_DEFAULT')
	// 		);
	// 	}
	// 	if($useGiftsMainPrSectionList)
	// 	{
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_PAGE_ELEMENT_COUNT_MAIN_PR_DETAIL"),
	// 			"TYPE" => "STRING",
	// 			"DEFAULT" => "3",
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_PARAMS_HIDE_BLOCK_TITLE_MAIN_PR_DETAIL"),
	// 			"TYPE" => "CHECKBOX",
	// 			"DEFAULT" => "",
	// 		);
	// 		$arComponentParameters["PARAMETERS"]["GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE"] = array(
	// 			"PARENT" => "GIFTS_SETTINGS",
	// 			"NAME" => GetMessage("SGP_MAIN_PRODUCT_PARAMS_BLOCK_TITLE"),
	// 			"TYPE" => "STRING",
	// 			"DEFAULT" => GetMessage('SGB_MAIN_PRODUCT_PARAMS_BLOCK_TITLE_DEFAULT'),
	// 		);
	// 	}
	// }
}

if ($catalogIncluded)
{
	$arComponentParameters["PARAMETERS"]['HIDE_NOT_AVAILABLE'] = array(
		'PARENT' => 'LIST_SETTINGS',
		'NAME' => GetMessage('CP_BC_HIDE_NOT_AVAILABLE_EXT'),
		'TYPE' => 'LIST',
		'DEFAULT' => 'N',
		'VALUES' => array(
			'Y' => GetMessage('CP_BC_HIDE_NOT_AVAILABLE_HIDE'),
			'L' => GetMessage('CP_BC_HIDE_NOT_AVAILABLE_LAST'),
			'N' => GetMessage('CP_BC_HIDE_NOT_AVAILABLE_SHOW')
		),
		'ADDITIONAL_VALUES' => 'N'
	);

	$arComponentParameters["PARAMETERS"]['CONVERT_CURRENCY'] = array(
		'PARENT' => 'PRICES',
		'NAME' => GetMessage('CP_BC_CONVERT_CURRENCY'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y',
	);

	if (isset($arCurrentValues['CONVERT_CURRENCY']) && $arCurrentValues['CONVERT_CURRENCY'] == 'Y')
	{
		$arComponentParameters['PARAMETERS']['CURRENCY_ID'] = array(
			'PARENT' => 'PRICES',
			'NAME' => GetMessage('CP_BC_CURRENCY_ID'),
			'TYPE' => 'LIST',
			'VALUES' => Currency\CurrencyManager::getCurrencyList(),
			'DEFAULT' => Currency\CurrencyManager::getBaseCurrency(),
			"ADDITIONAL_VALUES" => "Y",
		);
	}

	$arComponentParameters['PARAMETERS']['DETAIL_SET_VIEWED_IN_COMPONENT'] = array(
		"PARENT" => "EXTENDED_SETTINGS",
		"NAME" => GetMessage('CP_BC_DETAIL_SET_VIEWED_IN_COMPONENT'),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N"
	);
}

if(empty($offers))
{
	unset($arComponentParameters["GROUPS"]["OFFERS_SETTINGS"]);
}
else
{
	$arComponentParameters["PARAMETERS"]["OFFERS_CART_PROPERTIES"] = array(
		"PARENT" => "BASKET",
		"NAME" => GetMessage("CP_BC_OFFERS_CART_PROPERTIES"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arProperty_OffersWithoutFile,
		"HIDDEN" => (isset($arCurrentValues['ADD_PROPERTIES_TO_BASKET']) && $arCurrentValues['ADD_PROPERTIES_TO_BASKET'] == 'N' ? 'Y' : 'N')
	);

	$arComponentParameters["PARAMETERS"]["OFFERS_SORT_FIELD"] = array(
		"PARENT" => "OFFERS_SETTINGS",
		"NAME" => GetMessage("CP_BC_OFFERS_SORT_FIELD"),
		"TYPE" => "LIST",
		"VALUES" => $arSort,
		"ADDITIONAL_VALUES" => "Y",
		"DEFAULT" => "sort",
	);
	$arComponentParameters["PARAMETERS"]["OFFERS_SORT_ORDER"] = array(
		"PARENT" => "OFFERS_SETTINGS",
		"NAME" => GetMessage("CP_BC_OFFERS_SORT_ORDER"),
		"TYPE" => "LIST",
		"VALUES" => $arAscDesc,
		"DEFAULT" => "asc",
		"ADDITIONAL_VALUES" => "Y",
	);
	$arComponentParameters["PARAMETERS"]["OFFERS_SORT_FIELD2"] = array(
		"PARENT" => "OFFERS_SETTINGS",
		"NAME" => GetMessage("CP_BC_OFFERS_SORT_FIELD2"),
		"TYPE" => "LIST",
		"VALUES" => $arSort,
		"ADDITIONAL_VALUES" => "Y",
		"DEFAULT" => "id",
	);
	$arComponentParameters["PARAMETERS"]["OFFERS_SORT_ORDER2"] = array(
		"PARENT" => "OFFERS_SETTINGS",
		"NAME" => GetMessage("CP_BC_OFFERS_SORT_ORDER2"),
		"TYPE" => "LIST",
		"VALUES" => $arAscDesc,
		"DEFAULT" => "desc",
		"ADDITIONAL_VALUES" => "Y",
	);
}

CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);
CIBlockParameters::AddPagerSettings(
	$arComponentParameters,
	GetMessage("T_IBLOCK_DESC_PAGER_CATALOG"), //$pager_title
	true, //$bDescNumbering
	true, //$bShowAllParam
	true, //$bBaseLink
	$arCurrentValues["PAGER_BASE_LINK_ENABLE"]==="Y" //$bBaseLinkEnabled
);

