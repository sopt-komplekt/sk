<?
	if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

	// PROPERTY_TYPES: 
	// "S" - string
	// "N" - number
	// "L" - list
	// "F" - file
	// "G" - binding to section
	// "E" - binding to element

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
	
	// Unique Form ID
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

	if(isset($arParams["USE_FORM_ITEM_ID"]) && is_array($arParams["USE_FORM_ITEM_ID"])) {
		foreach ($arParams["USE_FORM_ITEM_ID"] as $key => $propID) {
			if(!$propID || $propID < 0) {
				unset($arParams["USE_FORM_ITEM_ID"][$key]);
			}
		}
	}

	// IBlock Text
	$res = CIBlock::GetByID($arParams['IBLOCK_ID']);
	if($arElement = $res->GetNext())
	{
		$arResult['DESCRIPTION_FORM'] = $arElement['DESCRIPTION'];
	}

	// Form Fields
	$properties = CIBlockProperty::GetList(array('sort'=>'asc'), array(
		'ACTIVE' => 'Y', 
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
	));
	while($arProp = $properties->GetNext())
	{
		if(!empty($arParams['USE_FORM_ITEM_ID'])) {
			if(in_array($arProp['ID'], $arParams['USE_FORM_ITEM_ID']))
			{
				if($arProp['PROPERTY_TYPE'] == 'L')
				{
					$dbEnumList = CIBlockProperty::GetPropertyEnum($arProp['ID']);
					while($arEnumList = $dbEnumList->GetNext()){
						$arProp['VALUE_LIST'][$arEnumList['ID']] = $arEnumList;
					}
				}
				if(in_array($arProp["ID"], $arParams["USE_FORM_ITEM_ID_HIDDEN"])) {
					$arProp["HIDDEN"] = "Y";
				}
				$arResult['FORM_ITEMS'][$arProp['ID']] = $arProp;
			}
			if($arProp["ID"] == $arParams["SERVICE_USER_FIELDS_PROPERTY"]) {
				$arProp["SERVICE_FIELD"] = "Y";
				$arResult['FORM_ITEMS'][$arProp['ID']] = $arProp;
			}
		} else {
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

	// Parameter replacement for the old version of the component, so that Captcha worked whithout changing the settings
	if ($arParams['USE_COLOR_CAPTCHA'] == "Y") {
		$arParams['USE_CAPTCHA'] = 'COLOR_CAPTCHA';
	}

	if($arParams['USE_CAPTCHA'] == 'COLOR_CAPTCHA' || ($arParams['USE_COLOR_CAPTCHA'] == 'Y' && $arParams['USE_CAPTCHA'] != 'GRAHIC_CAPTCHA' && $arParams['USE_CAPTCHA'] != 'HIDDEN_CAPTCHA')) {
		// Array of color for Captcha default
		$arParams['CAPTCHA_ITEM_ALL'] = array(
			array('COLOR' => 'FF0033', 'NAME' => GetMessage('COLOR_FF0033')), // red
			array('COLOR' => '009933', 'NAME' => GetMessage('COLOR_009933')), // greent
			array('COLOR' => '0066FF', 'NAME' => GetMessage('COLOR_0066FF')), // blue
			array('COLOR' => '000000', 'NAME' => GetMessage('COLOR_000000')), // black
			array('COLOR' => 'FFFF00', 'NAME' => GetMessage('COLOR_FFFF00')), // yellow
			array('COLOR' => 'FF9900', 'NAME' => GetMessage('COLOR_FF9900')), // orange
			array('COLOR' => '996600', 'NAME' => GetMessage('COLOR_996600')), // broun
			array('COLOR' => 'CC00CC', 'NAME' => GetMessage('COLOR_CC00CC')), // purple
		);
		$arParams['CAPTCHA_COUNT'] = 4;
		$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['ID'] = 'captcha';
		$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['PROPERTY_TYPE'] = 'COLOR_CAPTCHA';
		$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['IS_REQUIRED'] = 'Y';
	}
	elseif($arParams['USE_CAPTCHA'] == 'GRAHIC_CAPTCHA' || ($arParams['USE_COLOR_CAPTCHA'] == 'Y' && $arParams['USE_CAPTCHA'] != 'HIDDEN_CAPTCHA'))
	{
		// Array of figures for Captcha
		$arParams['CAPTCHA_ITEM_ALL'] = array(
			array('COLOR' => 'SQUARE', 'NAME' => GetMessage('SHAPE_SQUARE')),
			array('COLOR' => 'RECTANGLE', 'NAME' => GetMessage('SHAPE_RECTANGLE')),
			array('COLOR' => 'TRIANGLE', 'NAME' => GetMessage('SHAPE_TRIANGLE')),
			array('COLOR' => 'ROUND', 'NAME' => GetMessage('SHAPE_ROUND')),
			array('COLOR' => 'POLYHEDRON', 'NAME' => GetMessage('SHAPE_POLYHEDRON')),
			array('COLOR' => 'TRAPEZE', 'NAME' => GetMessage('SHAPE_TRAPEZE')),
			array('COLOR' => 'RHOMBUS', 'NAME' => GetMessage('SHAPE_RHOMBUS')),
			array('COLOR' => 'OVAL', 'NAME' => GetMessage('SHAPE_OVAL')),
			array('COLOR' => 'STAR', 'NAME' => GetMessage('SHAPE_STAR')),
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

	if($arParams["USE_SERVICE_USER_FIELDS"] == "Y") {
		include("service_fields.php");
	}

	// Form processing before sending
	if(!empty($_POST) && $_POST['FORM_ID'] == $arResult['FORM_ID'])
	{
		$arResult['CHECK_FIELDS'] = 'SUCCESS';

		// $arResult['FORM_ITEMS'] = array_merge($arResult['FORM_ITEMS'],$arResult['SERVICE_FIELD']);

		// Processing input data
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
			// Checking for errors
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
			elseif($arProperties['IS_REQUIRED'] == 'Y' && empty($arResult['POST']['FIELD_'.$arProperties['ID']]))
			{
				$arResult['FORM_ITEMS'][$key]['ERROR'] = GetMessage('FORM_FIELD_ERROR');
				$arResult['CHECK_FIELDS'] = 'ERROR';
			}
			elseif(!empty($arResult['POST']['FIELD_'.$arProperties['ID']]))
			{
				// Checking for regExp
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

			// If file, additional checking
			if($arProperties['PROPERTY_TYPE'] == 'F')
			{
				if(is_array($_FILES['FIELD_'.$arProperties['ID']]['name'])) {
					if(count($_FILES['FIELD_'.$arProperties['ID']]['name']) > $arParams["MAX_FILES_".$arProperties["ID"]]) {
						$arResult['FORM_ITEMS'][$key]['ERROR'] = GetMessage("FILE_FIELD_TO_MANY_FALIES_ERROR");
						$arResult['CHECK_FIELDS'] = 'ERROR';
					}
					foreach ($_FILES['FIELD_'.$arProperties['ID']]['name'] as $f => $file) {
						$arrFile['name'] = $file;
						$arrFile['type'] = $_FILES['FIELD_'.$arProperties['ID']]['type'][$f];
						$arrFile['tmp_name'] = $_FILES['FIELD_'.$arProperties['ID']]['tmp_name'][$f];
						$arrFile['error'] = $_FILES['FIELD_'.$arProperties['ID']]['error'][$f];
						$arrFile['size'] = $_FILES['FIELD_'.$arProperties['ID']]['size'][$f];
						$res = CFile::CheckFile($arrFile, $arParams['FILES_UPLOAD_MAX_FILESIZE'], false, $arProperties['FILE_TYPE']);
						if(strlen($res) > 0) {
							$arResult['FORM_ITEMS'][$key]['ERROR'] = $res;
							$arResult['CHECK_FIELDS'] = 'ERROR';
						}
						else {
							$arFiles[] = $_FILES['FIELD_'.$arProperties['ID']]['tmp_name'][$f];
						}
					}
				} else {
					$arrFile = $_FILES['FIELD_'.$arProperties['ID']];
					$res = CFile::CheckFile($arrFile, $arParams['FILES_UPLOAD_MAX_FILESIZE'], false, $arProperties['FILE_TYPE']);
					if(strlen($res) > 0) {
						$arResult['FORM_ITEMS'][$key]['ERROR'] = $res;
						$arResult['CHECK_FIELDS'] = 'ERROR';
					}
					else {
						$arFiles[] = $_FILES['FIELD_'.$arProperties['ID']]['tmp_name'];
					}
				}
			}

			// Collecting form messages in an array
			if($arProperties['PROPERTY_TYPE'] == 'S') 
			{
				$dataValue = $arResult['POST']['FIELD_'.$arProperties['ID']];
				$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']] = $dataValue;
			}
			elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['MULTIPLE'] == 'N')
			{
				$idValue = intval($arResult['POST']['FIELD_'.$arProperties['ID']]);
				$dataValue = $arProperties['VALUE_LIST'][$idValue]['VALUE'];
				$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']] = $idValue;
			}
			elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['MULTIPLE'] == 'Y')
			{
				foreach ($arResult['POST']['FIELD_'.$arProperties['ID']] as $key => $value) {
					$idValue = intval($value);
					$dataValue = $arProperties['VALUE_LIST'][$idValue]['VALUE'];
					$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']][] = $idValue;
				}
			}
			elseif($arProperties['PROPERTY_TYPE'] == 'F') 
			{
				$dataValue = $_FILES['FIELD_'.$arProperties['ID']];
				$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']] = $dataValue;
			}
			elseif($arProperties['PROPERTY_TYPE'] == 'E')
			{
				if(preg_match("/;/", $arResult['POST']['FIELD_'.$arProperties['ID']])) {
					$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']] = explode(";", $arResult['POST']['FIELD_'.$arProperties['ID']]);
				} else {
					$arResult['FORM_IBLOCK_DATA'][$arProperties['ID']] = $arResult['POST']['FIELD_'.$arProperties['ID']];
				}
			}
		}

		if($arResult['CHECK_FIELDS'] == 'SUCCESS')
		{
			// Get type of the mail template (html or text), and depending on this, change the type of line break
			$rsEM = CEventMessage::GetByID($arParams['EVENT_MESSAGE_ID']);
			$arTemplate = $rsEM->Fetch();
			if ($arTemplate['BODY_TYPE'] == 'text') {
				$END_OF_LINE = "\r\n";
			} elseif ($arTemplate['BODY_TYPE'] == 'html') {
				$END_OF_LINE = "<br>";
			}
			//

			// Save in IBlock
			if($arParams['SAVE_TO_IBLOCK'] == 'Y' && !empty($arParams['IBLOCK_ID']))
			{
				$oElement = new CIBlockElement;
				$PROP = array();

				foreach ($arResult['FORM_ITEMS'] as $key => $arItem) 
				{
					if($arItem['PROPERTY_TYPE'] == 'S' && ($arItem['USER_TYPE'] == 'HTML' || $arItem['USER_TYPE'] == 'TEXT'))
					{
						$PROP[$arItem['ID']] = array('VALUE'=>array('TEXT'=>$arResult['FORM_IBLOCK_DATA'][$arItem['ID']], 'TYPE'=>$arItem['USER_TYPE']));
					}
					elseif($arItem['PROPERTY_TYPE'] == 'L' && $arItem['MULTIPLE'] == 'Y')
					{
						foreach ($arResult['FORM_IBLOCK_DATA'][$arItem['ID']] as $id) {
							$PROP_VALUES[]['VALUE'] = $id;
						}
						$PROP[$arItem['ID']] = $PROP_VALUES;
					}
					elseif($arItem['PROPERTY_TYPE'] == 'F') {
						if(is_array($_FILES['FIELD_'.$arItem['ID']]['name'])) {
							foreach ($_FILES['FIELD_'.$arItem['ID']]['name'] as $f => $file) {
								$tmp['name'] = $file;
								$tmp['type'] = $_FILES['FIELD_'.$arItem['ID']]['type'][$f];
								$tmp['tmp_name'] = $_FILES['FIELD_'.$arItem['ID']]['tmp_name'][$f];
								$tmp['error'] = $_FILES['FIELD_'.$arItem['ID']]['error'][$f];
								$tmp['size'] = $_FILES['FIELD_'.$arItem['ID']]['size'][$f];
								$PROP[$arItem['ID']][] = $tmp;
								unset($tmp);
							}
							$arIdsFiles[] = $arItem['ID'];
						} else {
							$PROP[$arItem['ID']] = $_FILES['FIELD_'.$arItem['ID']];
							$arIdsFiles[] = $arItem['ID'];
						}
					}
					else 
					{
						$PROP[$arItem['ID']] = $arResult['FORM_IBLOCK_DATA'][$arItem['ID']];
					}
				}

				$arLoadProductArray = Array(
					'DATE_ACTIVE_FROM'  => date('d.m.Y H:i:s'),
					'IBLOCK_SECTION_ID' => false,
					'IBLOCK_ID'         => $arParams['IBLOCK_ID'],
					'PROPERTY_VALUES'   => $PROP,
					'NAME'              => GetMessage('ELEMENT_TITLE').' '.date('d.m.Y H:i:s'),
					'ACTIVE'            => 'Y',
				);

				if($PRODUCT_ID = $oElement->Add($arLoadProductArray)){
					$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_OK';

					// Get file path
					$db_props = CIBlockElement::GetProperty($arParams['IBLOCK_ID'], $PRODUCT_ID, array("sort" => "asc"), Array("ID"=>$arIdsFiles));
					$zip = array();
					while($ar_props = $db_props->Fetch()){
						if($arParams["CREATE_ZIP_FILE_".$ar_props["ID"]] == "Y" &&
							is_array($_FILES['FIELD_'.$ar_props["ID"]]['name']) &&
							$zip[$ar_props["ID"]]["res"] !== true) {
							$tmp = array();
							$tmp["zip"] = new ZipArchive();
							$tmp["zipname"] = $_SERVER["DOCUMENT_ROOT"]."/upload/tmp/".date('Y_m_d_H_i').$ar_props["ID"].'.zip';
							$tmp["res"] = $tmp["zip"]->open($tmp["zipname"],ZIPARCHIVE::CREATE);
							$zip[$ar_props["ID"]] = $tmp;
							$path = '';
							$path = CFile::GetPath($ar_props["VALUE"]);
							$zip[$ar_props["ID"]]["zip"]->addFile($_SERVER["DOCUMENT_ROOT"].'/'.$path,basename($path));
						} elseif($arParams["CREATE_ZIP_FILE_".$ar_props["ID"]] == "Y" &&
							is_array($_FILES['FIELD_'.$ar_props["ID"]]['name']) &&
							$zip[$ar_props["ID"]]["res"] === true) {
							$path = '';
							$path = CFile::GetPath($ar_props["VALUE"]);
							$zip[$ar_props["ID"]]["zip"]->addFile($_SERVER["DOCUMENT_ROOT"].'/'.$path,basename($path));
						} else {
							$arPathFile[$ar_props['ID']][] = CFile::GetPath($ar_props['VALUE']);
						}
					}
					if(count($zip) > 0) {
						$propFileArray = array();
						$arPathFile = array();
						foreach ($zip as $key => &$archive) {
							$archive["zip"]->close();
							$archive["filesize"] = filesize($archive["zip"]->filename);
							$filearray = array(
								"name" => basename($archive["zipname"]),
								"type" => "application/zip",
								"tmp_name" => $archive["zipname"],
								"error" => '',
								"size" => $archive["filesize"],
							);
							$propFileArray[$key] = array(
								"VALUE" => $filearray,
								"DESCRIPTION" => $filearray["name"],
							);
						}
						CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, $arParams['IBLOCK_ID'], $propFileArray);
						$db_props = CIBlockElement::GetProperty($arParams['IBLOCK_ID'], $PRODUCT_ID, array("sort" => "asc"), Array("ID"=>$arIdsFiles));
						while($ar_props = $db_props->Fetch()){
							$arPathFile[$ar_props['ID']][] = CFile::GetPath($ar_props['VALUE']);
						}
						foreach ($zip as $key => $archive) {
							unlink($archive["zipname"]);
						}
					}
				}
				else {
					$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_ERROR';
					$arResult['MESSAGE_RESULT_ERROR_TEXT'] = 'ERROR: '.$oElement->LAST_ERROR;
				}
			}

			if(!empty($arParams['EMAIL_FROM_USER'])){
				$EMAIL_FROM_USER = $arResult['POST']['FIELD_'.$arParams['EMAIL_FROM_USER']];
			}

			// Collecting form messages in an text
			foreach ($arResult['FORM_ITEMS'] as $key => $arProperties) 
			{
				if($arProperties['SERVICE_FIELD'] == "Y" && $arParams['EMAIL_SERVICE_USER_PRODUCTS'] != "Y")
					continue;
				
				if($arProperties['PROPERTY_TYPE'] == 'S') 
				{
					$dataValue = $arResult['POST']['FIELD_'.$arProperties['ID']];
					if(!empty($dataValue)){
						$arResult['FORM_ADMIN_MESSAGE'].= $arProperties['NAME'].': '.$dataValue.$END_OF_LINE;
						if($arProperties['SERVICE_FIELD'] != "Y") {
							$arResult['FORM_USER_MESSAGE'].= $arProperties['NAME'].': '.$dataValue.$END_OF_LINE;
						}
					}
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['MULTIPLE'] == 'N')
				{
					$idValue = intval($arResult['POST']['FIELD_'.$arProperties['ID']]);
					$dataValue = $arProperties['VALUE_LIST'][$idValue]['VALUE'];
					if(!empty($dataValue)){
						$arResult['FORM_ADMIN_MESSAGE'].= $arProperties['NAME'].': '.$dataValue.$END_OF_LINE;
						if($arProperties['SERVICE_FIELD'] != "Y") {
							$arResult['FORM_USER_MESSAGE'].= $arProperties['NAME'].': '.$dataValue.$END_OF_LINE;
						}
					}
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['MULTIPLE'] == 'Y')
				{
					if(!empty($arResult['POST']['FIELD_'.$arProperties['ID']])){
						$arResult['FORM_ADMIN_MESSAGE'].= $arProperties['NAME'].': ';
						if($arProperties['SERVICE_FIELD'] != "Y") {
							$arResult['FORM_USER_MESSAGE'].= $arProperties['NAME'].': ';
						}
						foreach ($arResult['POST']['FIELD_'.$arProperties['ID']] as $key => $value) {
							$idValue = intval($value);
							$dataValue = $arProperties['VALUE_LIST'][$idValue]['VALUE'];
							$arResult['FORM_ADMIN_MESSAGE'].= $dataValue.', ';
							if($arProperties['SERVICE_FIELD'] != "Y") {
								$arResult['FORM_USER_MESSAGE'].= $dataValue.', ';
							}
						}

						$arResult['FORM_ADMIN_MESSAGE'].= $END_OF_LINE;
						if($arProperties['SERVICE_FIELD'] != "Y") {
							$arResult['FORM_USER_MESSAGE'].= $END_OF_LINE;
						}
					}
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'F') 
				{
					if (!empty($arPathFile[$arProperties['ID']])){
						if ($arParams["CREATE_ZIP_FILE_".$arProperties["ID"]] == "Y") {
							$arResult['FORM_ADMIN_MESSAGE'].= $arProperties['NAME'].': <a href="//'.$_SERVER['SERVER_NAME'].$arPathFile[$arProperties['ID']][0].'">'.GetMessage('DOWNLOAD_FILE').'</a>'.$END_OF_LINE;
							if($arProperties['SERVICE_FIELD'] != "Y") {
								$arResult['FORM_USER_MESSAGE'].= $arProperties['NAME'].': <a href="//'.$_SERVER['SERVER_NAME'].$arPathFile[$arProperties['ID']][0].'">'.GetMessage('DOWNLOAD_FILE').'</a>'.$END_OF_LINE;
							}
						} else {
							$dataValue = $_FILES['FIELD_'.$arProperties['ID']];
							if(!empty($dataValue)) {
								if (is_array($dataValue["name"])) {
									foreach ($dataValue["name"] as $f => $file) {
										$arResult['FORM_ADMIN_MESSAGE'].= $arProperties['NAME'].': <a href="//'.$_SERVER['SERVER_NAME'].$arPathFile[$arProperties['ID']][$f].'">'.$file.'</a>'.$END_OF_LINE;
										if($arProperties['SERVICE_FIELD'] != "Y") {
											$arResult['FORM_USER_MESSAGE'].= $arProperties['NAME'].': <a href="//'.$_SERVER['SERVER_NAME'].$arPathFile[$arProperties['ID']][$f].'">'.$file.'</a>'.$END_OF_LINE;
										}
									}
								} else {
									if ($dataValue['name']) {
										$arResult['FORM_ADMIN_MESSAGE'].= $arProperties['NAME'].': <a href="//'.$_SERVER['SERVER_NAME'].$arPathFile[$arProperties['ID']].'">'.$dataValue['name'].'</a>'.$END_OF_LINE;
										if($arProperties['SERVICE_FIELD'] != "Y") {
											$arResult['FORM_USER_MESSAGE'].= $arProperties['NAME'].': <a href="//'.$_SERVER['SERVER_NAME'].$arPathFile[$arProperties['ID']].'">'.$dataValue['name'].'</a>'.$END_OF_LINE;
										}
									} 
									else {
										$arResult['FORM_ADMIN_MESSAGE'].= $arProperties['NAME'].': <a href="//'.$_SERVER['SERVER_NAME'].$arPathFile[$arProperties['ID']].'">'.GetMessage('DOWNLOAD_FILE').'</a>'.$END_OF_LINE;
										if($arProperties['SERVICE_FIELD'] != "Y") {
											$arResult['FORM_USER_MESSAGE'].= $arProperties['NAME'].': <a href="//'.$_SERVER['SERVER_NAME'].$arPathFile[$arProperties['ID']].'">'.GetMessage('DOWNLOAD_FILE').'</a>'.$END_OF_LINE;
										}
									}
								}
							}
						}
					}
				}
			}

			// Send email to admin
			if($arParams['SEND_EMAIL_FORM'] == 'Y' && !empty($arParams['EMAIL_TO']))
			{
				$arEventFields = array(
					'EMAIL_TO' => $arParams['EMAIL_TO'],
					'TEXT' => $arResult['FORM_ADMIN_MESSAGE'],
				);
				if (!empty($EMAIL_FROM_USER)) {
					$arEventFields['EMAIL_FROM_USER'] = $EMAIL_FROM_USER;
				}
				
				if(empty($arFiles)) $arFiles = false;

				if(CEvent::Send('FEEDBACK_FORM', SITE_ID, $arEventFields, 'N', $arParams['EVENT_MESSAGE_ID'], false)){
					$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_OK';
				}
				else {
					$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_ERROR';
					$arResult['MESSAGE_RESULT_ERROR_TEXT'] = GetMessage('MESSAGE_RESULT_ERROR_TEXT');
				}
			}

			// Send email to user
			if($arParams['SEND_EMAIL_FORM_USER'] == 'Y' && !empty($EMAIL_FROM_USER) && check_email($EMAIL_FROM_USER))
			{
				$arEventFields = array(
					'EMAIL_TO' => $EMAIL_FROM_USER,
					'TEXT' => $arResult['FORM_USER_MESSAGE'],
				);
				if(empty($arFiles)) $arFiles = false;
				CEvent::Send('FEEDBACK_FORM', SITE_ID, $arEventFields, 'N', $arParams['EVENT_MESSAGE_ID_USER'], $arFiles);
			}

			// Add user to subscription
			if(!empty($arParams['SUBSCRIPTION_EMAIL_USER'])){
				$SUBSCRIPTION_EMAIL_USER = $arResult['POST']['FIELD_'.$arParams['SUBSCRIPTION_EMAIL_USER']];
			}
			if($arParams['ADD_SUBSCRIPTION_USER'] == 'Y' && !empty($SUBSCRIPTION_EMAIL_USER) && check_email($SUBSCRIPTION_EMAIL_USER))
			{
				if(CModule::IncludeModule('subscribe')) 
				{
					$arFields = array(
						"USER_ID" => ($USER->IsAuthorized()? $USER->GetID():false),
						"FORMAT" => "html",
						"EMAIL" => $SUBSCRIPTION_EMAIL_USER,
						"ACTIVE" => "Y",
						"RUB_ID" => array(1),
						"SEND_CONFIRM" => 'N',
						"CONFIRMED" => 'Y'
					);
					$subscr = new CSubscription;
					$ID = $subscr->Add($arFields);
				}
			}

			// Add lid in Bitrix24
			if($arParams['USE_BITRIX24_LID'] == 'Y')
			{
				$bitrix24_url = $arParams['BITRIX24_URL'];
				$bitrix24_login = $arParams['BITRIX24_LOGIN'];
				$bitrix24_password = $arParams['BITRIX24_PASSWORD'];
				$bitrix24_title = $arParams['BITRIX24_LID_TITLE'];

				if(!empty($bitrix24_url) && !empty($bitrix24_login) && !empty($bitrix24_password) && !empty($bitrix24_title))
				{	
					$arParamsBitrix24 = array(
						'LOGIN' => $bitrix24_login,
						'PASSWORD' => $bitrix24_password,
						'TITLE' => $bitrix24_title,
						'STATUS_ID' => 'NEW',
						'SOURCE_ID' => 'WEB',
						'CURRENCY_ID' => 'RUB',
					);

					foreach ($arResult['FORM_ITEMS'] as $key => $arProperties)
					{
						if(!empty($arResult['POST']['FIELD_'.$arProperties['ID']]))
						{
							$fieldBitrix24 = isset($arParams['BITRIX24_LID_'.$arProperties['ID']]) ? $arParams['BITRIX24_LID_'.$arProperties['ID']] : '';
							$propertyValue = $arResult['POST']['FIELD_'.$arProperties['ID']];

							if(!empty($fieldBitrix24)){
								if($fieldBitrix24 == 'OPPORTINUTY') $propertyValue = intval($propertyValue);
								$arParamsBitrix24[$fieldBitrix24] = $propertyValue;
							}
						}
					}

					$obHttp = new CHTTP();
					$result = $obHttp->Post($bitrix24_url.'/crm/configs/import/lead.php', $arParamsBitrix24);
					$result = json_decode(str_replace('\'', '"', $result), true);
				}

			}

		}
		elseif($arResult['CHECK_FIELDS'] == 'ERROR')
		{
			$arResult['MESSAGE_RESULT'] = 'MESSAGE_RESULT_ERROR';
			$arResult['MESSAGE_RESULT_ERROR_TEXT'] = GetMessage('MESSAGE_RESULT_ERROR_TEXT');
		}

	}

	// Captcha
	if($arParams['USE_CAPTCHA'] == 'COLOR_CAPTCHA' || ($arParams['USE_COLOR_CAPTCHA'] == 'Y' && $arParams['USE_CAPTCHA'] != 'GRAHIC_CAPTCHA'))
	{
		$arColor = array_rand($arParams['CAPTCHA_ITEM_ALL'], $arParams['CAPTCHA_COUNT']);
		foreach($arColor as $count) {
			$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['CAPTCHA_COLORS_USE'][$count] = $arParams['CAPTCHA_ITEM_ALL'][$count];
		}

		$ID = array_rand($arColor, 1);
		$colorID = $arColor[$ID];
		$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['CAPTCHA_ID'] = $colorID;  // index of current color

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
		$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['CAPTCHA_ID'] = $colorID;  // index of current color

		$_SESSION['CAPTCHA_ID'] = array();
		$_SESSION['CAPTCHA_ID'][$arResult['FORM_ID']] = $colorID;

		$arResult['FORM_ITEMS']['COLOR_CAPTCHA']['NAME'] = GetMessage("LABEL_GRAHIC_CAPTCHA", Array ("#CODE#" => $arResult['FORM_ITEMS']['COLOR_CAPTCHA']['CAPTCHA_COLORS_USE'][$colorID]['NAME']));
	}

	if($arParams['USE_JQUERY'] == 'Y')
	{
		$APPLICATION->AddHeadScript('http://yandex.st/jquery/1.7.1/jquery.min.js');
	}

	if($arParams['USE_PERSONAL_DATA'] == 'Y' && $_REQUEST['agreement'] == '154fz'){
		$this->IncludeComponentTemplate('agreement');
		return;
	}

	$this->IncludeComponentTemplate();

?>
