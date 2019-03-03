<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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

$this->setFrameMode(true);
?>
<? 
if (empty($arResult['ITEMS'])) return;

include_once($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/offers-init.php');

?>

<div class="b-products-block g-pattern-filled">
	<? 
	foreach ($arResult['ITEMS'] as $key => $arItem):

	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
	$strMainID = $this->GetEditAreaId($arItem['ID']);

	$arItemIDs = array(
		'ID' => $strMainID,
		'PICT' => $strMainID.'_pict',
		//'SECOND_PICT' => $strMainID.'_secondpict',
		'STICKER_ID' => $strMainID.'_sticker',
		'SECOND_STICKER_ID' => $strMainID.'_secondsticker',
		'QUANTITY' => $strMainID.'_quantity',
		'QUANTITY_DOWN' => $strMainID.'_quant_down',
		'QUANTITY_UP' => $strMainID.'_quant_up',
		'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
		'BUY_LINK' => $strMainID.'_buy_link',
		'BASKET_ACTIONS' => $strMainID.'_basket_actions',
		'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
		'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
		'COMPARE_LINK' => $strMainID.'_compare_link',

		'PRICE' => $strMainID.'_price',
		'DSC_PERC' => $strMainID.'_dsc_perc',
		'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',
		'PROP_DIV' => $strMainID.'_sku_tree',
		'PROP' => $strMainID.'_prop_',
		'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
		'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
	);

	$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

	$productTitle = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
		: $arItem['NAME']
	);
	$imgTitle = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
		: $arItem['NAME']
	);

	$minPrice = false;
	if (isset($arItem['MIN_PRICE']) || isset($arItem['RATIO_PRICE']))
		$minPrice = (isset($arItem['RATIO_PRICE']) ? $arItem['RATIO_PRICE'] : $arItem['MIN_PRICE']);

	?>
		<div class="b-products-block__item b-sebi-<?=$arItem['ID']?> jsProductTable" id="<?=$strMainID;?>">
			<div class="b-products-block__holder">
				<div class="b-products-block__picture">
					<a class="b-products-block__picture-img"  href="<?=$arItem['DETAIL_PAGE_URL']; ?>" title="<?=$imgTitle;?>" style="background-image: url('<? echo $arItem['PREVIEW_PICTURE']['SRC'] ? $arItem['PREVIEW_PICTURE']['SRC'] : $templateFolder.'/images/no_photo@1x.png'?>')" id="<? echo $arItemIDs['PICT']; ?>"></a>
					<? if ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y' && $minPrice['DISCOUNT_DIFF_PERCENT'] > 0): ?>
						<div class="b-products-block__discount" id="<?=$arItemIDs['DSC_PERC'];?>">-<?=$minPrice['DISCOUNT_DIFF_PERCENT'];?>%</div>
					<? endif; ?>
					<? if ($arItem['LABEL']): ?>
						<div class="b-products-block__label" title="<?=$arItem['LABEL_VALUE']; ?>" id="<?=$arItemIDs['STICKER_ID'];?>">Хит</div>
					<? endif; ?>
				</div>

				<div class="b-products-block__info">

					<div class="b-products-block__title">
						<a class="g-decorated-link" href="<?=$arItem['DETAIL_PAGE_URL']; ?>"><span><?=$productTitle;?></span></a>
					</div>

					<? //Артикул ?>
					<? if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])): ?>
						<? if (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES'])): ?>
							<div class="b-products-block__articul">
								<? foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp): ?>
									<div class="b-products-block__articul-item">
										<b><?=$arOneProp['NAME']; ?>:</b>
										<?  echo (
												is_array($arOneProp['DISPLAY_VALUE'])
												? implode('<br>', $arOneProp['DISPLAY_VALUE'])
												: $arOneProp['DISPLAY_VALUE']
											);
										?>
									</div>
								<? endforeach; ?>
							</div>
						<? endif; ?>
					<? else: ?>
						<? 
							$boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));
							$boolShowOfferProps = ($arParams['PRODUCT_DISPLAY_MODE'] == 'Y' && $arItem['OFFERS_PROPS_DISPLAY']);
						?>
						<? if ($boolShowProductProps || $boolShowOfferProps): ?>
							<div class="b-products-block__articul">
								<? if($boolShowProductProps): ?>
									<? foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp): ?>
										<div class="b-products-block__articul-item">
											<b><?=$arOneProp['NAME']; ?>:</b>
											<?  echo (
													is_array($arOneProp['DISPLAY_VALUE'])
													? implode(' / ', $arOneProp['DISPLAY_VALUE'])
													: $arOneProp['DISPLAY_VALUE']
												);
											?>
										</div>
									<? endforeach; ?>
								<? endif; ?>
								<? if($boolShowOfferProps): ?>
									<span id="<? echo $arItemIDs['DISPLAY_PROP_DIV']; ?>" style="display: none;"></span>
								<? endif; ?>
							</div>
						<? endif; ?>

					<? endif; ?>

					<? if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])): ?>

						<? $emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']); ?>

						<? if ($arParams['ADD_PROPERTIES_TO_BASKET'] == "Y" && !$emptyProductProperties): ?>

							<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
							<?
								if (!empty($arItem['PRODUCT_PROPERTIES_FILL']))
								{
									foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
									{
							?>
										<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
							<?
										if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
											unset($arItem['PRODUCT_PROPERTIES'][$propID]);
									}
								}
								$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
								if (!$emptyProductProperties)
								{
							?>
									<table>
							<?
										foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo)
										{
							?>
											<tr><td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
												<td>
							<?
													if(
														'L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']
														&& 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']
													)
													{
														foreach($propInfo['VALUES'] as $valueID => $value)
														{
															?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
														}
													}
													else
													{
														?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
														foreach($propInfo['VALUES'] as $valueID => $value)
														{
															?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? 'selected' : ''); ?>><? echo $value; ?></option><?
														}
														?></select><?
													}
							?>
												</td></tr>
							<?
										}
							?>
									</table>
							<?
								}
							?>
							</div>

						<? endif; ?>

						<?
							$arJSParams = array(
								'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
								'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
								'SHOW_ADD_BASKET_BTN' => false,
								'SHOW_BUY_BTN' => true,
								'SHOW_ABSENT' => true,
								'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
								'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
								'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
								'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
								'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
								'PRODUCT' => array(
									'ID' => $arItem['ID'],
									'NAME' => $productTitle,
									'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
									'CAN_BUY' => $arItem["CAN_BUY"],
									'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
									'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
									'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
									'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
									'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
									'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL'],
									'BASIS_PRICE' => $arItem['MIN_BASIS_PRICE']
								),
								'BASKET' => array(
									'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
									'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
									'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
									'EMPTY_PROPS' => $emptyProductProperties,
									'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
									'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
								),
								'VISUAL' => array(
									'ID' => $arItemIDs['ID'],
									'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
									'QUANTITY_ID' => $arItemIDs['QUANTITY'],
									'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
									'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
									'PRICE_ID' => $arItemIDs['PRICE'],
									'BUY_ID' => $arItemIDs['BUY_LINK'],
									'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV'],
									'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
									'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
									'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
								),
								'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
							);
							if ($arParams['DISPLAY_COMPARE'])
							{
								$arJSParams['COMPARE'] = array(
									'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
									'COMPARE_PATH' => $arParams['COMPARE_PATH']
								);
							}
							unset($emptyProductProperties);
						?>

						<script type="text/javascript">
							var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
						</script>

					<? else: ?>

						<?  // Свойства торговых предложений

							if ($arParams['PRODUCT_DISPLAY_MODE'] == 'Y')
							{
								if (!empty($arItem['OFFERS_PROP']))
								{
									$arSkuProps = array();
						?>

									<div class="b-products-block__scu" id="<? echo $arItemIDs['PROP_DIV']; ?>">
										<?
										foreach ($skuTemplate as $propId => $propTemplate)
										{
											if (!isset($arItem['SKU_TREE_VALUES'][$propId]))
												continue;
											$valueCount = count($arItem['SKU_TREE_VALUES'][$propId]);
											if ($valueCount > 5)
											{
												$fullWidth = ($valueCount*20).'%';
												$itemWidth = (100/$valueCount).'%';
												$rowTemplate = $propTemplate['SCROLL'];
											}
											else
											{
												$fullWidth = '100%';
												$itemWidth = '20%';
												$rowTemplate = $propTemplate['FULL'];
											}
											unset($valueCount);
											echo '<div class="b-catalog-list_item_scu_prop">', str_replace(array('#ITEM#_prop_', '#WIDTH#'), array($arItemIDs['PROP'], $fullWidth), $rowTemplate['START']);
											foreach ($propTemplate['ITEMS'] as $value => $valueItem)
											{
												if (!isset($arItem['SKU_TREE_VALUES'][$propId][$value]))
													continue;
												echo str_replace(array('#ITEM#_prop_', '#WIDTH#'), array($arItemIDs['PROP'], $itemWidth), $valueItem);
											}
											unset($value, $valueItem);
											echo str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $rowTemplate['FINISH']), '</div>';
										}
										unset($propId, $propTemplate);
										foreach ($arResult['SKU_PROPS'] as $arOneProp)
										{
											if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
												continue;
											$arSkuProps[] = array(
												'ID' => $arOneProp['ID'],
												'SHOW_MODE' => $arOneProp['SHOW_MODE'],
												'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
											);
										}
										foreach ($arItem['JS_OFFERS'] as &$arOneJs)
										{
											if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
											{
												$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
												$arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
											}
										}
										unset($arOneJs);
										?>
									</div>

									<?
									if ($arItem['OFFERS_PROPS_DISPLAY'])
									{
										foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer)
										{
											$strProps = '';
											if (!empty($arJSOffer['DISPLAY_PROPERTIES']))
											{
												foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp)
												{
													$strProps .= '<div class="b-products-block__articul-item"><b>'.$arOneProp['NAME'].'</b>'.(
														is_array($arOneProp['VALUE'])
														? implode(' / ', $arOneProp['VALUE'])
														: $arOneProp['VALUE']
													).'</div>';
												}
											}
											$arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
										}
									}
									$arJSParams = array(
										'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
										'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
										'SHOW_ADD_BASKET_BTN' => false,
										'SHOW_BUY_BTN' => true,
										'SHOW_ABSENT' => true,
										'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
										//'SECOND_PICT' => $arItem['SECOND_PICT'],
										'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
										'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
										'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
										'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
										'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
										'DEFAULT_PICTURE' => array(
											'PICTURE' => $arItem['PRODUCT_PREVIEW'],
											'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
										),
										'VISUAL' => array(
											'ID' => $arItemIDs['ID'],
											'PICT_ID' => $arItemIDs['PICT'],
											//'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
											'QUANTITY_ID' => $arItemIDs['QUANTITY'],
											'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
											'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
											'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
											'PRICE_ID' => $arItemIDs['PRICE'],
											'TREE_ID' => $arItemIDs['PROP_DIV'],
											'TREE_ITEM_ID' => $arItemIDs['PROP'],
											'BUY_ID' => $arItemIDs['BUY_LINK'],
											'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
											'DSC_PERC' => $arItemIDs['DSC_PERC'],
											'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
											'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
											'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
											'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
											'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
										),
										'BASKET' => array(
											'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
											'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
											'SKU_PROPS' => $arItem['OFFERS_PROP_CODES'],
											'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
											'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
										),
										'PRODUCT' => array(
											'ID' => $arItem['ID'],
											'NAME' => $productTitle
										),
										'OFFERS' => $arItem['JS_OFFERS'],
										'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
										'TREE_PROPS' => $arSkuProps,
										'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
									);

									if ($arParams['DISPLAY_COMPARE'])
									{
										$arJSParams['COMPARE'] = array(
											'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
											'COMPARE_PATH' => $arParams['COMPARE_PATH']
										);
									}
								?>

								<script type="text/javascript">
									var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
								</script>

						<?
								}
							}
							else
							{
								$arJSParams = array(
									'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
									'SHOW_QUANTITY' => false,
									'SHOW_ADD_BASKET_BTN' => false,
									'SHOW_BUY_BTN' => false,
									'SHOW_ABSENT' => false,
									'SHOW_SKU_PROPS' => false,
									//'SECOND_PICT' => $arItem['SECOND_PICT'],
									'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
									'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
									'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
									'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
									'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
									'DEFAULT_PICTURE' => array(
										'PICTURE' => $arItem['PRODUCT_PREVIEW'],
										'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
									),
									'VISUAL' => array(
										'ID' => $arItemIDs['ID'],
										'PICT_ID' => $arItemIDs['PICT'],
										//'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
										'QUANTITY_ID' => $arItemIDs['QUANTITY'],
										'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
										'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
										'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
										'PRICE_ID' => $arItemIDs['PRICE'],
										'TREE_ID' => $arItemIDs['PROP_DIV'],
										'TREE_ITEM_ID' => $arItemIDs['PROP'],
										'BUY_ID' => $arItemIDs['BUY_LINK'],
										'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
										'DSC_PERC' => $arItemIDs['DSC_PERC'],
										'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
										'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
										'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
										'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
										'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
									),
									'BASKET' => array(
										'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
										'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
										'SKU_PROPS' => $arItem['OFFERS_PROP_CODES'],
										'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
										'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
									),
									'PRODUCT' => array(
										'ID' => $arItem['ID'],
										'NAME' => $productTitle
									),
									'OFFERS' => array(),
									'OFFER_SELECTED' => 0,
									'TREE_PROPS' => array(),
									'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
								);
								if ($arParams['DISPLAY_COMPARE'])
								{
									$arJSParams['COMPARE'] = array(
										'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
										'COMPARE_PATH' => $arParams['COMPARE_PATH']
									);
								}
						?>
					
								<script type="text/javascript">
								var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
								</script>

						<?
							} 
						?>
					<? endif; ?>

				</div>

				<div class="b-products-block__order">


					<? if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])): ?>

						<? if ($arParams['USE_PRODUCT_QUANTITY'] == 'Y') :?>
							<div class="b-products-block__controls">
								<div class="b-catalog-list_item_controls_quantity">
									<span>Количество:</span>
									<a id="<?=$arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="b-catalog-list_item_controls_quantity_minus" rel="nofollow">–</a>
									<input type="text" class="b-catalog-list_item_controls_quantity_input" id="<?=$arItemIDs['QUANTITY']; ?>" name="<?=$arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<?=$arItem['CATALOG_MEASURE_RATIO']; ?>">
									<a id="<?=$arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="b-catalog-list_item_controls_quantity_plus" rel="nofollow">+</a>
									<span id="<?=$arItemIDs['QUANTITY_MEASURE']; ?>"></span>
								</div>
							</div>
						<? endif; ?>

					<? else: ?>

						<? if ($arParams['PRODUCT_DISPLAY_MODE'] == "Y"): ?>
							<? $canBuy = $arItem['JS_OFFERS'][$arItem['OFFERS_SELECTED']]['CAN_BUY']; ?>
							<div class="b-products-block__controls no_touch">
								<? //if ($canBuy): ?>
									<? if ($arParams['USE_PRODUCT_QUANTITY'] == 'Y') :?>
										<span>Количество:</span>
										<div class="b-catalog-list_item_controls_quantity">
											<a id="<?=$arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="b-catalog-list_item_controls_quantity_minus" rel="nofollow">–</a>
											<input type="text" class="b-catalog-list_item_controls_quantity_input" id="<?=$arItemIDs['QUANTITY']; ?>" name="<?=$arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<?=$arItem['CATALOG_MEASURE_RATIO']; ?>">
											<a id="<?=$arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="b-catalog-list_item_controls_quantity_plus" rel="nofollow">+</a>
											<span id="<?=$arItemIDs['QUANTITY_MEASURE']; ?>"></span>
										</div>
									<? endif; ?>
								<? //endif; ?>
							</div>
							<? unset($canBuy); ?>
						<? endif; ?>

					<? endif; ?>

					<div class="b-products-block__price">
						<div id="<?=$arItemIDs['PRICE']; ?>" class="bx_price">
							<? if(!empty($minPrice)): ?>
								<? if('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])): ?>
									<?
										echo GetMessage(
											'CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE',
											array(
												'#PRICE#' => $minPrice['PRINT_DISCOUNT_VALUE'],
												'#MEASURE#' => GetMessage(
													'CT_BCS_TPL_MESS_MEASURE_SIMPLE_MODE',
													array(
														'#VALUE#' => $minPrice['CATALOG_MEASURE_RATIO'],
														'#UNIT#' => $minPrice['CATALOG_MEASURE_NAME']
													)
												)
											)
										);
									?>
								<? else: ?>
									<div class="b-current-price g-accent-font"><?=$minPrice['PRINT_DISCOUNT_VALUE'];?></div>
								<? endif; ?>
								<? if('Y' == $arParams['SHOW_OLD_PRICE'] && $minPrice['DISCOUNT_VALUE'] < $minPrice['VALUE']): ?>
									<div class="b-old-price">Старая цена: <?=$minPrice['PRINT_VALUE'];?></div>
								<? endif; ?>
								<? unset($minPrice); ?> 
							<? endif; ?>
						</div>
					</div>

					<? if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])): ?>

						<? /* if($arParams['DISPLAY_COMPARE']): ?>
							<div class="b-catalog-list_item_controls_compare">
								<a id="<?=$arItemIDs['COMPARE_LINK']; ?>" href="javascript:void(0)"><?=GetMessage('CT_BCS_TPL_MESS_BTN_COMPARE'); ?></a>
							</div>
						<? endif; */ ?>

						<div class="b-products-block__actions">

							<? if($arParams['DISPLAY_COMPARE']): ?>
								<a class="b-products-block__button b-products-block__compare g-ajax-data" href="<?=$arItem["ADD_TO_COMPARE_URL"]?>"><?=GetMessage('CT_BCS_TPL_MESS_BTN_COMPARE'); ?></a>
							<? endif; ?>

							<? if($arParams["USE_FAVORITE"] == "Y"): ?>
								<div class="b-products-block__button b-products-block__favorite g-ajax-data">
									<?/* --- Работа с Избранным ---НАЧАЛО- */?>
									<a 
										class="g-ajax-data js-favorite-action"
										href="<?= $arItem['ADD_TO_FAVORITE_URL']; ?>"
										rel="nofollow"
										title="<?= GetMessage('CATALOG_ADD_TO_FAVORITE'); ?>"
										data-add-href="<?= $arItem['ADD_TO_FAVORITE_URL']; ?>"
										data-add-title="<?= GetMessage('CATALOG_ADD_TO_FAVORITE_TITLE'); ?>"
										data-add-text="<?= GetMessage('CATALOG_ADD_TO_FAVORITE_TEXT'); ?>"
										data-remove-href="<?= $arItem['REMOVE_FROM_FAVORITE_URL']; ?>"
										data-remove-title="<?= GetMessage('CATALOG_REMOVE_FROM_FAVORITE_TITLE'); ?>"
										data-remove-text="<?= GetMessage('CATALOG_REMOVE_FROM_FAVORITE_TEXT'); ?>"
										<? if ($arParams['IS_FAVORITE_PAGE'] == "Y"): ?>data-favorite-page="true"<? endif; ?>
									><?=
											GetMessage("CATALOG_ADD_TO_FAVORITE");
									?></a>
									<?/* --- Работа с Избранным ---КОНЕЦ- */?>
								</div>
							<? endif; ?>

							<? if($arItem['CAN_BUY']): ?>
								<? /* <div  class="b-catalog-list_item_controls_basket" id="<?=$arItemIDs['BASKET_ACTIONS']; ?>"> 
									<a class="g-button g-ajax-data" href="<?=$arItem["ADD_TO_BASKET_URL"]?>" id="<?=$arItemIDs['BUY_LINK']; ?>" rel="nofollow">
										<? echo $arParams['ADD_TO_BASKET_ACTION'] == 'BUY' ? GetMessage('CT_BCS_TPL_MESS_BTN_BUY') : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');?>
									</a>
								</div>
								*/ ?>
								<a class="b-products-block__button b-products-block__basket g-button g-button--small g-ajax-data" href="<?=$arItem["ADD_TO_BASKET_URL"]?>" id="<?=$arItemIDs['BUY_LINK']; ?>" rel="nofollow">
									<? echo $arParams['ADD_TO_BASKET_ACTION'] == 'BUY' ? GetMessage('CT_BCS_TPL_MESS_BTN_BUY') : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');?>
								</a>
							<? else: ?>
								<div class="b-catalog-list_item_controls_notavailable" id="<?=$arItemIDs['NOT_AVAILABLE_MESS'];?>">
									<span class="bx_notavailable">
										<? echo GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');?>
									</span>
								</div>
								<? $showSubscribeBtn = false; ?>
								<? if($showSubscribeBtn): ?>
									<div class="b-products-block__subscribe">
										<a id="<?=$arItemIDs['SUBSCRIBE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)">
											<? echo GetMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE');?>
										</a>
									</div>
								<? endif; ?>
							<? endif; ?>

						</div>
							
					<? else: ?>

						<? if ($arParams['PRODUCT_DISPLAY_MODE'] == "Y"): ?>

							<? $canBuy = $arItem['JS_OFFERS'][$arItem['OFFERS_SELECTED']]['CAN_BUY']; ?>

							<div class="b-products-block__actions">

								<? /* if ($arParams['DISPLAY_COMPARE']): ?>
									<div class="b-catalog-list_item_controls_compare">
										<a id="<?=$arItemIDs['COMPARE_LINK']; ?>" href="javascript:void(0)"><?=GetMessage('CT_BCS_TPL_MESS_BTN_COMPARE'); ?></a>
									</div>
								<? endif; */ ?>

								<? if($arParams['DISPLAY_COMPARE']): ?>
									<a class="b-products-block__button b-products-block__compare g-ajax-data" href="<?=$arItem["ADD_TO_COMPARE_URL"]?>"><?=GetMessage('CT_BCS_TPL_MESS_BTN_COMPARE'); ?></a>
								<? endif; ?>

								<? if($arParams["USE_FAVORITE"] == "Y"): ?>
									<div class="b-products-block__button b-products-block__favorite g-ajax-data">
										<?/* --- Работа с Избранным ---НАЧАЛО- */?>
										<a 
											class="g-ajax-data js-favorite-action"
											href="<?= $arItem['ADD_TO_FAVORITE_URL']; ?>"
											rel="nofollow"
											title="<?= GetMessage('CATALOG_ADD_TO_FAVORITE'); ?>"
											data-add-href="<?= $arItem['ADD_TO_FAVORITE_URL']; ?>"
											data-add-title="<?= GetMessage('CATALOG_ADD_TO_FAVORITE_TITLE'); ?>"
											data-add-text="<?= GetMessage('CATALOG_ADD_TO_FAVORITE_TEXT'); ?>"
											data-remove-href="<?= $arItem['REMOVE_FROM_FAVORITE_URL']; ?>"
											data-remove-title="<?= GetMessage('CATALOG_REMOVE_FROM_FAVORITE_TITLE'); ?>"
											data-remove-text="<?= GetMessage('CATALOG_REMOVE_FROM_FAVORITE_TEXT'); ?>"
											<? if ($arParams['IS_FAVORITE_PAGE'] == "Y"): ?>data-favorite-page="true"<? endif; ?>
										><?=
												GetMessage("CATALOG_ADD_TO_FAVORITE");
										?></a>
										<?/* --- Работа с Избранным ---КОНЕЦ- */?>
									</div>
								<? endif; ?>

								<? /* <div id="<?=$arItemIDs['BASKET_ACTIONS']; ?>" class="b-catalog-list_item_controls_basket" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
									<a class="g-button g-ajax-data" href="<?=$arItem['OFFERS']["ADD_URL"]?>" id="<?=$arItemIDs['BUY_LINK']; ?>" rel="nofollow">
										<? echo $arParams['ADD_TO_BASKET_ACTION'] == 'BUY' ? GetMessage('CT_BCS_TPL_MESS_BTN_BUY') : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');?>
									</a>
								</div> */ ?>

								<a class="b-products-block__button b-products-block__basket g-button g-ajax-data" href="<?=$arItem['OFFERS']['ADD_TO_BASKET_URL']?>" id="<?=$arItemIDs['BUY_LINK']; ?>" rel="nofollow">
									<? echo $arParams['ADD_TO_BASKET_ACTION'] == 'BUY' ? GetMessage('CT_BCS_TPL_MESS_BTN_BUY') : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');?>
								</a>

								<div id="<?=$arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="b-catalog-list_item_controls_quantity" style="display: <? echo ($canBuy ? 'none' : ''); ?>;">
									<span class="bx_notavailable">
										<? echo GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');?>
									</span>
								</div>

							</div>

							<? unset($canBuy); ?>

						<? else: ?>

							<div class="b-catalog-list_item_controls no_touch">
								<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
									<? echo GetMessage('CT_BCS_TPL_MESS_BTN_DETAIL');?>
								</a>
							</div>

						<? endif; ?>
							
						<div class="b-products-block__controls touch">
							<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
								<? echo GetMessage('CT_BCS_TPL_MESS_BTN_DETAIL');?>
							</a>
						</div>
							
					<? endif; ?>

				</div>
			</div>
		</div>

	<? endforeach; ?>

</div>

<? if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"];?>
<? endif; ?>

<? include_once($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/offers-js-init.php'); ?>

