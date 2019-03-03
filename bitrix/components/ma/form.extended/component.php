<?
	if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

	// PROPERTY_TYPES: 
	// "S" - строка 
	// "N" - число 
	// "L" - список 
	// "F" - файл 
	// "G" - привязка к разделу 
	// "E" - привязка к элементу

	if(!CModule::IncludeModule('iblock'))
	{
		ShowError(GetMessage('IBLOCK_MODULE_NOT_INSTALLED'));
		return 0;
	}

	$arResult = array();

	if(!isset($arParams['CACHE_TIME']))
		$arParams['CACHE_TIME'] = 36000000;

	$arParams['IBLOCK_TYPE'] = trim($arParams['IBLOCK_TYPE']);
	$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);

	// Уникальный идентификатор формы
	if(!empty($arParams['FORM_ID'])){
		$arResult['FORM_ID'] = $arParams['FORM_ID'];
	}
	else {
		$arResult['FORM_ID'] = $arParams['IBLOCK_ID'];
	}
	
	if(empty($arParams['EMAIL_TO']))
	{
		$rsSites = CSite::GetByID(SITE_ID);
		$arSite = $rsSites->Fetch();
		$arParams['EMAIL_TO'] = $arSite['EMAIL'];

		if(empty($arParams['EMAIL_TO']) && $arParams['SEND_EMAIL_FORM'] == 'Y')
		{
			$arResult['ERRORS'][] = 'EMAIL_FIELD_ERROR';
		}
	}

	// Текст инфоблока
	$res = CIBlock::GetByID($arParams['IBLOCK_ID']);
	if($arElement = $res->GetNext())
	{
		$arResult['DESCRIPTION_FORM'] = $arElement['DESCRIPTION'];
	}

	// Поля формы из полей инфоблока
	$arField = CIBlock::GetFields($arParams['IBLOCK_ID']);
	foreach ($arParams['USE_FORM_ITEM_ID'] as $valueName) 
	{	
		if(is_array($arField[$valueName]))
		{

			$arValue = array();
			$arValue = $arField[$valueName];
			$arValue['ID'] = $valueName;

			if($valueName == 'IBLOCK_SECTION'){ 
				$arValue['PROPERTY_TYPE'] = 'L'; 
				$arValue['LIST_TYPE'] = 'L';
				$arValue['MULTIPLE'] = 'N';

				$arSectionFilter = array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'GLOBAL_ACTIVE'=>'Y');
				$arSectionSelect = array('ID', 'NAME');
				$dbSectionList = CIBlockSection::GetList(Array('name'=>'ASC'), $arSectionFilter, false, $arSectionSelect);
				while($arSectionResult = $dbSectionList->GetNext())
				{	
					$arSection[$arSectionResult['ID']]['ID'] = $arSectionResult['ID'];
					$arSection[$arSectionResult['ID']]['VALUE'] = $arSectionResult['NAME'];
				}

				$arValue['VALUE_LIST'] = $arSection;
				
			}
			elseif($valueName == 'NAME'){ 
				$arValue['PROPERTY_TYPE'] = 'S'; 
			}
			elseif($valueName == 'PREVIEW_TEXT'){ 
				$arValue['PROPERTY_TYPE'] = 'S'; 
				$arValue['USER_TYPE'] = 'HTML'; 
			}
			elseif($valueName == 'DETAIL_TEXT'){ 
				$arValue['PROPERTY_TYPE'] = 'S'; 
				$arValue['USER_TYPE'] = 'HTML';
			}
			elseif($valueName == 'PREVIEW_PICTURE'){ 
				$arValue['PROPERTY_TYPE'] = 'F'; 
				$arValue['FILE_TYPE'] = '';
			}
			elseif($valueName == 'DETAIL_PICTURE'){ 
				$arValue['PROPERTY_TYPE'] = 'F'; 
				$arValue['FILE_TYPE'] = '';
			}
			elseif($valueName == 'IBLOCK_SECTION_ID'){ 
				$arValue['PROPERTY_TYPE'] = 'L'; 
			}
			elseif($valueName == 'ACTIVE_FROM'){ 
				$arValue['PROPERTY_TYPE'] = 'S'; 
				$arValue['USER_TYPE'] = 'DateTime';
			}
			elseif($valueName == 'ACTIVE_TO'){ 
				$arValue['PROPERTY_TYPE'] = 'S'; 
				$arValue['USER_TYPE'] = 'DateTime';
			}
			elseif($valueName == 'SORT'){ 
				$arValue['PROPERTY_TYPE'] = 'N'; 
			}

			$arResult['FORM_ITEMS'][$valueName] = $arValue;
			
		}
	}

    // Поля формы из свойств инфоблока
	$properties = CIBlockProperty::GetList(array('sort'=>'asc'), array(
		'ACTIVE' => 'Y', 
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
	));
	while($arProp = $properties->GetNext())
	{
		if(in_array($arProp['ID'], $arParams['USE_FORM_ITEM_ID']))
		{
			if($arProp['PROPERTY_TYPE'] == 'L')
			{
				$dbEnumList = CIBlockProperty::GetPropertyEnum($arProp['ID']);
				while($arEnumList = $dbEnumList->GetNext()){
					$arProp['VALUE_LIST'][$arEnumList['ID']] = $arEnumList;
				}
			}
			$arResult['FORM_ITEMS'][$arProp['ID']] = $arProp;
		}
	}

	//Делаем подмену параметра для тех у кого установлены параметры со старой версии формы, чтобы капча работала без обновления настроек
	if ($arParams['USE_COLOR_CAPTCHA'] == "Y") {
		$arParams['USE_CAPTCHA'] = 'COLOR_CAPTCHA';
	}

	if($arParams['USE_CAPTCHA'] == 'COLOR_CAPTCHA' || ($arParams['USE_COLOR_CAPTCHA'] == 'Y' && $arParams['USE_CAPTCHA'] != 'GRAHIC_CAPTCHA' && $arParams['USE_CAPTCHA'] != 'HIDDEN_CAPTCHA')) {
		 // массив цветов для капчи по умолчанию
	    $arParams['CAPTCHA_ITEM_ALL'] = array(
	    	array('COLOR' => 'FF0033', 'NAME' => GetMessage('COLOR_FF0033')), // красный
	    	array('COLOR' => '009933', 'NAME' => GetMessage('COLOR_009933')), // зелёный
	    	array('COLOR' => '0066FF', 'NAME' => GetMessage('COLOR_0066FF')), // синий
	    	array('COLOR' => '000000', 'NAME' => GetMessage('COLOR_000000')), // черный
	    	array('COLOR' => 'FFFF00', 'NAME' => GetMessage('COLOR_FFFF00')), // желтый
	    	array('COLOR' => 'FF9900', 'NAME' => GetMessage('COLOR_FF9900')), // оранжевый
	    	array('COLOR' => '996600', 'NAME' => GetMessage('COLOR_996600')), // коричневый
	    	array('COLOR' => 'CC00CC', 'NAME' => GetMessage('COLOR_CC00CC')), // фиолетовый
	    );
	    $arParams['CAPTCHA_COUNT'] = 4;
	    $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['ID'] = 'captcha';
        $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['PROPERTY_TYPE'] = 'COLOR_CAPTCHA';
        $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['IS_REQUIRED'] = 'Y';
	}
	elseif($arParams['USE_CAPTCHA'] == 'GRAHIC_CAPTCHA' || ($arParams['USE_COLOR_CAPTCHA'] == 'Y' && $arParams['USE_CAPTCHA'] != 'HIDDEN_CAPTCHA'))
	{
	    $arParams['CAPTCHA_ITEM_ALL'] = array(
	    	array('COLOR' => 'SQUARE', 'NAME' => GetMessage('SHAPE_SQUARE')), // квадрат
	    	array('COLOR' => 'RECTANGLE', 'NAME' => GetMessage('SHAPE_RECTANGLE')), // прямоугольник
	    	array('COLOR' => 'TRIANGLE', 'NAME' => GetMessage('SHAPE_TRIANGLE')), // треугольник
	    	array('COLOR' => 'ROUND', 'NAME' => GetMessage('SHAPE_ROUND')), // круг
	    	array('COLOR' => 'POLYHEDRON', 'NAME' => GetMessage('SHAPE_POLYHEDRON')), // многогранник
	    	array('COLOR' => 'TRAPEZE', 'NAME' => GetMessage('SHAPE_TRAPEZE')), // трапеция
	    	array('COLOR' => 'RHOMBUS', 'NAME' => GetMessage('SHAPE_RHOMBUS')), // ромб
	    	array('COLOR' => 'OVAL', 'NAME' => GetMessage('SHAPE_OVAL')), // овал
	    	array('COLOR' => 'STAR', 'NAME' => GetMessage('SHAPE_STAR')), // звезда
	    );
	    $arParams['CAPTCHA_COUNT'] = 4;
	    $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['ID'] = 'captcha';
        $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['PROPERTY_TYPE'] = 'GRAHIC_CAPTCHA';
        $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['IS_REQUIRED'] = 'Y';
	}
	elseif($arParams['USE_CAPTCHA'] == 'HIDDEN_CAPTCHA')
	{
	    $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['ID'] = 'captcha';
        $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['PROPERTY_TYPE'] = 'HIDDEN_CAPTCHA';
	}


	// Данные редактируемого элемента
	global $USER;
	$ELEMENT_ID = intval($_GET['id']);
	if($arParams['CHANGE_ITS_ELEMENT'] == 'Y' && $USER->IsAuthorized() && $ELEMENT_ID > 0 && empty($_POST))
	{
		$USER_ID = $USER->GetID();

	    $arFilter = array(
	        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
	        "IBLOCK_LID" => SITE_ID,
	        "INCLUDE_SUBSECTIONS" => Y,
	        "ID" => $ELEMENT_ID,
	        "CREATED_USER_ID" => $USER_ID
	    );
	    $arSort = array(
	        "created" => "desc",
	    );
	    $arSelectFields = array();
	    

	    $arResult['ITEMS'] = array();
	    $rsElements = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelectFields);
	    if($obElement = $rsElements->GetNextElement())
	    {
	    	$arItem = $obElement->GetFields();
	    	$arItem['_PROPERTIES'] = $obElement->GetProperties();
	    	foreach ($arItem['_PROPERTIES'] as $key => $value) {
	    		$arItem['PROPERTIES'][$value['ID']] = $value;
	    	}
	        $arResult['ELEMENT'] = $arItem;

	    }

	    // Обработка данных для формы
	    foreach ($arResult['FORM_ITEMS'] as $key => $arProperties) 
	    {
	    	if($arProperties['ID'] == 'IBLOCK_SECTION'){
	    		$arResult['POST']['FIELD_IBLOCK_SECTION'] = $arResult['ELEMENT']['IBLOCK_SECTION_ID'];
	    	}
	    	elseif($arProperties['ID'] == 'NAME'){
	    		$arResult['POST']['FIELD_'.$arProperties['ID']] = $arResult['ELEMENT']['NAME'];
	    	}
	    	elseif($arProperties['ID'] == 'PREVIEW_TEXT'){
	    		$arResult['POST']['FIELD_'.$arProperties['ID']] = $arResult['ELEMENT']['PREVIEW_TEXT'];
	    	}
	    	elseif($arProperties['ID'] == 'DETAIL_TEXT'){
	    		$arResult['POST']['FIELD_'.$arProperties['ID']] = $arResult['ELEMENT']['DETAIL_TEXT'];
	    	}
	    	elseif($arProperties['ID'] == 'PREVIEW_PICTURE'){
	    		if($arResult['ELEMENT']['PREVIEW_PICTURE'] > 0){
	    			$arResult['POST']['FIELD_'.$arProperties['ID']] = CFile::GetFileArray($arResult['ELEMENT']['PREVIEW_PICTURE']);
	    		}
	    	}
	    	elseif($arProperties['ID'] == 'DETAIL_PICTURE'){
	    		if($arResult['ELEMENT']['DETAIL_PICTURE'] > 0){
	    			$arResult['POST']['FIELD_'.$arProperties['ID']] = CFile::GetFileArray($arResult['ELEMENT']['DETAIL_PICTURE']);
	    		}
	    	}
	    	elseif($arProperties['ID'] == 'ACTIVE_FROM'){
	    		$arResult['POST']['FIELD_'.$arProperties['ID']] = $arResult['ELEMENT']['ACTIVE_FROM'];
	    	}
	    	elseif($arProperties['ID'] == 'ACTIVE_TO'){
	    		$arResult['POST']['FIELD_'.$arProperties['ID']] = $arResult['ELEMENT']['ACTIVE_TO'];
	    	}
	    	elseif($arProperties['ID'] == 'SORT'){
	    		$arResult['POST']['FIELD_'.$arProperties['ID']] = $arResult['ELEMENT']['SORT'];
	    	}
	    	else {
	    		$valElement = $arResult['ELEMENT']['PROPERTIES'][$arProperties['ID']];

	    		if($valElement['VALUE_ENUM_ID'] > 0){
	    			$arResult['POST']['FIELD_'.$arProperties['ID']] = $valElement['VALUE_ENUM_ID'];	
	    		}
	    		elseif($valElement['PROPERTY_TYPE'] == 'F' && $valElement['MULTIPLE'] == 'Y'){
	    			foreach ($valElement['VALUE'] as $kid => $vid) {
	    				$arResult['POST']['FIELD_'.$arProperties['ID']][$kid] = CFile::GetFileArray($vid);
	    			}
	    		}
	    		elseif($valElement['PROPERTY_TYPE'] == 'F' && $valElement['MULTIPLE'] != 'Y'){
	    			$arResult['POST']['FIELD_'.$arProperties['ID']] = CFile::GetFileArray($valElement['VALUE']);
	    		}
	    		else {
	    			$arResult['POST']['FIELD_'.$arProperties['ID']] = $valElement['VALUE'];	
	    		}
	    	}

	    }

	}

	//dump($arResult['POST']);

	// Обработка формы перед отправкой
	if(!empty($_POST) && $_POST['FORM_ID'] == $arResult['FORM_ID'])
	{
		$arResult['CHECK_FIELDS'] = 'SUCCESS';

		// обработка входящих данных
		foreach ($_POST as $key => $value) 
		{
			if(is_array($value)) {
				foreach ($value as $v){
					$arResult['POST'][$key][] = $v;
				}
			}
			else {
				$arResult['POST'][$key] = htmlspecialchars($value);
			}
		}
        
		foreach ($arResult['FORM_ITEMS'] as $key => $arProperties) 
		{
			// Проверка на ошибки
			if($arProperties['PROPERTY_TYPE'] == 'COLOR_CAPTCHA' || $arProperties['PROPERTY_TYPE'] == 'GRAHIC_CAPTCHA') 
			{
				if(empty($arResult['POST']['captcha']) || $arResult['POST']['captcha'] != strtolower($arParams['CAPTCHA_ITEM_ALL'][$_SESSION['CAPTCHA_ID'][$arResult['FORM_ID']]]['COLOR']))
				{
					$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['ERROR'] = GetMessage('COLOR_CAPTCHA_ERROR');
					$arResult['CHECK_FIELDS'] = 'ERROR';
				}
			}
			elseif($arProperties['PROPERTY_TYPE'] == 'HIDDEN_CAPTCHA' && strlen($arResult['POST']['captcha']) > 0)
			{
				$arResult['CHECK_FIELDS'] = 'ERROR';
			}
			elseif($arProperties['IS_REQUIRED'] == 'Y' && $arProperties['PROPERTY_TYPE'] != 'F' && empty($arResult['POST']['FIELD_'.$arProperties['ID']]))
			{
				$arResult['FORM_ITEMS'][$key]['ERROR'] = GetMessage('FORM_FIELD_ERROR');
				$arResult['CHECK_FIELDS'] = 'ERROR';
			}
			elseif($arProperties['IS_REQUIRED'] == 'Y' && $arProperties['PROPERTY_TYPE'] == 'F' && empty($_FILES['FIELD_'.$arProperties['ID']]['name']))
			{
				$arResult['FORM_ITEMS'][$key]['ERROR'] = GetMessage('FORM_FIELD_ERROR');
				$arResult['CHECK_FIELDS'] = 'ERROR';
			}
			elseif(!empty($arResult['POST']['FIELD_'.$arProperties['ID']]))
			{
				// Проверка регулярными выражанеями
				$regexp = isset($arParams['VALID_'.$arProperties['ID']]) ? $arParams['VALID_'.$arProperties['ID']] : '';
				$propertyValue = $arResult['POST']['FIELD_'.$arProperties['ID']];

				if($regexp)
				{
					if(is_array($propertyValue))
					{
						foreach($propertyValue as $val)
						{
							if(!preg_match('/'.$regexp.'/', trim($val), $matches))
							{
								$arResult['FORM_ITEMS'][$key]['ERROR'] = GetMessage('FORM_FIELD_ERROR_REG_EXP');
								$arResult['CHECK_FIELDS'] = 'ERROR';
								break;
							}
						}
					}
					else 
					{
						if(!preg_match('/'.$regexp.'/', trim($propertyValue), $matches)) 
						{
							$arResult['FORM_ITEMS'][$key]['ERROR'] = GetMessage('FORM_FIELD_ERROR_REG_EXP');
							$arResult['CHECK_FIELDS'] = 'ERROR';
						}
					}
				}
			}

			// Если файл, дополтнительно проверяем
			if($arProperties['PROPERTY_TYPE'] == 'F')
			{
				$arrFile = $_FILES['FIELD_'.$arProperties['ID']];
				$res = CFile::CheckFile($arrFile, $arParams['FILES_UPLOAD_MAX_FILESIZE'], false, $arProperties['FILE_TYPE']);
				if(strlen($res) > 0) {
					$arResult['FORM_ITEMS'][$key]['ERROR'] = $res;
					$arResult['CHECK_FIELDS'] = 'ERROR';
				}
			}

			// Сбор сообщния формы в текс и массив
			if(($arProperties['PROPERTY_TYPE'] == 'S' || $arProperties['PROPERTY_TYPE'] == 'N') && $arProperties['MULTIPLE'] == 'N') 
			{
				$dataValue = $arResult['POST']['FIELD_'.$arProperties['ID']];
				$arResult['FORM_MESSAGE'].= $arProperties['NAME'].': '.$dataValue."\r\n";
				$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']] = $dataValue;
			}
			elseif(($arProperties['PROPERTY_TYPE'] == 'S' || $arProperties['PROPERTY_TYPE'] == 'N') && $arProperties['MULTIPLE'] == 'Y') 
			{
				$arResult['FORM_MESSAGE'].= $arProperties['NAME'].': ';
				foreach ($arResult['POST']['FIELD_'.$arProperties['ID']] as $key => $value) {
					if(!empty($value)){
						$arResult['FORM_MESSAGE'].= $value.', ';
						$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']][] = $value;
					}
				}
				$arResult['FORM_MESSAGE'].= "\r\n";
			}
			elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['MULTIPLE'] == 'N')
			{
				$idValue = intval($arResult['POST']['FIELD_'.$arProperties['ID']]);
				$dataValue = $arProperties['VALUE_LIST'][$idValue]['VALUE'];
				$arResult['FORM_MESSAGE'].= $arProperties['NAME'].': '.$dataValue."\r\n";
				$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']] = $idValue;
			}
			elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['MULTIPLE'] == 'Y')
			{
				$arResult['FORM_MESSAGE'].= $arProperties['NAME'].': ';
				foreach ($arResult['POST']['FIELD_'.$arProperties['ID']] as $key => $value) {
					$idValue = intval($value);
					$dataValue = $arProperties['VALUE_LIST'][$idValue]['VALUE'];
					$arResult['FORM_MESSAGE'].= $dataValue.', ';
					$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']][] = $idValue;
				}
				$arResult['FORM_MESSAGE'].= "\r\n";
			}
			elseif($arProperties['PROPERTY_TYPE'] == 'F' && $arProperties['MULTIPLE'] != 'Y') 
			{
				$dataValue = $_FILES['FIELD_'.$arProperties['ID']];
				$arResult['FORM_MESSAGE'].= $arProperties['NAME'].': '.$dataValue['name']."\r\n";
				$arNewFile = CIBlock::ResizePicture($dataValue, array(
                    "WIDTH" => 1800,
                    "HEIGHT" => 1800,
                    "METHOD" => "resample",
                ));
				$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']] = $arNewFile;
			}
			elseif($arProperties['PROPERTY_TYPE'] == 'F' && $arProperties['MULTIPLE'] == 'Y') 
			{
				for ($i=0; $i < $arProperties['MULTIPLE_CNT']; $i++){
					$dataValue = $_FILES['FIELD_'.$arProperties['ID'].'_'.$i];
					$arResult['FORM_MESSAGE'].= $arProperties['NAME'].': '.$dataValue['name']."\r\n";
					$arNewFile = CIBlock::ResizePicture($dataValue, array(
	                    "WIDTH" => 1800,
	                    "HEIGHT" => 1800,
	                    "METHOD" => "resample",
	                ));
					$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']][$i] = $arNewFile;
				}


				
			}
		}

		if($arResult['CHECK_FIELDS'] == 'SUCCESS')
		{
			// Отправка почтового сообщения
			if($arParams['SEND_EMAIL_FORM'] == 'Y' && !empty($arParams['EMAIL_TO']))
			{
				$arEventFields = array(
					'EMAIL_TO' => $arParams['EMAIL_TO'],
					'TEXT' => $arResult['FORM_MESSAGE'],
				);
                
                $postEvent = 'FEEDBACK_FORM';
                
                //Для заявок (костыль)
                
                if(!empty($_REQUEST['buyid']) && !empty($_REQUEST['cid'])){
                    $postEvent = 'ORDER_APPLICATION';
                    $rsUser = CUser::GetByID($_REQUEST['cid']);
                    $arUser = $rsUser->Fetch();
                    //$arEventFields['AD_AUTHOR_NAME'] = ($arUser['NAME'] ? $arUser['NAME'] : ($arUser['ID'] == 1 ? 'mrlandry' : $arUser['LOGIN']));
                    $arEventFields['AD_AUTHOR_NAME'] = $arResult['POST']['FIELD_82'];
                    $arEventFields["PHONE"] = $arResult['POST']['FIELD_83'];
                    $arEventFields["COMMENT"] = $arResult['POST']['FIELD_84'];
                    
                    if(CModule::IncludeModule("iblock")){
                        $res = CIBlockElement::GetByID($_REQUEST["buyid"]);
                        if($ar_res = $res->GetNext()){
                            $arEventFields['AD_NAME'] = $ar_res['NAME'];
                            $arEventFields['AD_ID'] = $_REQUEST["buyid"];
                        }
                    }
                    
                }
                
                //---!!Для заявок (костыль)
                
				if(CEvent::Send($postEvent, SITE_ID, $arEventFields, 'N', $arParams['EVENT_MESSAGE_ID'])){
					$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_OK';
				}
				else {
					$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_ERROR';
					$arResult['MESSAGE_RESULT_ERROR_TEXT'] = GetMessage('MESSAGE_RESULT_ERROR_TEXT');
				}
			}

			// Сбор данных для сохранение или изменения
			if(($arParams['SAVE_TO_IBLOCK'] == 'Y' || $arParams['CHANGE_ITS_ELEMENT'] == 'Y') && !empty($arParams['IBLOCK_ID']))
			{
				$oElement = new CIBlockElement;
				$PROP = array();
				foreach ($arResult['FORM_ITEMS'] as $key => $arItem) 
				{
					if($arItem['PROPERTY_TYPE'] == 'S' && $arItem['MULTIPLE'] == 'N' && ($arItem['USER_TYPE'] == 'HTML' || $arItem['USER_TYPE'] == 'TEXT'))
					{
						$PROP[$arItem['ID']] = array('VALUE'=>array('TEXT'=>$arResult['FORM_IBLOCK_DATA'][$arItem['ID']], 'TYPE'=>$arItem['USER_TYPE']));
					}
					elseif($arItem['PROPERTY_TYPE'] == 'S' && $arItem['MULTIPLE'] == 'Y' && ($arItem['USER_TYPE'] == 'HTML' || $arItem['USER_TYPE'] == 'TEXT'))
					{
						for ($i=0; $i < count($arResult['FORM_IBLOCK_DATA'][$arItem['ID']]); $i++){
							$PROP[$arItem['ID']][$i] = array('VALUE'=>array('TEXT'=>$arResult['FORM_IBLOCK_DATA'][$arItem['ID']][$i], 'TYPE'=>$arItem['USER_TYPE']));
						}
					}
					elseif($arItem['PROPERTY_TYPE'] == 'L' && $arItem['MULTIPLE'] == 'Y')
					{
						foreach ($arResult['FORM_IBLOCK_DATA'][$arItem['ID']] as $id) {
							$PROP_VALUES[]['VALUE'] = $id;
						}
						$PROP[$arItem['ID']] = $PROP_VALUES;
					}
					elseif($arItem['PROPERTY_TYPE'] == 'F' && $arItem['MULTIPLE'] != 'Y') {
						$PROP[$arItem['ID']] = $_FILES['FIELD_'.$arItem['ID']];
					}
					elseif($arItem['PROPERTY_TYPE'] == 'F' && $arItem['MULTIPLE'] == 'Y') {
						for ($i=0; $i < count($arResult['FORM_IBLOCK_DATA'][$arItem['ID']]); $i++){
							$PROP[$arItem['ID']][$i] = $arResult['FORM_IBLOCK_DATA'][$arItem['ID']][$i];
						}
					}
					else 
					{
						$PROP[$arItem['ID']] = $arResult['FORM_IBLOCK_DATA'][$arItem['ID']];
					}
				}

				$arLoadProductArray = Array(
					'IBLOCK_ID'         => $arParams['IBLOCK_ID'],
					'PROPERTY_VALUES'   => $PROP,
				);

				if($arParams['SAVE_ACTIVE'] == 'N') {
					$arLoadProductArray['ACTIVE'] = 'N';
				}
				else {
					$arLoadProductArray['ACTIVE'] = 'Y';
				}
				
				if($arResult['FORM_IBLOCK_DATA']['IBLOCK_SECTION']){
					$arLoadProductArray['IBLOCK_SECTION_ID'] = $arResult['FORM_IBLOCK_DATA']['IBLOCK_SECTION'];
				}
				else {
					$arLoadProductArray['IBLOCK_SECTION_ID'] = false;	
				}

				if($arResult['FORM_IBLOCK_DATA']['NAME']){
					$arLoadProductArray['NAME'] = $arResult['FORM_IBLOCK_DATA']['NAME'];
				}
				else {
					$arLoadProductArray['NAME'] = GetMessage('ELEMENT_TITLE').' '.date('d.m.Y');	
				}
                
                //$arLoadProductArray['CODE'] = Cutil::translit($arLoadProductArray['NAME'], 'ru', array('change_case' => 'L','replace_other'=>'-', 'replace_space'=>'-'));
                
				if($arResult['FORM_IBLOCK_DATA']['PREVIEW_TEXT']){
					$arLoadProductArray['PREVIEW_TEXT'] = $arResult['FORM_IBLOCK_DATA']['PREVIEW_TEXT'];
				}
				if($arResult['FORM_IBLOCK_DATA']['DETAIL_TEXT']){
					$arLoadProductArray['DETAIL_TEXT'] = $arResult['FORM_IBLOCK_DATA']['DETAIL_TEXT'];
				}

				if($arResult['FORM_IBLOCK_DATA']['PREVIEW_PICTURE']){
					$arLoadProductArray['PREVIEW_PICTURE'] = $arResult['FORM_IBLOCK_DATA']['PREVIEW_PICTURE'];
				}
				if($arResult['FORM_IBLOCK_DATA']['DETAIL_PICTURE']){
					$arLoadProductArray['DETAIL_PICTURE'] = $arResult['FORM_IBLOCK_DATA']['DETAIL_PICTURE'];
				}

				if($arResult['FORM_IBLOCK_DATA']['ACTIVE_FROM']){
					$arLoadProductArray['DATE_ACTIVE_FROM'] = $arResult['FORM_IBLOCK_DATA']['ACTIVE_FROM'];
				}
				else {
					$arLoadProductArray['DATE_ACTIVE_FROM'] = date('d.m.Y H:i:s');	
				}
				if($arResult['FORM_IBLOCK_DATA']['ACTIVE_TO']){
					$arLoadProductArray['DATE_ACTIVE_TO'] = $arResult['FORM_IBLOCK_DATA']['ACTIVE_TO'];
				}

				// Изменение данные в инфоблоке
				if($arParams['CHANGE_ITS_ELEMENT'] == 'Y' && $USER->IsAuthorized() && $ELEMENT_ID > 0)
				{
					if($oElement->Update($ELEMENT_ID, $arLoadProductArray)){
						$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_OK';
					}
					else {
						$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_ERROR';
						$arResult['MESSAGE_RESULT_ERROR_TEXT'] = 'ERROR: '.$oElement->LAST_ERROR;
					}
				}
				// Сохрание данных в инфоблоке
				elseif($arParams['SAVE_TO_IBLOCK'] == 'Y' && !empty($arParams['IBLOCK_ID']))
				{
					if($PRODUCT_ID = $oElement->Add($arLoadProductArray)){
						$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_OK';
					}
					else {
						$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_ERROR';
						$arResult['MESSAGE_RESULT_ERROR_TEXT'] = 'ERROR: '.$oElement->LAST_ERROR;
					}
				}
			}
		}
		elseif($arResult['CHECK_FIELDS'] == 'ERROR')
		{
			$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_ERROR';
			$arResult['MESSAGE_RESULT_ERROR_TEXT'] = GetMessage('MESSAGE_RESULT_ERROR_TEXT');
		}

	}

	// Капча формы
	if($arParams['USE_CAPTCHA'] == 'COLOR_CAPTCHA' || ($arParams['USE_COLOR_CAPTCHA'] == 'Y' && $arParams['USE_CAPTCHA'] != 'GRAHIC_CAPTCHA'))
	{
		$arColor = array_rand($arParams['CAPTCHA_ITEM_ALL'], $arParams['CAPTCHA_COUNT']);
		foreach($arColor as $count) {
			$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['CAPTCHA_COLORS_USE'][$count] = $arParams['CAPTCHA_ITEM_ALL'][$count];
		}

        $ID = array_rand($arColor, 1);
        $colorID = $arColor[$ID];
        $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['CAPTCHA_ID'] = $colorID;  // индекс текущего цвета

        // session_name('captcha');
        // session_start();
		$_SESSION['CAPTCHA_ID'] = array();
        $_SESSION['CAPTCHA_ID'][$arResult['FORM_ID']] = $colorID;

		$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['NAME'] = GetMessage("LABEL_COLOR_CAPTCHA", Array ("#COLOR_NAME#" => $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['CAPTCHA_COLORS_USE'][$colorID]['NAME']));
	}
	elseif($arParams['USE_CAPTCHA'] == 'GRAHIC_CAPTCHA')
	{
		$arColor = array_rand($arParams['CAPTCHA_ITEM_ALL'], $arParams['CAPTCHA_COUNT']);
		foreach($arColor as $count) {
			$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['CAPTCHA_COLORS_USE'][$count] = $arParams['CAPTCHA_ITEM_ALL'][$count];
		}

        $ID = array_rand($arColor, 1);
        $colorID = $arColor[$ID];
        $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['CAPTCHA_ID'] = $colorID;  // индекс текущего цвета

        // session_name('captcha');
        // session_start();
		$_SESSION['CAPTCHA_ID'] = array();
        $_SESSION['CAPTCHA_ID'][$arResult['FORM_ID']] = $colorID;

		$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['NAME'] = GetMessage("LABEL_GRAHIC_CAPTCHA", Array ("#CODE#" => $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['CAPTCHA_COLORS_USE'][$colorID]['NAME']));
	}

	if($arParams['USE_JQUERY'] == 'Y')
	{
		$APPLICATION->AddHeadScript('http://yandex.st/jquery/1.7.1/jquery.min.js');
	}

	$this->IncludeComponentTemplate();

?>
