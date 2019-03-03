<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<?
	$frame = $this->createFrame()->begin("");
	$injectId = 'bigdata_recommeded_products_'.rand();
?>
<script type="text/javascript">
	BX.cookie_prefix = '<?=CUtil::JSEscape(COption::GetOptionString("main", "cookie_name", "BITRIX_SM"))?>';
	BX.cookie_domain = '<?=$APPLICATION->GetCookieDomain()?>';
	BX.current_server_time = '<?=time()?>';

	BX.ready(function(){
		bx_rcm_recommendation_event_attaching(BX('<?=$injectId?>_items'));
	});

</script>

<?
if (isset($arResult['REQUEST_ITEMS']))
{
	CJSCore::Init(array('ajax'));

	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedParameters = $signer->sign(
		base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
		'bx.bd.products.recommendation'
	);
	$signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

	?>
	<span id="<?=$injectId?>"></span>

	<script type="text/javascript">
		BX.ready(function(){
			bx_rcm_get_from_cloud(
				'<?=CUtil::JSEscape($injectId)?>',
				<?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
				{
					'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
					'template': '<?=CUtil::JSEscape($signedTemplate)?>',
					'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
					'rcm': 'yes'
				}
			);
		});
	</script>
	<?
	$frame->end();
	return;
}

?>
<? if (count($arResult['ITEMS']) > 0) :?>
	<span id="<?=$injectId?>_items" class="bigdata_recommended_products_items">
		<input type="hidden" name="bigdata_recommendation_id" value="<?=htmlspecialcharsbx($arResult['RID'])?>">
		<script>
			console.log('test');
		</script>
	<div class="b-catalog-elements-blocks">
		<?
		foreach ($arResult['ITEMS'] as $key => $arElement):
			$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CATALOG_ELEMENT_DELETE_CONFIRM')));	
		?>
			<div class="b-catalog-elements-blocks_item b-sebi-<?=$arElement['ID']?>" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
	
				<div class="b-catalog-elements-blocks_holder">
					<a
						href="<?=$arElement['DETAIL_PAGE_URL'];?>"
						class="b-catalog-elements-blocks_image"
						<?php if ($arElement['PREVIEW_PICTURE']['SRC']): ?>
							style="background-image: url('<?=$arElement['PREVIEW_PICTURE']['SRC']?>');"
						<?php endif ?>
					>
						<?=$arElement['NAME'] ?>
					</a>
					<div class="b-catalog-elements-blocks_text">
						<? if($arElement['NAME'] && $arResult['SECTION']['ID'] != $arElement['ID']): ?>
							<div class="b-catalog-elements-blocks_name">
								<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
							</div>
						<? endif; ?>
						<? if ($arElement['PREVIEW_TEXT']): ?>
							<div class="b-catalog-elements-blocks_description">
								<?=$arElement['PREVIEW_TEXT_TYPE'] == 'text' ? $arElement['PREVIEW_TEXT'] : $arElement['~PREVIEW_TEXT']?>
							</div>
						<? endif; ?>
						
						<? if($arElement["PRICE"]): ?>
							<div class="b-catalog-elements-blocks_order">
								<div class="b-catalog-elements-blocks_price">
									<!-- <span><?=GetMessage("CATALOG_PRICE")?></span> -->
									<?=$arElement["PRICE"]["PRINT_VALUE"]?>
								</div>
								<div class="b-catalog-elements-blocks_buy">
									<noindex>
										<? if(isset($arResult['SHOP_BASKET']['ITEMS'][$arElement['ID']])): ?>
											<a class="g-button-disabled" rel="nofollow" href="<?=$arParams['SEF_FOLDER']?><?=$arParams['SEF_URL_TEMPLATES_ORDER']?>"><?=$arParams['IN_BASKET_TEXT']?></a>
										<? else: ?>
											<a class="g-button" rel="nofollow" href="<?=$arParams['SEF_FOLDER']?>/basket/?action=add&id=<?=$arElement['ID']?>"><?=$arParams['TO_BASKET_TEXT']?></a>
										<? endif; ?>
									</noindex>
								</div>
							</div>
						<? endif; ?>
					</div>
					<div class="b-catalog-elements-blocks_supply">
						<? foreach($arElement["PRICES"] as $code=>$arPrice): ?>
							<? if($arPrice["CAN_ACCESS"]): ?>
								<div class="bmcl_supply-value">
									<span><?=GetMessage("CATALOG_PRICE")?></span>
									<? if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]): ?>
										<span class="catalog-detail-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span> <s><span><?=$arPrice["PRINT_VALUE"]?></span></s>
									<? else: ?>
										<span class="catalog-detail-price"><?=$arPrice["PRINT_VALUE"]?></span>
									<? endif; ?>
								</div>
							<? endif; ?>
						<? endforeach; ?>
						
						<? if($arElement["CAN_BUY"]): ?>
							<div class="bmcl_supply-buttons">
								<!--noindex-->
									<a
										class="g-add-cart g-ajax-data"
										href="<?=$arElement["ADD_URL"]?>"
										rel="nofollow"
										id="catalog_add2cart_link_<?=$arElement["ID"]?>"
									>
										<span><?=GetMessage("CATALOG_ADD_TO_BASKET")?></span>
									</a>
								<!--/noindex-->
							</div>
						<? endif; ?>
			
						<? if(!$arElement["CAN_BUY"] && (count($arElement["PRICES"]) > 0)): ?>
							<div class="bmcl_supply-not-available">
								<!--noindex--><?=GetMessage("CATALOG_NOT_AVAILABLE");?><!--/noindex-->
							</div>
						<? endif; ?>
						
						<? if($arParams["USE_COMPARE"] == "Y"): ?>
							<div class="bmcl_supply-compare">
								<a href="<?=$arElement["COMPARE_URL"]?>" class="catalog-item-compare" onclick="return addToCompare(this, '<?=GetMessage("CATALOG_IN_COMPARE")?>');" rel="nofollow" id="catalog_add2compare_link_<?=$arElement["ID"]?>" rel="nofollow"><?=GetMessage("CATALOG_COMPARE")?></a>
							</div>
						<? endif; ?>
						
					</div>
				</div>
			</div>
		<? endforeach; ?>
		<div class="g-clean"></div>
	</div>
	</span>
	
<? endif; ?>

<?php $frame->end(); ?>