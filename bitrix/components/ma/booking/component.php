<?
	if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

	// PROPERTY_TYPES: 
	// "S" - строка 
	// "N" - число 
	// "L" - список 
	// "F" - файл 
	// "G" - привязка к разделу 
	// "E" - привязка к элементу
//unset($_SESSION['BOOKING']);
	if (!function_exists('dump')) {
		function dump($var = null)
	    {
	        if($_GET['dump'] == 'off'){
	            $_SESSION['DUMP'] = 'N';
	        }
	        elseif($_GET['dump'] == 'on' || $_SESSION['DUMP'] == 'Y'){
	            $_SESSION['DUMP'] = 'Y';
	            if ($var == null) $var = 'Show test message';
	            echo '<pre style="clear: both; text-align: left; font: 12px Courier New, monospace; color: green;">';
	            print_r($var);
	            echo '</pre>';
	        }
	    }
	}

	if (!function_exists('rrdate')) {
	    function rrdate($param, $time = 0) {
	        if (intval($time) == 0) $time = time();
	        $MonthNames = array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
	        $DayOfWeekNames = array("Понедельника","Вторника","Среды","Четверга","Пятницы","Субботы","Воскресенья");
	        if (strstr($param,'F') || strstr($param,'l')) {
	        	$pattern = array (
	        		'/F/',
	        		'/l/',
	        	);
	        	$replacement = array (
	        		$MonthNames[date('n',$time)-1],
	        		$MonthNames[date('N',$time)],
	        	);
	        	return date(preg_replace($pattern,$replacement,$param), $time);
	        } else {
	        	return date($param, $time);
	        }
	    }
	}

	if (!function_exists('rdate')) {
	    function rdate($param, $time = 0) {
	        if(intval($time) == 0) $time = time();
	        $MonthNames = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
	        $DayOfWeekNames = array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
	        $DayOfWeekNamesAbbr = array("Пн","Вт","Ср","Чт","Пт","Сб","Вс");
	        if(strstr($param,'F') || strstr($param,'l') || strstr($param,'D')) {
	        	$pattern = array (
	        		0 => '/F/',
	        		1 => '/l/',
	        		2 => '/D/',
	        	);
	        	$replacement = array (
	        		0 => $MonthNames[date('n',$time)-1],
	        		1 => $DayOfWeekNames[date('N',$time)-1],
	        		2 => $DayOfWeekNamesAbbr[date('N',$time)-1],
	        	);
	        	return date(preg_replace($pattern,$replacement,$param), $time);
	        } else {
		        return date($param, $time);
	        }
	    }
	}

	//добавляем время по запросу
	if(isset($_REQUEST['add']) && !empty($_REQUEST['add'])) {
		//ob_end_clean();
		if(!in_array($_REQUEST['add'],$_SESSION['BOOKING'])) {
			$_SESSION['BOOKING'][] = $_REQUEST['add'];
			asort($_SESSION['BOOKING']);
		}
/*		$result = array();
		$string = '';
		foreach ($_SESSION['BOOKING'] as $key => $value) {
			$string .= rrdate('d.m.Y H:i:s',$value).';';
		}
		$result['string'] = $string;
		$text = '';
		$tmp = array();
		foreach ($_SESSION['BOOKING'] as $key => $id) {
			if(!isset($tmp[rrdate('d F Y',$id)])) {
				$tmp[rrdate('d F Y',$id)] = array();
				$tmp[rrdate('d F Y',$id)][] = rrdate('H:i',$id);
			} else {
				$tmp[rrdate('d F Y',$id)][] = rrdate('H:i',$id);
			}
			
		}
		foreach ($tmp as $day => $date) {
			$text .= $day.' ';
			if(count($date) == 1) {
				$text .= $date[0].';<br>';
			} else {
				foreach ($date as $time => $hours) {
					$timetmp = array();
					$timetmp['time'] = explode(':', $hours);//10   00
					if($timetmp['time'][1] == 00) {
						$timetmp['time_prev'] = rrdate('H:i',mktime($timetmp['time'][0]-1,60-$arParams['TIME_INTERVAL']));
						$timetmp['time_next'] = rrdate('H:i',mktime($timetmp['time'][0],$timetmp['time'][1]+$arParams['TIME_INTERVAL']));
					} else {
						$timetmp['time_prev'] = rrdate('H:i',mktime($timetmp['time'][0],$timetmp['time'][1]-$arParams['TIME_INTERVAL']));
						$timetmp['time_next'] = rrdate('H:i',mktime($timetmp['time'][0],$timetmp['time'][1]+$arParams['TIME_INTERVAL']));
					}
					if($time == 0) {
						$text .= $hours;
						continue;
					}
					if($date[$time-1] == $timetmp['time_prev'] && $date[$time+1] != $timetmp['time_next']) {
						$text .= '-'.$hours;
					} elseif($date[$time-1] != $timetmp['time_prev'] && $date[$time+1] == $timetmp['time_next']) {
						$text .= ','.$hours;
					} elseif($date[$time-1] != $timetmp['time_prev'] && $date[$time+1] != $timetmp['time_next']) {
						$text .= ','.$hours;
					}
				}
				$text .= ';<br>';
			}
		}
		$result['text'] = $text;
		$resultstr = json_encode($result);
		echo($resultstr);*/
		//ob_get_contents();
		die();
	}

	//удаляем время по запросу
	if (isset($_REQUEST['del']) && !empty($_REQUEST['del'])) {
		//ob_end_clean();
		foreach ($_SESSION['BOOKING'] as $key => $id) {
			if($id == $_REQUEST['del']) {
				unset($_SESSION['BOOKING'][$key]);
				asort($_SESSION['BOOKING']);
			}
		}
/*		$result = array();
		$string = '';
		foreach ($_SESSION['BOOKING'] as $key => $value) {
			$string .= rrdate('d.m.Y H:i:s',$value).';';
		}
		$result['string'] = $string;
		$text = '';
		$tmp = array();
		foreach ($_SESSION['BOOKING'] as $key => $id) {
			if(!isset($tmp[rrdate('d F Y',$id)])) {
				$tmp[rrdate('d F Y',$id)] = array();
				$tmp[rrdate('d F Y',$id)][] = rrdate('H:i',$id);
			} else {
				$tmp[rrdate('d F Y',$id)][] = rrdate('H:i',$id);
			}
			
		}
		foreach ($tmp as $day => $date) {
			$text .= $day.' ';
			if(count($date) == 1) {
				$text .= $date[0].';<br>';
			} else {
				foreach ($date as $time => $hours) {
					$timetmp = array();
					$timetmp['time'] = explode(':', $hours);//10   00
					if($timetmp['time'][1] == 00) {
						$timetmp['time_prev'] = rrdate('H:i',mktime($timetmp['time'][0]-1,60-$arParams['TIME_INTERVAL']));
						$timetmp['time_next'] = rrdate('H:i',mktime($timetmp['time'][0],$timetmp['time'][1]+$arParams['TIME_INTERVAL']));
					} else {
						$timetmp['time_prev'] = rrdate('H:i',mktime($timetmp['time'][0],$timetmp['time'][1]-$arParams['TIME_INTERVAL']));
						$timetmp['time_next'] = rrdate('H:i',mktime($timetmp['time'][0],$timetmp['time'][1]+$arParams['TIME_INTERVAL']));
					}
					if($time == 0) {
						$text .= $hours;
						continue;
					}
					if($date[$time-1] == $timetmp['time_prev'] && $date[$time+1] != $timetmp['time_next']) {
						$text .= '-'.$hours;
					} elseif($date[$time-1] != $timetmp['time_prev'] && $date[$time+1] == $timetmp['time_next']) {
						$text .= ','.$hours;
					} elseif($date[$time-1] != $timetmp['time_prev'] && $date[$time+1] != $timetmp['time_next']) {
						$text .= ','.$hours;
					}
				}
				$text .= ';<br>';
			}
		}
		$result['text'] = $text;
		$resultstr = json_encode($result);
		echo($resultstr);
		ob_get_contents();*/
		die();
	}

	//добавляем массив времен по запросу
	if (isset($_REQUEST['addarray']) && !empty($_REQUEST['addarray'])) {
		$ids = json_decode($_REQUEST['addarray']);
		foreach ($ids as $key => $id) {
			if(!in_array($id,$_SESSION['BOOKING']) && !empty($id)) {
				$_SESSION['BOOKING'][] = $id;
				asort($_SESSION['BOOKING']);
			}
		}
		die();
	}

	//удаляем массив времен по запросу
	if (isset($_REQUEST['delarray']) && !empty($_REQUEST['delarray'])) {
		$ids = json_decode($_REQUEST['delarray']);
		foreach ($ids as $key => $id) {
			foreach ($_SESSION['BOOKING'] as $sess => $timestamp) {
				if($id == $timestamp) {
					unset($_SESSION['BOOKING'][$sess]);
					asort($_SESSION['BOOKING']);
				}
			}
		}
		die();
	}

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

	if(!isset($arParams['DAY_BEGIN']) || empty($arParams['DAY_BEGIN'])) {
		$arParams['DAY_BEGIN'] = 9;
	}

	if(!isset($arParams['DAY_END']) || empty($arParams['DAY_END'])) {
		$arParams['DAY_END'] = 18;
	}

	if(!isset($arParams['TIME_INTERVAL']) || empty($arParams['TIME_INTERVAL'])) {
		$arParams['TIME_INTERVAL'] = 30;
	}

	//добавляем в сессию id связанного элемента и id инфоблока
	if($arParams['IBLOCK_ELEMENTS_ID']) {
		$_SESSION['BOOKING_IBLOCK_ELEMENTS_ID'] = $arParams['IBLOCK_ELEMENTS_ID'];
	}
	if($arParams['LINKED_ELEMENT_ID']) {
		$_SESSION['BOOKING_LINKED_ELEMENT_ID'] = $arParams['LINKED_ELEMENT_ID'];
	}
	//добавляем в сессию временной интервал для последующих расчетов
	if($arParams['TIME_INTERVAL']) {
		$_SESSION['BOOKING_TIME_INTERVAL'] = $arParams['TIME_INTERVAL'];
	}

	//определяем текущий день, дату, день недели

	if(!$_REQUEST['weeks']) {
		$realWeek = rdate('W');
	} else {
		$realWeek = $_REQUEST['weeks'];
	}

	$displayWeek = rdate('W');

	$currentDate = array(
		'DATE' => rdate('d.m.Y'),
		'DAY_OF_WEEK_FULL' => rdate('l'),
		'DAY_OF_WEEK_ABBR' => rdate('D'),
		'DAY_OF_WEEK_NUM' => rdate('w')
	);

	$arResult['CURRENT_DAY'] = $currentDate;

	//расчитываем текущую неделю для сетки

	$currentWeek = array();

	for($i = 0; $i < 7; $i++) {
		$arTmp = array();
		$day = mktime(0,0,0,date("m"),date("j")-$currentDate['DAY_OF_WEEK_NUM']+1+$i+(($realWeek-$displayWeek)*7),date("Y"));
		$arTmp['DAY'] = rdate('d',$day);
		$arTmp['MONTH'] = rdate('n',$day);
		$arTmp['YEAR'] = rdate('Y',$day);
		$arTmp['DATE_FULL'] = rdate('d.m.Y',$day);
		$arTmp['DATE_FULL_INVERT'] = rdate('Y.m.d',$day);
		$arTmp['DAY_OF_WEEK_NUM'] = rdate('w',$day);
		$arTmp['DAY_OF_WEEK_FULL'] = rdate('l',$day);
		$arTmp['DAY_OF_WEEK_ABBR'] = rdate('D',$day);
		if($arTmp['DAY_OF_WEEK_NUM'] == 0) {
			$arTmp['DAY_OF_WEEK_NUM'] = 7;
		}
		$currentWeek[$i] = $arTmp;
	}

	$arResult['GRID']['COLS_HEADERS'] = $currentWeek;

	//расчитываем промежутки времени (заголовки строк) для сетки

	$gridRows = array();

	$divider = 60 / $arParams['TIME_INTERVAL'];

	$countintervals = ($arParams['DAY_END'] - $arParams['DAY_BEGIN']) * $divider;

	for($i = 0; $i < $countintervals; $i++) {
		$arTmp = array();
		$time = mktime($arParams['DAY_BEGIN'], $i * $arParams['TIME_INTERVAL']);
		$arTmp['NAME'] = rdate('H:i',$time);
		$arTmp['HOURS'] = rdate('H',$time);
		$arTmp['MINUTES'] = rdate('i',$time);
		$gridRows[] = $arTmp;
	}

	$arResult['GRID']['ROWS_HEADERS'] = $gridRows;

	//расчитываем все варианты строк для каждого заголовка

	foreach ($arResult['GRID']['COLS_HEADERS'] as $day => $date) {
		$tmp = array();
		foreach ($arResult['GRID']['ROWS_HEADERS'] as $key => $time) {
			$tmp[] = mktime($time['HOURS'],$time['MINUTES'],0,$date['MONTH'],$date['DAY'],$date['YEAR']);
		}
		$arResult['GRID']['COLS_HEADERS'][$day]['IDS'] = $tmp;
		$arResult['GRID']['COLS_HEADERS'][$day]['TOTAL_IDS'] = count($tmp);
	}

	//расчитываем текущую неделю для фильтра

	$currentWeek = array();
	$currentWeek['BEGIN'] = rdate('d.m.Y H:i:s',
		mktime(
			$arResult['GRID']['ROWS_HEADERS'][0]['HOURS'],
			$arResult['GRID']['ROWS_HEADERS'][0]['MINUTES'],
			0,
			$arResult['GRID']['COLS_HEADERS'][0]['MONTH'],
			$arResult['GRID']['COLS_HEADERS'][0]['DAY'],
			$arResult['GRID']['COLS_HEADERS'][0]['YEAR']
		));
	$currentWeek['END'] = rdate('d.m.Y H:i:s',
		mktime(
			end($arResult['GRID']['ROWS_HEADERS'])['HOURS'],
			end($arResult['GRID']['ROWS_HEADERS'])['MINUTES'],
			0,
			end($arResult['GRID']['COLS_HEADERS'])['MONTH'],
			end($arResult['GRID']['COLS_HEADERS'])['DAY'],
			end($arResult['GRID']['COLS_HEADERS'])['YEAR']
		));
	$arResult['FILTER'] = $currentWeek;

	//расчитываем заголовок таблицы

	$headerFirstDay = rdate('d',mktime(0,0,0,date("m"),date("j")-$currentDate['DAY_OF_WEEK_NUM']+1+(($realWeek-$displayWeek)*7),date("Y")));
	$headerLastDay = rdate('d',mktime(0,0,0,date("m"),date("j")-$currentDate['DAY_OF_WEEK_NUM']+7+(($realWeek-$displayWeek)*7),date("Y")));

	if($headerFirstDay>$headerLastDay) {
		$header = $headerFirstDay.' ';
		$header .= rrdate('F',mktime(0,0,0,date("m")-1,date("j")-$currentDate['DAY_OF_WEEK_NUM']+7+(($realWeek-$displayWeek)*7),date("Y"))).' - ';
		$header .= $headerLastDay.' ';
		$header .= rrdate('F Y',mktime(0,0,0,date("m"),date("j")-$currentDate['DAY_OF_WEEK_NUM']+7+(($realWeek-$displayWeek)*7),date("Y")));
	} else {
		$header = $headerFirstDay.' - '.$headerLastDay.' ';
		$header .= rrdate('F Y',mktime(0,0,0,date("m"),date("j")-$currentDate['DAY_OF_WEEK_NUM']+7+(($realWeek-$displayWeek)*7),date("Y")));
	}


	$arResult['GRID']['HEADER'] = $header;

	//пагинация

	$backlink = 'weeks=';
	$backlink .= $realWeek-1;
	$backlink = $APPLICATION->GetCurPageParam($backlink,array('weeks'),false);

	$arResult['PAGENAVIGATION']['BACK_LINK'] = $backlink;

	$fwdlink = 'weeks=';
	$fwdlink .= $realWeek+1;
	$fwdlink = $APPLICATION->GetCurPageParam($fwdlink,array('weeks'),false);

	$arResult['PAGENAVIGATION']['FWD_LINK'] = $fwdlink;

	//элемент для которого выводится бронирование

	if(isset($arParams['LINKED_ELEMENT_ID'])) {
		$ob = CIBlockElement::GetList(array('SORT'=>'ASC'),array('ID'=>$arParams['LINKED_ELEMENT_ID'],'IBLOCK_ID'=>$arParams['IBLOCK_ELEMENTS_ID']),false,false,array('ID','NAME'));
		while ($arr = $ob->GetNext()) {
			$arResult['LINKED_ELEMENT'] = $arr['NAME'];
		}
	}

	//формируем ссылку на форму для первоначальной загрузки

