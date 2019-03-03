<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$templateLibrary = array('popup');
$currencyList = '';
if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);

unset($currencyList, $templateLibrary);

$skuTemplate = array();
if (!empty($arResult['SKU_PROPS']))
{
	foreach ($arResult['SKU_PROPS'] as $arProp)
	{
		$propId = $arProp['ID'];
		$skuTemplate[$propId] = array(
			'SCROLL' => array(
				'START' => '',
				'FINISH' => '',
			),
			'FULL' => array(
				'START' => '',
				'FINISH' => '',
			),
			'ITEMS' => array()
		);
		$templateRow = '';
		if ('TEXT' == $arProp['SHOW_MODE'])
		{
			$skuTemplate[$propId]['SCROLL']['START'] = '<div class="b-catalog-list_item_scu_size full" id="#ITEM#_prop_'.$propId.'_cont">'.
				'<span class="b-catalog-list_item_scu_prop_title">'.htmlspecialcharsbx($arProp['NAME']).':</span>'.
				'<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';;
			$skuTemplate[$propId]['SCROLL']['FINISH'] = '</ul></div>'.
				'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style=""></div>'.
				'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style=""></div>'.
				'</div></div>';

			$skuTemplate[$propId]['FULL']['START'] = '<div class="b-catalog-list_item_scu_size" id="#ITEM#_prop_'.$propId.'_cont">'.
				'<span class="b-catalog-list_item_scu_prop_title">'.htmlspecialcharsbx($arProp['NAME']).':</span>'.
				'<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';;
			$skuTemplate[$propId]['FULL']['FINISH'] = '</ul></div>'.
				'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style="display: none;"></div>'.
				'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style="display: none;"></div>'.
				'</div></div>';
			foreach ($arProp['VALUES'] as $value)
			{
				$value['NAME'] = htmlspecialcharsbx($value['NAME']);
				$skuTemplate[$propId]['ITEMS'][$value['ID']] = '<li data-treevalue="'.$propId.'_'.$value['ID'].
					'" data-onevalue="'.$value['ID'].'" style="width: #WIDTH#;" title="'.$value['NAME'].'"><i></i><span class="cnt">'.$value['NAME'].'</span></li>';
			}
			unset($value);
		}
		elseif ('PICT' == $arProp['SHOW_MODE'])
		{
			$skuTemplate[$propId]['SCROLL']['START'] = '<div class="b-catalog-list_item_scu_pic full" id="#ITEM#_prop_'.$propId.'_cont">'.
				'<span class="b-catalog-list_item_scu_prop_title">'.htmlspecialcharsbx($arProp['NAME']).':</span>'.
				'<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';
			$skuTemplate[$propId]['SCROLL']['FINISH'] = '</ul></div>'.
				'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style=""></div>'.
				'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style=""></div>'.
				'</div></div>';

			$skuTemplate[$propId]['FULL']['START'] = '<div class="b-catalog-list_item_scu_pic" id="#ITEM#_prop_'.$propId.'_cont">'.
				'<span class="b-catalog-list_item_scu_prop_title">'.htmlspecialcharsbx($arProp['NAME']).':</span>'.
				'<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';
			$skuTemplate[$propId]['FULL']['FINISH'] = '</ul></div>'.
				'<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style="display: none;"></div>'.
				'<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style="display: none;"></div>'.
				'</div></div>';
			foreach ($arProp['VALUES'] as $value)
			{
				$value['NAME'] = htmlspecialcharsbx($value['NAME']);
				$skuTemplate[$propId]['ITEMS'][$value['ID']] = '<li data-treevalue="'.$propId.'_'.$value['ID'].
					'" data-onevalue="'.$value['ID'].'" style="width: #WIDTH#; padding-top: #WIDTH#;"><i title="'.$value['NAME'].'"></i>'.
					'<span class="cnt"><span class="cnt_item" style="background-image:url(\''.$value['PICT']['SRC'].'\');" title="'.$value['NAME'].'"></span></span></li>';
			}
			unset($value);
		}
	}
	unset($templateRow, $arProp);
}

if ($arParams["DISPLAY_TOP_PAGER"])
{
	?><? echo $arResult["NAV_STRING"]; ?><?
}

$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

?>