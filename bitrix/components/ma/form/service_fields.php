<?
$userInfo = '';
if($_SERVER["REMOTE_ADDR"]) {
	require_once(dirname(__FILE__)."/ipgeobase.php");
	$gb = new MARegionsIPGeoBase();
	$userInfo .= GetMessage("SERVICE_IP_ADDRESS") . $_SERVER["REMOTE_ADDR"] . ";\n";
	$arCity = $gb->getRecord($_SERVER["REMOTE_ADDR"]);
	$userInfo .= GetMessage("SERVICE_CITY") . $arCity["CITY"] . ";\n";
}

if($_SERVER["HTTP_REFERER"]) {
	$userInfo .= GetMessage("HTTP_REFERER") . urldecode($_SERVER["HTTP_REFERER"]) . "\n";
}

if($_SERVER["REQUEST_URI"]) {
	$userInfo .= GetMessage("REQUEST_URI") . urldecode($_SERVER["REQUEST_URI"]) . "\n";
}

if($_SERVER["HTTP_USER_AGENT"]) {

	$userInfo .= GetMessage("HTTP_USER_AGENT") . $_SERVER["HTTP_USER_AGENT"] . "\n";

	$userBrowser = getBrowserName($_SERVER["HTTP_USER_AGENT"]);

	if($userBrowser["BROWSER"]) {
		$userInfo .= GetMessage("SERVICE_BROWSER") . $userBrowser["BROWSER"] . ";\n";
	}

	if($userBrowser["VERSION"]) {
		$userInfo .= GetMessage("SERVICE_BROWSER_VERSION") . $userBrowser["VERSION"] . ";\n";
	}

	if($userBrowser["OPERATE_SYSTEM"]) {
		$userInfo .= GetMessage("SERVICE_OPERATE_SYSTEM") . $userBrowser["OPERATE_SYSTEM"] . ";\n";
	}
}

global $USER;
if($USER->IsAuthorized()) {
	if($USER->GetID()) {
		$userInfo .= GetMessage("SERVICE_USER_ID") . $USER->GetID() . ";\n";
	}
	if($USER->GetFullName()) {
		$userInfo .= GetMessage("SERVICE_USER_NAME") . $USER->GetFullName() . ";\n";
	}
}
else {
	$userInfo .= GetMessage("SERVICE_USER_NOT_AUTH")."\n";
}

if($arParams["USE_SERVICE_USER_PRODUCTS"] == "Y" && CModule::IncludeModule('sale')) {
	$dbItems = CSaleBasket::GetList(
		array("ID" => "ASC"),
		array(
			"FUSER_ID" => CSaleBasket::GetBasketUserID(),
			"LID" => SITE_ID,
			"ORDER_ID" => "NULL"
		),
		false,
		false,
		array(
			"NAME",
			"PRODUCT_ID",
			"QUANTITY",
			"CAN_BUY",
			"PRICE",
			"DETAIL_PAGE_URL",
			"DISCOUNT_PRICE"
		)
	);

	$userInfo .= GetMessage("SERVICE_PRODUCTS");
	while ($arItem = $dbItems->GetNext(true,false))
	{
		if($arItem["DISCOUNT_PRICE"] > 0) {
			$price = $arItem["PRICE"] - $arItem["DISCOUNT_PRICE"];
		} else {
			$price = $arItem["PRICE"];
		}
		$userInfo .= GetMessage("SERVICE_PRODUCT_ID") . $arItem["PRODUCT_ID"] . GetMessage("SERVICE_PRODUCT_NAME") . $arItem["NAME"] . GetMessage("SERVICE_PRODUCT_QTY") . $arItem["QUANTITY"] . GetMessage("SERVICE_PRODUCT_PRICE") . number_format($price,0,""," ") . "\n";
	}
}

$arResult["POST"]["FIELD_".$arParams["SERVICE_USER_FIELDS_PROPERTY"]] = $userInfo;