/*	if(isset($_SESSION['BOOKING']) && !empty($_SESSION['BOOKING'])) {
		$arResult['FIRST_LINK'] = array();
		$string = '';
		foreach ($_SESSION['BOOKING'] as $key => $value) {
			$string .= rrdate('d.m.Y H:i:s',$value).';';
		}
		$text = '';
		$tmp = array();
		foreach ($_SESSION['BOOKING'] as $key => $id) {
			if(!isset($tmp[rrdate('d F Y',$id)])) {
				$tmp[rrdate('d F Y',$id)] = array();
				$tmp[rrdate('d F Y',$id)][] = rrdate('H:i',$id);
			} else {
				$tmp[rrdate('d F Y',$id)][] = rrdate('H:i',$id);
			}
			
		}
		foreach ($tmp as $day => $date) {
			$text .= $day.' ';
			if(count($date) == 1) {
				$text .= $date[0].';<br>';
			} else {
				foreach ($date as $time => $hours) {
					$timetmp = array();
					$timetmp['time'] = explode(':', $hours);//10   00
					if($timetmp['time'][1] == 00) {
						$timetmp['time_prev'] = rrdate('H:i',mktime($timetmp['time'][0]-1,60-$arParams['TIME_INTERVAL']));
						$timetmp['time_next'] = rrdate('H:i',mktime($timetmp['time'][0],$timetmp['time'][1]+$arParams['TIME_INTERVAL']));
					} else {
						$timetmp['time_prev'] = rrdate('H:i',mktime($timetmp['time'][0],$timetmp['time'][1]-$arParams['TIME_INTERVAL']));
						$timetmp['time_next'] = rrdate('H:i',mktime($timetmp['time'][0],$timetmp['time'][1]+$arParams['TIME_INTERVAL']));
					}
					if($time == 0) {
						$text .= $hours;
						continue;
					}
					if($date[$time-1] == $timetmp['time_prev'] && $date[$time+1] != $timetmp['time_next']) {
						$text .= '-'.$hours;
					} elseif($date[$time-1] != $timetmp['time_prev'] && $date[$time+1] == $timetmp['time_next']) {
						$text .= ','.$hours;
					} elseif($date[$time-1] != $timetmp['time_prev'] && $date[$time+1] != $timetmp['time_next']) {
						$text .= ','.$hours;
					}
				}
				$text .= ';<br>';
			}
		}
		$arResult['FIRST_LINK']['STRING'] = $string;
		$arResult['FIRST_LINK']['TEXT'] = $text;
	}*/

	//получаем все активные и подтвержденные элементы

	$arResult['ITEMS'] = array();

	$arOrder = array(
		'SORT' => 'ASC',
	);
	$arFilter = array(
		'ACTIVE' => 'Y',
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'PROPERTY_'.$arParams['CONFIRM_ELEMENT_PROPERTY'].'_VALUE' => 'Y',
		'PROPERTY_'.$arParams['LINKED_ELEMENT_PROPERTY'] => $arResult['LINKED_ELEMENT'],
		'>=PROPERTY_'.$arParams['STRING_ELEMENT_PROPERTY'] => trim(CDatabase::CharToDateFunction($arResult['FILTER']['BEGIN']),"\'"),
		'<=PROPERTY_'.$arParams['STRING_ELEMENT_PROPERTY'] => trim(CDatabase::CharToDateFunction($arResult['FILTER']['END']),"\'"),
	);
	$arSelect = array(
		'ID',
		'PROPERTY_'.$arParams['STRING_ELEMENT_PROPERTY'],
	);
	$ob = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($ar = $ob->Fetch()) {
		$item['ID'] = $ar['ID'];
		$values[$ar['ID']][] = $ar['PROPERTY_133_VALUE'];
		$item['TIMES_BOOKING'] = $values[$ar['ID']];
		$arResult['ITEMS'][$item['ID']] = $item;
	}

	//разделяем выбранное время по блокам

	foreach($arResult['ITEMS'] as $key => $arItem) {
		$values = array();
		$i = 0;
		foreach ($arItem['TIMES_BOOKING'] as $t => $time) {
			$timetmp = array();
			$timetmp['time'] = explode(' ',$time);
			$timetmp['time'][0] = explode('.',$timetmp['time'][0]);
			$timetmp['time'][1] = explode(':',$timetmp['time'][1]);
			$timetmp['next'] = date('d.m.Y H:i:s',mktime($timetmp['time'][1][0],$timetmp['time'][1][1]+$arParams['TIME_INTERVAL'],$timetmp['time'][1][2],$timetmp['time'][0][1],$timetmp['time'][0][0],$timetmp['time'][0][2]));
			$values[$i][] = $time;
			if($timetmp['next'] != $arItem['TIMES_BOOKING'][$t+1]) {
				$i++;
			}
		}
		$arResult['ITEMS'][$key]['TIMES'] = $values;
	}

	//расчитываем исключения

	$exception = array();
	foreach ($arResult['ITEMS'] as $key => $arItem) {
		foreach($arItem['TIMES'] as $v => $arPeriod) {
			foreach ($arPeriod as $t => $time) {
				if($t != 0) {
					$timetmp = array();
					$timetmp['time'] = explode(' ',$time);
					$timetmp['time'][0] = explode('.',$timetmp['time'][0]);
					$timetmp['time'][1] = explode(':',$timetmp['time'][1]);
					$exception[] = mktime($timetmp['time'][1][0],$timetmp['time'][1][1],$timetmp['time'][1][2],$timetmp['time'][0][1],$timetmp['time'][0][0],$timetmp['time'][0][2]);
				}
			}
		}
	}
	$arResult['GRID']['EXEC'] = $exception;

	if($arParams['USE_JQUERY'] == 'Y')
	{
		$APPLICATION->AddHeadScript('http://yandex.st/jquery/1.7.1/jquery.min.js');
	}

	$this->IncludeComponentTemplate();

?>
