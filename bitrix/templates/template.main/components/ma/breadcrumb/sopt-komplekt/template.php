<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string

__IncludeLang(dirname(__FILE__).'/lang/'.LANGUAGE_ID.'/'.basename(__FILE__));

$curPage = $GLOBALS['APPLICATION']->GetCurPage($get_index_page=false);

if ($curPage != SITE_DIR)
{
	if (empty($arResult) || $curPage != $arResult[count($arResult)-1]['LINK'])
		$arResult[] = array('TITLE' =>  htmlspecialcharsback($GLOBALS['APPLICATION']->GetTitle(false, true)), 'LINK' => $curPage);
}

if(empty($arResult))
	return "";
	
$strReturn = '<div class="b-breadcrumb"><a class="b-breadcrumb__main g-decorated-link" title="'.GetMessage('BREADCRUMB_MAIN').'" href="'.SITE_DIR.'"><span>'.GetMessage('BREADCRUMB_MAIN').'</span></a>';

for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
	$strReturn .= '<span class="b-breadcrumb_separator"> / </span>';

	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	
	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
		$strReturn .= '<a class="g-decorated-link" href="'.$arResult[$index]["LINK"].'" title="'.$title.'"><span>'.$title.'</span></a>';
	else
		$strReturn .= '<span class="b-breadcrumb__current">'.$title.'</span>';
}

$strReturn .= '</div>';

return $strReturn;
?>