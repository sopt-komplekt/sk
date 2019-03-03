<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $USER;
$userID = 0;
if($USER->IsAuthorized()) {
	$userID = $USER->GetID();
}

$arUserTypeEntityFilter = array(
	'ENTITY_ID' => 'USER',
	'FIELD_NAME' => 'UF_FAVORITES',
	'USER_TYPE_ID' => 'string',
);

$resUserTypeEntity = CUserTypeEntity::GetList(array(),$arUserTypeEntityFilter);
$arUserTypeEntity = $resUserTypeEntity->Fetch();

if(!$arUserTypeEntity['ID']) {
	$oUserTypeEntity = new CUserTypeEntity();
	$aUserFields = array(
		'ENTITY_ID'         => 'USER', /*The identifier of the entity to which the property is bound.*/
		'FIELD_NAME'        => 'UF_FAVORITES', /*Field code. Always start with UF_*/
		'USER_TYPE_ID'      => 'string', /*Custom Property Type*/
		'XML_ID'            => 'XML_ID_USER_FAVORITES',/*XML_ID of the custom property. Used when unloading as the field name*/
		'SORT'              => 100, /*Sorting*/
		'MULTIPLE'          => 'N', /*Is the field plural or not*/
		'MANDATORY'         => 'N', /*Required property or not*/
		'SHOW_FILTER'       => 'N',/*Show the list in the filter. Do not show - N, exact match - I, search by mask - E, search by substring - S*/
		'SHOW_IN_LIST'      => 'N', /*Do not show in the list. If you pass any value, it will be considered that the flag is set.*/
		'EDIT_IN_LIST'      => 'N', /*Do not allow editing by the user. If you pass any value, it will be considered that the flag is set.*/
		'IS_SEARCHABLE'     => 'N', /*Field values are involved in the search*/
		'SETTINGS'          => array( /*Additional field settings (depending on the type)*/
			'DEFAULT_VALUE' => '', /*Default value*/
			'SIZE'          => '20', /* The size of the input field to display */
			'ROWS'          => '1', /* Number of lines in the input field */
			'MIN_LENGTH'    => '0', /* Minimum line length (0 - do not check) */
			'MAX_LENGTH'    => '0', /* Maximum string length (0 - do not check) */
			'REGEXP'        => '', /* Regular expression to test */
		),
		'EDIT_FORM_LABEL'   => array( /* Signature in form of editing */
			'ru'    => GetMessage('FAV_PROP_NAME_RU'),
			'en'    => GetMessage('FAV_PROP_NAME_EN'),
		),
		'LIST_COLUMN_LABEL' => array( /* Title in the list */
			'ru'    => GetMessage('FAV_PROP_NAME_RU'),
			'en'    => GetMessage('FAV_PROP_NAME_EN'),
		),
		'LIST_FILTER_LABEL' => array( /* Filter signature in the list */
			'ru'    => GetMessage('FAV_PROP_NAME_RU'),
			'en'    => GetMessage('FAV_PROP_NAME_EN'),
		),
		'ERROR_MESSAGE'     => array( /* Error message (optional) */
			'ru'    => '',
			'en'    => '',
		),
		'HELP_MESSAGE'      => array( /* Help */
			'ru'    => '',
			'en'    => '',
		),
	);
	$iUserFieldId   = $oUserTypeEntity->Add( $aUserFields ); // int
}

$action = $_POST['action'] ? $_POST['action'] : $_GET['action'];
$productId = $_POST['id'] ? $_POST['id'] : $_GET['id'];

$arResult = array();

