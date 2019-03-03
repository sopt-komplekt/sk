<?

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