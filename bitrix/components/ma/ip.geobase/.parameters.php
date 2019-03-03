<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

//Получение списка всех городов
// if (CModule::IncludeModule('sale')) {
// 	$db_vars = CSaleLocation::GetList(array("CITY_NAME_LANG"=>"ASC"), array("LID" => LANGUAGE_ID), false, false, array());
// 	while ($vars = $db_vars->Fetch()) {
// 	    if ($vars['CITY_ID'] > 0) {
// 	        $cities[] = Array(
// 	            'NAME' => iconv(LANG_CHARSET, 'UTF-8', $vars['CITY_NAME']),
// 	            'ID' => $vars['ID']
// 	        );
// 	    }
// 	}
// 	foreach ($cities as $city) {
// 		$res[] = array(0 => $city['NAME']);
// 	}
// }

// $arComponentParameters = array(
// 	'PARAMETERS' => array(
// 		'SHOW_FAVORITE' => array(
// 			'NAME' => 'Показывать список избранных городов',
// 			'TYPE' => 'CHECKBOX',
// 			'PARENT' => 'BASE',
// 			'REFRESH' => 'Y',
// 		),

// 		'CACHE_TIME' => array(
// 			'DEFAULT' => 3600,
// 		),
// 		'SET_TITLE' => array(
// 			'DEFAULT' => 'N',
// 		),
// 	),
// );
// if ($arCurrentValues['SHOW_FAVORITE']) {
// 	$arComponentParameters['PARAMETERS']['FAVORITE_CITIES'] = array(
// 		'NAME' => 'Выберите какие города показывать всегда',
// 		'TYPE' => 'LIST',
// 		'MULTIPLE' => 'Y',
// 		'PARENT' => 'BASE',
// 		'VALUES' => $res,
// 		'SIZE' => 15
// 	);
// }

$arComponentParameters = array(

	"GROUPS" => array(

	),

	"PARAMETERS" => array(
		"FAVORITE_ITEMS" => array(
			"NAME" => "Избранные города",
			"TYPE" => "STRING",
			"PARENT" => "BASE",
			"MULTIPLE" => "Y",
		),
	),
);

?>