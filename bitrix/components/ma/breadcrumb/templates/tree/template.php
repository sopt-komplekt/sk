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

$IBLOCK_ID = '';

$rsSite = CSite::GetByID(SITE_ID);
$arSite = $rsSite->Fetch();

foreach ($arResult as &$section) {
	if($section["LINK"] == '/' || empty($section["LINK"]))
		continue;
	if(is_dir($arSite["ABS_DOC_ROOT"].$section["LINK"])) {
		$files = scandir($arSite["ABS_DOC_ROOT"].$section["LINK"]);
		foreach ($files as $fileName) {
			if($fileName == "index.php") {
				$fp = fopen($arSite["ABS_DOC_ROOT"].$section["LINK"].$fileName, 'r');
				if($fp) {
					while (($buffer = fgets($fp)) !== false) {
						if(preg_match("/\"IBLOCK_ID\"\s?=>\s?\"(.*)\"/", $buffer, $matches)) {
							break;
						}
					}
					if(!empty($matches) && is_numeric($matches[1])) {
						$IBLOCK_ID = $matches[1];
					}
				}
			}
		}
	}
	$path = explode('/', $section["LINK"]);
	foreach($path as $key => $value) {
		if(empty($value)) {
			unset($path[$key]);
		}
	}

	if(!empty($path) && is_numeric($IBLOCK_ID)) {
		$res = CIBlockSection::GetList(array(),array("CODE" => end($path),"IBLOCK_ID" => $IBLOCK_ID),false,array("ID"));
		$arrSection = $res->Fetch();
		$res = CIBlockSection::GetList(
			array("SORT" => "ASC"),
			array(
				"IBLOCK_ID" => $IBLOCK_ID,
				"SECTION_ID" => $arrSection["ID"],
				"ACTIVE" => "Y",
				"GLOBAL_ACTIVE" => "Y",
			),
			false,
			array("ID","CODE","NAME","IBLOCK_ID","SECTION_PAGE_URL")
		);
		while ($arr = $res->GetNext()) {
			$section["SECTIONS"][] = $arr;
		}
	}
	elseif(is_numeric($IBLOCK_ID)) {
		$res = CIBlockSection::GetList(
			array("SORT" => "ASC"),
			array(
				"IBLOCK_ID" => $IBLOCK_ID,
				"DEPTH_LEVEL" => 1,
				"ACTIVE" => "Y",
				"GLOBAL_ACTIVE" => "Y",
			),
			false,
			array("ID","CODE","NAME","IBLOCK_ID","SECTION_PAGE_URL")
		);
		while ($arr = $res->GetNext()) {
			$section["SECTIONS"][] = $arr;
		}
		$arrSection = $res->Fetch();
	}
	unset($res,$arrSection);
}

if(empty($arResult))
	return "";
	
$strReturn = '<div class="b-breadcrumb"><div class="b-breadcrumb-item"><a class="b-breadcrumb_main" title="'.GetMessage('BREADCRUMB_MAIN').'" href="'.SITE_DIR.'">'.GetMessage('BREADCRUMB_MAIN').'</a></div>';

for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
	$strReturn .= '<div class="b-breadcrumb-item'.($index == $itemSize-1 ? " b-breadcrumb-item-last" : "").((isset($arResult[$index]["SECTIONS"]) && !empty($arResult[$index]["SECTIONS"]) && $index != $itemSize-1) ? " b-breadcrumb-item-parent" : "").'">';

	$strReturn .= '<span class="b-breadcrumb_separator"> &#62; </span>';

	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	
	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
		$strReturn .= '<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a>';
	else
		$strReturn .= '<span>'.$title.'</span>';

	if(isset($arResult[$index]["SECTIONS"]) && !empty($arResult[$index]["SECTIONS"]) && $index != (count($arResult) -1)) {
		$strReturn .= '<span class="b-breadcrumb-item-arrow"></span>';
		$strReturn .= '<div class="b_breadcrumb-item-sections">';
		foreach ($arResult[$index]["SECTIONS"] as $key => $arSection) {
			$strReturn .= '
			<div class="b_breadcrumb-item-section b-sid-'.$arSection["ID"].' '.($arSection["SECTION_PAGE_URL"] == $arResult[$index+1]["LINK"] ? " active" : "").'">
				<a href="'.$arSection["SECTION_PAGE_URL"].'" title="'.$arSection["NAME"].'">
					'.$arSection["NAME"].'
				</a>
			</div>';
		}
		$strReturn .= '</div>';
	}
	$strReturn .= '</div>';
}

$strReturn .= '<div style="clear:both"></div></div>';

return $strReturn;
?>