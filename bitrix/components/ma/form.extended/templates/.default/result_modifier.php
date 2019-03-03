<?

function HumanBytes($size) 
{
	$filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
	return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
} 

if(!empty($_GET))
{
	foreach ($_GET as $key => $value)
	{	
		if(empty($arResult['POST'][$key])){
			$arResult['POST'][$key] = htmlentities($value);
		}
	}
}

?>