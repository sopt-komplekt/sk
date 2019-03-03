<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$itemCount = count($arResult);
$needReload = (isset($_REQUEST["compare_list_reload"]) && $_REQUEST["compare_list_reload"] == "Y");
$idCompareCount = 'compareList'.$this->randString();
$obCompare = 'ob'.$idCompareCount;
$idCompareAll = $idCompareCount.'_count';

?>
<div class="b-small-compare" id="<? echo $idCompareCount; ?>">
	<?  
		if ($needReload) {
			$APPLICATION->RestartBuffer(); 
		}
		$frame = $this->createFrame($idCompareCount)->begin('');
	?>
	<a class="b-small-compare__link" href="<? echo $arParams["COMPARE_URL"]; ?>">
		<? echo GetMessage('CP_BCCL_TPL_MESS_COMPARE_PAGE'); ?>
		<? if ($itemCount > 0): ?>
			<span class="b-small-compare__count" id="<? echo $idCompareAll; ?>">(<? echo $itemCount; ?>)</span>
		<? endif; ?>
	</a>
	<? 
		$frame->end(); 
		if ($needReload) {
			die();
		}
	?>
</div>
<?
	$currentPath = CHTTP::urlDeleteParams(
		$APPLICATION->GetCurPageParam(),
		array(
			$arParams['PRODUCT_ID_VARIABLE'],
			$arParams['ACTION_VARIABLE'],
			'ajax_action'
		),
		array("delete_system_params" => true)
	);

	$jsParams = array(
		'VISUAL' => array(
			'ID' => $idCompareCount,
		),
		'AJAX' => array(
			'url' => $currentPath,
			'params' => array(
				'ajax_action' => 'Y'
			),
			'reload' => array(
				'compare_list_reload' => 'Y'
			),
			'templates' => array(
				'delete' => (strpos($currentPath, '?') === false ? '?' : '&').$arParams['ACTION_VARIABLE'].'=DELETE_FROM_COMPARE_LIST&'.$arParams['PRODUCT_ID_VARIABLE'].'='
			)
		)
	);
?>
<script type="text/javascript">
	var <? echo $obCompare; ?> = new JCCatalogCompareList(<? echo CUtil::PhpToJSObject($jsParams, false, true); ?>)
</script>