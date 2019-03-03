<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];

$arProperty = array();
$arProperty_LS = array();
//$arProperty_N = array();
$arProperty_X = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr = $rsProp->Fetch())
{
	$arProperty[$arr["ID"]] = $arr["NAME"];
	if(($arr["PROPERTY_TYPE"] == 'S' || $arr['PROPERTY_TYPE'] == 'N') && $arr['USER_TYPE'] == ''){
		$arProperty_LS[$arr["ID"]] = $arr["NAME"];
	}
	elseif($arr["PROPERTY_TYPE"] == "E"){
		$arProperty_X[$arr["ID"]] = $arr["NAME"];
	}
}

$arUnit = array(

    'px' => GetMessage("PX"),
    '%' => GetMessage("PR"),

);

$arDIRECTION_NAV_HIDE = array();

if($arCurrentValues['DIRECTION_NAV'] == 'Y'){
    
    $arDIRECTION_NAV_HIDE = array(
    
        "PARENT" => "DISPLAY",
		"NAME" => GetMessage("DIRECTION_NAV_HIDE"),
		"TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
        
    );

}

$arEffect = array(

    'random' => 'random',
    'sliceDown' => 'sliceDown',
    'sliceDownLeft' => 'sliceDownLeft',
    'sliceUp' => 'sliceUp',
    'sliceUpLeft' => 'sliceUpLeft',
    'sliceUpDown' => 'sliceUpDown',
    'sliceUpDownLeft' => 'sliceUpDownLeft',
    'fold' => 'fold',
    'fade' => 'fade',
    'slideInRight' => 'slideInRight',
    'slideInLeft' => 'slideInLeft',
    'boxRandom' => 'boxRandom',
    'boxRain' => 'boxRain',
    'boxRainReverse' => 'boxRainReverse',
    'boxRainGrow' => 'boxRainGrow',
    'boxRainGrowReverse' => 'boxRainGrowReverse'

);

//Для ссылок на слайдах
$arPropertySlide = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"], "PROPERTY_TYPE"=>"S"));
while ($arr=$rsProp->Fetch()){
    
	$arPropertySlide[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];

}
//