if($action == 'add' && $productId > 0) {
	if($userID > 0) {
		$rsUser = CUser::GetByID($userID);
		$arUser = $rsUser->Fetch();
		$favorites = $arUser['UF_FAVORITES'];
		if(strlen($favorites) > 0) {
			$arFavorites = unserialize($favorites);
			if(!array_key_exists($productId, $arFavorites)) {
				$arFavorites[$productId] = array(
					'ID' => $productId,
					'DATE_ADD' => date('d.m.Y H:i:s'),
				);
			}
		} else {
			$arFavorites = array();
			$arFavorites[$productId] = array(
				'ID' => $productId,
				'DATE_ADD' => date('d.m.Y H:i:s'),
			);
		}
		$favorites = serialize($arFavorites);
		$fields = array(
			'UF_FAVORITES' => $favorites,
		);
		$USER->Update($userID,$fields);
	} else {
		$prefix = COption::GetOptionString("main", "cookie_name", "BITRIX_SM");
		$favorites = $APPLICATION->get_cookie('UF_FAVORITES', $prefix);
		if(strlen($favorites) > 0) {
			$arFavorites = unserialize($favorites);
			if(!array_key_exists($productId, $arFavorites)) {
				$arFavorites[$productId] = array(
					'ID' => $productId,
					'DATE_ADD' => date('d.m.Y H:i:s'),
				);
			}
		} else {
			$arFavorites = array();
			$arFavorites[$productId] = array(
				'ID' => $productId,
				'DATE_ADD' => date('d.m.Y H:i:s'),
			);
		}
		$favorites = serialize($arFavorites);
		$APPLICATION->set_cookie('UF_FAVORITES',$favorites,time()+60*60*24*30*12,'/',SITE_SERVER_NAME);
	}
} elseif(($action == 'delete' || $action == 'remove' || $action == 'del') && $productId > 0) {
	if($userID > 0) {
		$rsUser = CUser::GetByID($userID);
		$arUser = $rsUser->Fetch();
		$favorites = $arUser['UF_FAVORITES'];
		if(strlen($favorites) > 0) {
			$arFavorites = unserialize($favorites);
			if(array_key_exists($productId, $arFavorites)) {
				unset($arFavorites[$productId]);
			}
		}
		$favorites = serialize($arFavorites);
		$fields = array(
			'UF_FAVORITES' => $favorites,
		);
		$USER->Update($userID,$fields);
	} else {
		$prefix = COption::GetOptionString("main", "cookie_name", "BITRIX_SM");
		$favorites = $APPLICATION->get_cookie('UF_FAVORITES', $prefix);
		if(strlen($favorites) > 0) {
			$arFavorites = unserialize($favorites);
			if(array_key_exists($productId, $arFavorites)) {
				unset($arFavorites[$productId]);
			}
		}
		$favorites = serialize($arFavorites);
		$APPLICATION->set_cookie('UF_FAVORITES',$favorites,time()+60*60*24*30*12,'/',SITE_SERVER_NAME);
	}
}

if(is_array($arFavorites) && $productId > 0) {
	$rsElement = CIBlockElement::GetByID($productId);
	$obElement = $rsElement->GetNextElement();
	$arElement = $obElement->getFields();
	if($arElement['PREVIEW_PICTURE'] > 0) {
		$arElement['PREVIEW_PICTURE'] = CFile::GetFileArray($arElement['PREVIEW_PICTURE']);
	}
	if($arElement['DETAIL_PICTURE'] > 0) {
		$arElement['DETAIL_PICTURE'] = CFile::GetFileArray($arElement['DETAIL_PICTURE']);
	}
	$arElement['PROPERTIES'] = $obElement->getProperties();
	$arFavorites[$arElement['ID']] = $arElement;
	$arResult['ITEMS'] = $arFavorites;
}

if($userID > 0) {
	$rsUser = CUser::GetByID($userID);
	$arUser = $rsUser->Fetch();
	$favorites = $arUser['UF_FAVORITES'];
	if(strlen($favorites) > 0) {
		$arFavorites = unserialize($favorites);
		$favItems = $arFavorites;
	}
} else {
	$prefix = COption::GetOptionString("main", "cookie_name", "BITRIX_SM");
	$favorites = $APPLICATION->get_cookie('UF_FAVORITES', $prefix);
	if(strlen($favorites) > 0) {
		$arFavorites = unserialize($favorites);
		$favItems = $arFavorites;
	}
}

if($arParams['GET_LIST'] == 'Y') {
	$arResult['ITEMS'] = $favItems;
	// $arResult['ITEMS'] = array();
	// foreach ($favItems as $arItem) {
	// 	$arResult['ITEMS'][] = $arItem['ID'];
	// }
	return $arResult;
}

if($arParams['FILTER_NAME']) {
	$arParams['FILTER_NAME'] = trim($arParams['FILTER_NAME']);
}

if(strlen($arParams['FILTER_NAME']) > 0) {

	global ${$arParams['FILTER_NAME']};
	$arrFilter = ${$arParams['FILTER_NAME']};
	if(!is_array($arrFilter)) {
		$arrFilter = array();
	}
	if(is_array($favItems) && count($favItems) > 0) {
		$arIds = array();
		foreach ($favItems as $id => $arItem) {
			$arIds[] = $arItem['ID'];
		}
		if(!array_key_exists('ID', $arrFilter)) {
			$arrFilter['ID'] = $arIds;
		} else {
			$arrFilter['ID'] = array_merge($arrFilter['ID'],$arIds);
			$arrFilter['ID'] = array_unique($arrFilter['ID']);
		}
	}
	${$arParams['FILTER_NAME']} = $arrFilter;
}

$arResult["THEME_COMPONENT"] = $this->getParent();
if(!is_object($arResult["THEME_COMPONENT"]))
	$arResult["THEME_COMPONENT"] = $this;

$this->includeComponentTemplate();