function getBrowserName($agent = '') {
	$browser = '';
	$version = '';
	$altname = '';
	$operateSystem = '';
	if(is_int($pos = stripos($agent, 'Android'))) {
		$browser = 'Android';
		$pos += 7;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Amaya'))) {
		$browser = 'Amaya';
		$pos += 5;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'America Online Browser'))) {
		$browser = 'AOL Browser';
		$pos += strlen('America Online Browser');
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Avant Browser'))) {
		$browser = 'Avant Browser';
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Advanced Browser'))) {
		$browser = 'Avant Browser';
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Camino'))) {
		$browser = 'Camino';
		$pos += 6;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'ELinks'))) {
		$browser = 'ELinks';
		$pos += 6;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Epiphany'))) {
		$browser = 'Epiphany';
		$pos += 8;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Flock'))) {
		$browser = 'Flock';
		$pos += 5;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Chrome'))) {
		$browser = 'Google Chrome';
		$pos += 6;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'IceWeasel'))) {
		$browser = 'IceWeasel';
		$pos += 9;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'IceCat'))) {
		$browser = 'IceCat';
		$pos += 6;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'iCab'))) {
		$browser = 'iCab';
		$pos += 4;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'K-Meleon'))) {
		$browser = 'K-Meleon';
		$pos += 8;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Konqueror'))) {
		$browser = 'Konqueror';
		$pos += 9;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Links'))) {
		$browser = 'Links';
		$pos += 5;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Lynx'))) {
		$browser = 'Lynx';
		$pos += 4;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Minimo'))) {
		$browser = 'Minimo';
		$pos += 6;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Splashtop'))) {
		$browser = 'Splashtop Browser';
		$pos += 9;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Phoenix'))) {
		$browser = 'Firefox';
		$altname = 'Phoenix';
		$pos += 7;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Firebird'))) {
		$browser = 'Firefox';
		$altname = 'Firebird';
		$pos += 8;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'GranParadiso'))) {
		$browser = 'Firefox';
		$altname = 'GranParadiso';
		$pos += 12;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Shiretoko'))) {
		$browser = 'Firefox';
		$altname = 'Shiretoko';
		$pos += 9;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Firefox'))) {
		$browser = 'Firefox';
		$pos += 7;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Netscape'))) {
		$browser = 'Netscape';
		$pos += 8;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'WebPro'))) {
		$browser = 'Novarra';
		$pos += 6;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'OffByOne'))) {
		$browser = 'Off By One';
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'OmniWeb'))) {
		$browser = 'OmniWeb';
		$pos += 7;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'OPWV'))) {
		$browser = 'Openwave';
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Opera'))) {
		$browser = 'Opera';
		$pos += 5;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
		if(is_int(stripos($agent, 'Nokia')) or is_int(stripos($agent, 'Mobi')))
			$browser = 'Opera Mobile';
		elseif(is_int(stripos($agent, 'Mini')))
			$browser = 'Opera Mini';
	} elseif(is_int($pos = stripos($agent, 'PlayStation Portable'))) {
		$browser = 'PlayStation Portable';
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'PLAYSTATION'))) {
		$browser = 'PlayStation';
		$pos += 11;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Shiira'))) {
		$browser = 'Shiira';
		$pos += 6;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'NokiaN'))) {
		$browser = 'Web browser S60 (mobile)';
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Safari'))) {
		$browser = 'Safari';
		$pos += 6;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
		if(is_int(stripos($agent, 'Mobile')))
			$browser = 'Safari Mobile';
	} elseif(is_int($pos = stripos($agent, 'SeaMonkey'))) {
		$browser = 'SeaMonkey';
		$pos += 9;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'w3m'))) {
		$browser = 'w3m';
		$pos += 3;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'WebExplorer'))) {
		$browser = 'WebExplorer';
		$pos += 17;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'MSIE'))) {
		$browser = 'Internet Explorer';
		$pos += 4;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
		if(is_int(stripos($agent, 'Smartphone')) or is_int(stripos($agent, 'PPC')) or is_int(stripos($agent, 'Motorola')) or is_int(stripos($agent, 'IEMobile')))
			$browser = 'Internet Explorer Mobile';
	} elseif(is_int($pos = stripos($agent, 'MSPIE'))) {
		$browser = 'Internet Explorer Mobile';
		$pos += 5;
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Microsoft Pocket Internet Explorer'))) {
		$browser = 'Internet Explorer Mobile';
		$pos += strlen('Microsoft Pocket Internet Explorer');
		$version = getBrowserVersion($agent, $pos);
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Mozilla'))) {
		$browser = 'Netscape Navigator';
		$pos += 7;
		$version = getBrowserVersion($agent, $pos);
		if(is_int(stripos($agent, 'Gecko'))) {
			$browser = 'Mozilla';
			$pos = stripos($agent, 'rv:') + 3;
			$version = getBrowserVersion($agent, $pos);
		}
		$operateSystem = getOS($agent);
	} elseif(is_int($pos = stripos($agent, 'Microsoft Internet Explorer'))) {
		$browser = 'Internet Explorer';
		$version = '1.0';
		$operateSystem = getOS($agent);
	}
	$ret = array(
		"BROWSER" => $browser,
		"VERSION" => $version,
		"ALT_NAME" => $altname,
		"OPERATE_SYSTEM" => $operateSystem,
	);
	return($ret);
}
function getBrowserVersion($agent = '', $start = 0) {
	$version = '';
	$length = strlen($agent);
	if($start >= $length) $start = $length - 1;
	for($i = $start; $i < $length; $i++) {
		if($agent{$i} === '(') continue;
		if(is_numeric($agent{$i}) or $agent{$i} === '.' or $agent{$i} === '/') {
			if($agent{$i} === '/' and empty($version)) continue;
			$version .= $agent{$i};
		} else
			if(!empty($version)) break;
	}
	return($version);
}
function getOS($userAgent) {
	$oses = array (
		'iOS 12' => 'iPhone OS 12',
		'iOS 11' => 'iPhone OS 11',
		'iOS 10' => 'iPhone OS 10',
		'iOS 9' => 'iPhone OS 9',
		'iPhone' => '(iPhone)',
		'Android 4' => 'Android 4',
		'Android 5' => 'Android 5',
		'Android 6' => 'Android 6',
		'Android 7' => 'Android 7',
		'Android 8' => 'Android 8',
		'Android' => 'Android',
		'Windows 3.11' => 'Win16',
		'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
		'Windows 98' => '(Windows 98)|(Win98)',
		'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
		'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
		'Windows 2003' => '(Windows NT 5.2)',
		'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
		'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
		'Windows 10' => '(Windows NT 10.0)',
		'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
		'Windows ME' => 'Windows ME',
		'Open BSD'=>'OpenBSD',
		'Sun OS'=>'SunOS',
		'Linux'=>'(Linux)|(X11)',
		'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
		'Safari' => '(Safari)',
		'QNX'=>'QNX',
		'BeOS'=>'BeOS',
		'OS/2'=>'OS/2',
		'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
	);
	foreach($oses as $os=>$pattern){
		if(preg_match("/$pattern/i", $userAgent)) {
			return $os;
		}
	}
	return 'Unknown'; // Хрен его знает, чего у него на десктопе стоит.
}