// 1. Что выводим.
// 2. Сортировка
// 3. Исключения: всех или по флагу
// 4. Количество
// 5. Внешний вид
// 5.1. Подключать ли жквери
// 5.2. Количество видимых элементов
// 5.3. Скорость прокрутки
// 5.4. Навигация вправо влево
// 5.4.1. Навигация поэлементно
// 5.5. Тип карусели: горизонтально или вертикально
// 5.6. Ширина и высота блока элемента карусели (ширина и высота самой карусели считается автоматически)


	$arComponentParameters = array(
		"GROUPS" => array(
			"DISPLAY" => array(
				"NAME" => GetMessage("DISPLAY"),
				"SORT" => "100",
			),
		),
		"PARAMETERS" => array(
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
			"ELEMENT_SORT_FIELD" => array(
				"PARENT" => "DATA_SOURCE",
				"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_FIELD"),
				"TYPE" => "LIST",
				"VALUES" => array(
					"shows" => GetMessage("IBLOCK_SORT_SHOWS"),
					"sort" => GetMessage("IBLOCK_SORT_SORT"),
					"timestamp_x" => GetMessage("IBLOCK_SORT_TIMESTAMP"),
					"name" => GetMessage("IBLOCK_SORT_NAME"),
					"id" => GetMessage("IBLOCK_SORT_ID"),
					"active_from" => GetMessage("IBLOCK_SORT_ACTIVE_FROM"),
					"active_to" => GetMessage("IBLOCK_SORT_ACTIVE_TO"),
					"rand" => GetMessage("IBLOCK_SORT_RAND"),
				),
				"ADDITIONAL_VALUES" => "Y",
				"DEFAULT" => "sort",
			),
			"ELEMENT_SORT_ORDER" => array(
				"PARENT" => "DATA_SOURCE",
				"NAME" => GetMessage("IBLOCK_ELEMENT_SORT_ORDER"),
				"TYPE" => "LIST",
				"VALUES" => array(
					"asc" => GetMessage("IBLOCK_SORT_ASC"),
					"desc" => GetMessage("IBLOCK_SORT_DESC"),
				),
				"DEFAULT" => "asc",
				"ADDITIONAL_VALUES" => "Y",
			),
			"ELEMENT_FLAG_LIMIT" => array(
				"PARENT" => "DATA_SOURCE",
				"NAME" => GetMessage("ELEMENT_FLAG_LIMIT"),
				"TYPE" => "LIST",
				"ADDITIONAL_VALUES" => "Y",
				"VALUES" => $arProperty_X,
			),
			"ELEMENT_COUNT" => array(
				"PARENT" => "DATA_SOURCE",
				"NAME" => GetMessage("ELEMENT_COUNT"),
				"TYPE" => "STRING",
				"DEFAULT" => "10",
			),
			"USE_JQUERY" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("USE_JQUERY"),
				"TYPE" => "CHECKBOX",
				"DEFAULT" => "Y",
			),
            "ELEMENT_WIDTH" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("ELEMENT_WIDTH"),
				"TYPE" => "STRING",
				"DEFAULT" => "1000",
			),
            /*"ELEMENT_WIDTH_UNIT" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("ELEMENT_WIDTH_UNIT"),
				"TYPE" => "LIST",
				"VALUES" => $arUnit,
                "DEFAULT" => "px",
			),*/
			"ELEMENT_HEIGHT" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("ELEMENT_HEIGHT"),
				"TYPE" => "STRING",
				"DEFAULT" => "400",
			),
            /*"ELEMENT_HEIGHT_UNIT" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("ELEMENT_HEIGHT_UNIT"),
				"TYPE" => "LIST",
				"VALUES" => $arUnit,
                "DEFAULT" => "px",
			),*/
            "BOX_COLS" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("BOX_COLS"),
				"TYPE" => "STRING",
                "DEFAULT" => "8",
            ),
            "BOX_ROWS" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("BOX_ROWS"),
				"TYPE" => "STRING",
                "DEFAULT" => "4",
            ),
            "AMIMATE_SPEED" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("AMIMATE_SPEED"),
				"TYPE" => "STRING",
                "DEFAULT" => "500",
            ),
            "ANIMATE_EFFECT" => array(
				"PARENT" => "DISPLAY",
				"NAME" => GetMessage("ANIMATE_EFFECT"),
				"TYPE" => "LIST",
				"VALUES" => $arEffect,
                "DEFAULT" => "random",
			),
            "PAUSE_SPEED" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("PAUSE_SPEED"),
				"TYPE" => "STRING",
                "DEFAULT" => "3000",
            ),
            "DIRECTION_NAV" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("DIRECTION_NAV"),
				"TYPE" => "CHECKBOX",
                "DEFAULT" => "N",
                "REFRESH" => "Y",
            ),
            "DIRECTION_NAV_HIDE" => $arDIRECTION_NAV_HIDE,
            "CONTROL_NAV" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("CONTROL_NAV"),
				"TYPE" => "CHECKBOX",
                "DEFAULT" => "N",
                "REFRESH" => "Y",
            ),
            "MANUAL_ADVANCE" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("MANUAL_ADVANCE"),
				"TYPE" => "CHECKBOX",
                "DEFAULT" => "Y",
            ),
            "PAUSE_ON_HOVER" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("PAUSE_ON_HOVER"),
				"TYPE" => "CHECKBOX",
                "DEFAULT" => "N",
            ),
            "NEXT_TEXT" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("NEXT_TEXT"),
				"TYPE" => "STRING",
                "DEFAULT" => "",
            ),
            "PREV_TEXT" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("PREV_TEXT"),
				"TYPE" => "STRING",
                "DEFAULT" => "",
            ),
            "RANDOM_START" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("RANDOM_START"),
				"TYPE" => "CHECKBOX",
                "DEFAULT" => "N",
            ),
            "NAME_IN_TITLE" => array(
                "PARENT" => "DISPLAY",
				"NAME" => GetMessage("NAME_IN_TITLE"),
				"TYPE" => "CHECKBOX",
                "DEFAULT" => "N",
            ),
            "PROPERTY_TO_LINK" => array(
        		"PARENT" => "DISPLAY",
        		"NAME" => GetMessage("PROPERTY_TO_LINK"),
        		"TYPE" => "LIST",
        		"MULTIPLE" => "N",
        		"VALUES" => $arPropertySlide,
                "ADDITIONAL_VALUES" => "Y",
                "DEFAULT" => ""
        	)
		),
	);
    
    if($arCurrentValues['DIRECTION_NAV'] != 'Y'){
        
        unset($arComponentParameters["PARAMETERS"]["DIRECTION_NAV_HIDE"]);
        
    }
    
    if(!$arPropertySlide){
        
        unset($arComponentParameters["PARAMETERS"]["PROPERTY_TO_LINK"]);
        
    }


?>