<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/* @global CMain $APPLICATION */
/* @var array $arParams */
/* @var array $arResult */
/* @var CatalogSectionComponent $component */
/* @var CBitrixComponentTemplate $this */
/* @var string $templateName */
/* @var string $componentPath */
/* @var string $templateFolder */

$this->setFrameMode(true);
?>
<?
include_once($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/offers-init.php');

// SEO alt и title для изображений
$strTitle = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME'];
$strAlt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
?>
<div class="b-catalog-detail bx_item_detail" id="<?=$arItemIDs['ID'];?>">

	<div class="b-catalog-detail_main">

		<div class="b-catalog-detail_left">

			<? if(is_array($arResult['MORE_PHOTO']) && count($arResult['MORE_PHOTO']) > 0): ?>

				<?
					reset($arResult['MORE_PHOTO']);
					$arFirstPhoto = current($arResult['MORE_PHOTO']);
				?>
		
				<? if(is_array($arFirstPhoto)): ?>
					<div class="b-catalog-detail_detail-pic" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
						<div id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>" data-src="<?=$arResult['DETAIL_PICTURE']['SRC'] ? $arResult['DETAIL_PICTURE']['SRC'] : $templateFolder.'/images/no_photo.png'?>">
							<img src="<?=$arFirstPhoto['SRC']; ?>" alt="<?=$strAlt; ?>" id="<?=$arItemIDs['PICT']; ?>">
						</div>
						<? if(is_array($arResult['MORE_PHOTO']) && count($arResult['MORE_PHOTO']) > 1): ?>
							<div class="b-catalog-detail_detail-pic_nav">
								<span class="b-catalog-detail_detail-pic_arrow arrow-prev disabled"></span>
								<span class="b-catalog-detail_detail-pic_arrow arrow-next"></span>
							</div>
						<? endif;?>
					</div>
				<? endif; ?>

				<div class="b-catalog-detail_more-pic<? if(count($arResult['MORE_PHOTO']) <= 1): ?> few-more-pick<? endif; ?>" id="<?=$arItemIDs['SLIDER_LIST']; ?>">

					<? if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])): ?>
						<div class="b-catalog-detail_slider bx_item_slider">
							<div class="b-catalog-detail_slider_container bx_slider_container" id="<?=$arItemIDs['SLIDER_CONT_OF_ID'];?>">
								<div class="b-catalog-detail_slider_inner-container bx_slider_inner_container">
									<ul>
										<? foreach($arResult['MORE_PHOTO'] as $arOnePhoto):?>
											<li data-value="<?=$arOnePhoto['ID'];?>" class="b-catalog-detail_more-pic_item">
												<img src="<?=$arOnePhoto['SRC']?>" alt="<?=$strAlt; ?>">
											</li>
											<? unset($arOnePhoto); ?>
										<? endforeach; ?>
									</ul>
									</div>
								<? if(count($arResult['MORE_PHOTO']) > 4): ?>
									<div class="bx_slide_left" id="<?=$arItemIDs['SLIDER_LEFT']?>"></div>
									<div class="bx_slide_right" id="<?=$arItemIDs['SLIDER_RIGHT']?>"></div>
								<? endif; ?>
							</div>
						</div>
					<? else: ?>
						<? 
							foreach ($arResult['OFFERS'] as $key => $arOneOffer):
							if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || $arOneOffer['MORE_PHOTO_COUNT'] <= 0) {
								continue;
							}
							$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
							?>
								<div class="b-catalog-detail_slider bx_item_slider">
									<div class="b-catalog-detail_slider_container bx_slider_container" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
										<div class="b-catalog-detail_slider_inner-container">
											<ul id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
												<? foreach ($arOneOffer['MORE_PHOTO_RESIZE'] as $arOnePhoto): ?>
													<li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" class="b-catalog-detail_more-pic_item">
														<img
															src="<?=$arOnePhoto['SRC']?>"
															alt="<?=$strAlt; ?>"
															title="<?=$strTitle; ?>"
														/>
													</li>
													<? unset($arOnePhoto); ?>
												<? endforeach ?>
											</ul>
										</div>
										<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" data-value="<? echo $arOneOffer['ID']; ?>" style="display: none;"></div>
										<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" data-value="<? echo $arOneOffer['ID']; ?>" style="display: none;"></div>
									</div>
								</div>
							<? unset($arOneOffer) ?>
						<? endforeach ?>
					<? endif ?>
				</div>
			<? else: ?>
				<div class="b-catalog-detail_holder-no_pic_wrap">
					<div class="b-catalog-detail_holder-no_pic"></div>
				</div>
			<? endif; ?>
		</div>

		<div class="b-catalog-detail_right">
			<? if($arResult['CATALOG_QUANTITY_TRACE'] == 'Y'): ?> 
				<div class="b-catalog-detail_availability">
					<? if($arResult['CATALOG_QUANTITY'] > 0): ?> 
						<?=GetMessage("CATALOG_AVAILABLE");?> <?=$arResult['CATALOG_QUANTITY']; ?> <?=$arResult['CATALOG_MEASURE_NAME']; ?>.)
					<? endif; ?>
				</div>
			<? endif; ?>
			<div class="b-mod-catalog-detail_supply">
				<? if ($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]): ?>
					<div class="b-catalog-detail_articul">
						<b class="b-catalog-detail_articul_label"><?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["NAME"]; ?>:</b><?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]; ?>
					</div>
				<? endif; ?> 

				<?
					foreach ($arResult['PRICES'] as $code => $arPrice) {
						if ($arPrice['CAN_ACCESS']) {
							if ($arPrice['DISCOUNT_VALUE'] < $arPrice['VALUE']) {
								$curPrice = $arPrice['PRINT_DISCOUNT_VALUE'];
								$oldPrice = $arPrice['PRINT_VALUE'];
							} else {
								$curPrice = $arPrice['PRINT_VALUE'];
								$oldPrice = false;
							}
						}
					}
				?>
				
					<div class="b-catalog-detail_price">
						<?
							$minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);
							$boolDiscountShow = (0 < $minPrice['DISCOUNT_DIFF']);
							if ($arParams['SHOW_OLD_PRICE'] == 'Y'):
						?>
							<div class="b-catalog-detail_price_old" id="<?=$arItemIDs['OLD_PRICE']; ?>" style="display: <? echo($boolDiscountShow ? '' : 'none'); ?>">
								<? $frame = $this->createFrame()->begin(""); ?> 
									<? echo($boolDiscountShow ? $minPrice['PRINT_VALUE'] : ''); ?>
								<? $frame->end(); ?>
							</div>
						<? endif; ?>
							
							<div class="b-catalog-detail_price_current" id="<?=$arItemIDs['PRICE']; ?>">
								<? $frame = $this->createFrame()->begin(""); ?> 
									<?=$minPrice['PRINT_DISCOUNT_VALUE'];?>
								<? $frame->end(); ?>
							</div>
						
						<? if ($arParams['SHOW_OLD_PRICE'] == 'Y'): ?>
							<div class="b-catalog-detail_price_economy" id="<?=$arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo($boolDiscountShow ? '' : 'none'); ?>">
								<? $frame = $this->createFrame()->begin(""); ?> 
									<? echo($boolDiscountShow ? GetMessage('CT_BCE_CATALOG_ECONOMY_INFO', array('#ECONOMY#' => $minPrice['PRINT_DISCOUNT_DIFF'])) : ''); ?>
								<? $frame->end(); ?>
							</div>
						<? endif; ?>
					</div>

				<? /* Торговые предложения */ ?>
				<?
					if ($haveOffers && !empty($arResult['OFFERS_PROP'])):
					$arSkuProps = array();
				?>
					<div class="b-catalog-detail_offers" id="<? echo $arItemIDs['PROP_DIV'];?>">
					<?
						foreach ($arResult['SKU_PROPS'] as &$arProp) {
							
							if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
								continue;

							$arSkuProps[] = array(
								'ID' => $arProp['ID'],
								'SHOW_MODE' => $arProp['SHOW_MODE'],
								'VALUES' => $arProp['VALUES'],
								'VALUES_COUNT' => $arProp['VALUES_COUNT']
							);
							?>
							<div class="b-catalog-detail_offers_container" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
								<div class="b-catalog-detail_offers_title"><?=htmlspecialcharsEx($arProp['NAME'])?></div>
									<ul class="b-catalog-detail_offers_list" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list">
										<? foreach ($arProp['VALUES'] as $arOneValue): ?>

										<?
											if($arOneValue["ID"] <= 0)
												continue;

											$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);

											if ($arProp['SHOW_MODE'] === 'PICT'): ?>
												
												<li class="b-catalog-detail_offers_item b-catalog-detail_offers_item-color" data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>" data-onevalue="<? echo $arOneValue['ID']; ?>">
													<div class="b-catalog-detail_offers_item-color_block">
														<div class="b-catalog-detail_offers_item_color" title="<?=$arOneValue['NAME']?>"
															style="background-image: url('<?=$arOneValue['PICT']['SRC']?>');">
														</div>
													</div>
												</li>

											<? else: ?>

												<li class="b-catalog-detail_offers_item b-catalog-detail_offers_item-text" data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>" data-onevalue="<? echo $arOneValue['ID']; ?>">
													<div class="b-catalog-detail_offers_item-text_block">
														<div class="b-catalog-detail_offers_item_text"><?=$arOneValue['NAME']?></div>
													</div>
												</li>

											<? endif; ?>

										<? endforeach; ?>
									</ul>
							</div>
							<?
						}
						unset($arProp);
					?>
					</div>
					
				<? endif ?>
			<? // ----------- ?>
			

				<? /* Работа с покупкой, кол-вом, сравнением */ ?>
					<div class="b-catalog-detail_item-info">
						<?
						if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
							$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
						}
						else {
							$canBuy = $arResult['CAN_BUY'];
						}

						$buyBtnMessage = ($arParams['MESS_BTN_BUY'] != '' ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
						$addToBasketBtnMessage = ($arParams['MESS_BTN_ADD_TO_BASKET'] != '' ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCE_CATALOG_ADD'));
						$notAvailableMessage = ($arParams['MESS_NOT_AVAILABLE'] != '' ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));

						$showSubscribeBtn = false;
						$compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCE_CATALOG_COMPARE'));

						?>
							

								<div class="b-catalog-detail_item-info_qty">
									<div class="item_buttons_counter_block">
										<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>"><span>-</span></a>
										<input 
											id="<? echo $arItemIDs['QUANTITY']; ?>"
											type="text"
											class="tac transparent_input"
											value="<? echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) ? 1 : $arResult['CATALOG_MEASURE_RATIO'] ); ?>">
										<a
											href="javascript:void(0)"
											class="bx_bt_button_type_2 bx_small bx_fwb"
											id="<? echo $arItemIDs['QUANTITY_UP']; ?>"><span>+</span>
										</a>
									</div>
								</div>

							<div class="b-catalog-detail_item-info_actions item_buttons vam">
								<? if ($canBuy && $arResult["CATALOG_QUANTITY"] > 0): ?>
									<span 
										class="item_buttons_counter_block"
										id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>">
										
										<a class="g-button g-add-cart g-ajax-data" href="<?=$arResult["ADD_TO_BASKET_URL"]?>" rel="nofollow" id="<? echo $arItemIDs['BUY_LINK']; ?>">
											<?=$addToBasketBtnMessage?>
										</a>
									</span>
								<? elseif ($canBuy && $arResult["CATALOG_QUANTITY"] < 1): ?>
									<div
										id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>"
										class="bx_notavailable can-buy">

										<span>
											<?=$notAvailableMessage;?>
										</span>
									</div>
									<span 
										class="item_buttons_counter_block"
										id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>">
										
										<a class="g-button g-add-cart g-ajax-data" href="<?=$arResult["ADD_TO_BASKET_URL"]?>" rel="nofollow" id="<? echo $arItemIDs['BUY_LINK']; ?>">
											<?=GetMessage('CT_BCE_CATALOG_ORDERING');?>
										</a>
									</span>
								<? else: ?>
									<span
										id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>"
										class="bx_notavailable">

										<a class="g-button g-pre-order g-ajax-data" href="<?=$arResult["ADD_TO_BASKET_URL"]?>" rel="nofollow" id="<? echo $arItemIDs['BUY_LINK']; ?>">
											<?=$notAvailableMessage;?>
										</a>
									</span>
								<? endif; ?>

								<?/* if ($arParams['DISPLAY_COMPARE']): ?>
									<a href="javascript:void(0);" class="bx_big bx_bt_button_type_2 bx_cart" id="<? echo $arItemIDs['COMPARE_LINK']; ?>"><? echo $compareBtnMessage; ?></a>
								<? endif; */ ?>

								<? if ($arParams['DISPLAY_COMPARE']  == "Y"): ?>
									<a class="g-ajax-data" href="<?=$arResult["ADD_TO_COMPARE_URL"]?>"><? echo $compareBtnMessage; ?></a>
								<? endif; ?>

								<? if ($arParams['USE_FAVORITE'] == "Y"): ?>
									<a class="g-ajax-data favorite-btn" href="<?=$arResult["ADD_TO_FAVORITE_URL"]?>"><? echo GetMessage('CT_BCE_CATALOG_FAVORITE'); ?></a>
								<? endif; ?>

							</div>
						<? unset($showAddBtn, $showBuyBtn); ?>
					</div>
				<?
				/* -------------------- */
				?>
			</div>
			<? if ($arResult['DETAIL_TEXT']): ?>
				<div class="b-catalog-detail_detail-text g-pattern-filled">
					<? echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>'; ?>
				</div>
			<? endif; ?>


			
			
		</div>

	</div>

    <? if ($arResult['PREVIEW_TEXT']): ?>
        <div class="b-catalog-detail_preview-text">
            <? echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>'; ?>
        </div>
    <? endif; ?>
	<div class="b-catalog-detail_tabs-group">
	
		<div class="b-catalog-detail_tabs-container" id="<?=$arItemIDs['TABS_ID']?>">
			<ul class="b-catalog-detail_tabs-list">
				<? if ((is_array($arResult['DISPLAY_PROPERTIES']['ELECTRIC_PROPS']) && count($arResult['DISPLAY_PROPERTIES']['ELECTRIC_PROPS']) > 0) || (is_array($arResult['DISPLAY_PROPERTIES']['MECHANICAL_PROPS']) && count($arResult['DISPLAY_PROPERTIES']['MECHANICAL_PROPS']) > 0)): ?>
					<li class="b-catalog-detail_tab" data-entity="tab" data-value="properties">
						<a href="javascript:void(0);" class="b-catalog-detail_tab-link">
							<span>Технические характеристики</span>
						</a>
					</li>
				<? endif; ?>

				
				<? if (is_array($arResult['DISPLAY_PROPERTIES']['ENVIRONMENT_CONDITIONS_PROPS']) && count($arResult['DISPLAY_PROPERTIES']['ENVIRONMENT_CONDITIONS_PROPS']) > 0): ?>
					<li class="b-catalog-detail_tab" data-entity="tab" data-value="environment-conditions">
						<a href="javascript:void(0);" class="b-catalog-detail_tab-link">
							<span>Условия окружающей среды</span>
						</a>
					</li>
				<? endif; ?>
				<?
					//dump($arResult);
				?>
				<? if ($arResult["PARENT_SECTION"] == '60'): ?>
					<li class="b-catalog-detail_tab" data-entity="tab" data-value="protection">
						<a href="javascript:void(0);" class="b-catalog-detail_tab-link">
							<span>Защита</span>
						</a>
					</li>
				<? endif; ?>
				<? if (is_array($arResult['DISPLAY_PROPERTIES']['FILES']['VALUE']) && count($arResult['DISPLAY_PROPERTIES']['FILES']['VALUE']) > 0): ?>
					<li class="b-catalog-detail_tab" data-entity="tab" data-value="guides">
						<a href="javascript:void(0);" class="b-catalog-detail_tab-link">
							<span>Руководства</span>
						</a>
					</li>
				<? endif; ?>

			</ul>
		</div>

		<div class="b-catalog-detail_tabs" id="<?=$arItemIDs['TAB_CONTAINERS_ID']?>">
			<div class="b-catalog-detail_tab-content" data-entity="tab-container" data-value="properties">
				<? if (is_array($arResult['DISPLAY_PROPERTIES']['ELECTRIC_PROPS']) && count($arResult['DISPLAY_PROPERTIES']['ELECTRIC_PROPS']) > 0): ?>
					<div class="b-catalog-detail_properties properties-electric">
						<div class="b-catalog-detail_properties_title">Электрические параметры</div>
						<? foreach ($arResult['DISPLAY_PROPERTIES']['ELECTRIC_PROPS'] as $id => $arProperty): ?>
							<div class="b-catalog-detail_properties_item">
								<span class="b-catalog-detail_properties_item_title"><? echo $arProperty['NAME']; ?>:</span>
								<span class="b-catalog-detail_properties_item_value">
									<? if(is_array($arProperty["DISPLAY_VALUE"])): ?>
										<?=implode(" / ", $arProperty["DISPLAY_VALUE"]);?>
									<? else: ?>
										<?=$arProperty["DISPLAY_VALUE"]; ?>
									<? endif; ?>
								</span>
							</div>
						<? endforeach; ?>
						<? unset($arProperty);?>
					</div>
				<? endif; ?>
				<? if (is_array($arResult['DISPLAY_PROPERTIES']['MECHANICAL_PROPS']) && count($arResult['DISPLAY_PROPERTIES']['MECHANICAL_PROPS']) > 0): ?>
					<div class="b-catalog-detail_properties properties-mechanical">
						<div class="b-catalog-detail_properties_title">Механические параметры</div>
						<? foreach ($arResult['DISPLAY_PROPERTIES']['MECHANICAL_PROPS'] as $id => $arProperty): ?>
							<div class="b-catalog-detail_properties_item">
								<span class="b-catalog-detail_properties_item_title"><? echo $arProperty['NAME']; ?>:</span>
								<span class="b-catalog-detail_properties_item_value">
									<? if(is_array($arProperty["DISPLAY_VALUE"])): ?>
										<?=implode(" / ", $arProperty["DISPLAY_VALUE"]);?>
									<? else: ?>
										<?=$arProperty["DISPLAY_VALUE"]; ?>
									<? endif; ?>
								</span>
							</div>
						<? endforeach; ?>
						<? unset($arProperty);?>
					</div>
				<? endif; ?>
				<? if ($arResult['SHOW_OFFERS_PROPS']): ?>
					<div id="<?=$arItemIDs['DISPLAY_PROP_DIV'];?>" class="b-catalog-detail_properties_item" style="display: none;"></div>
				<? endif ?>

			</div>
			<div class="b-catalog-detail_tab-content" data-entity="tab-container" data-value="environment-conditions">
				<? if (is_array($arResult['DISPLAY_PROPERTIES']['ENVIRONMENT_CONDITIONS_PROPS']) && count($arResult['DISPLAY_PROPERTIES']['ENVIRONMENT_CONDITIONS_PROPS']) > 0): ?>
					<div class="b-catalog-detail_properties properties-environment-conditions">
						<? foreach ($arResult['DISPLAY_PROPERTIES']['ENVIRONMENT_CONDITIONS_PROPS'] as $id => $arProperty): ?>
							<div class="b-catalog-detail_properties_item">
								<span class="b-catalog-detail_properties_item_title"><? echo $arProperty['NAME']; ?>:</span>
								<span class="b-catalog-detail_properties_item_value">
									<? if(is_array($arProperty["DISPLAY_VALUE"])): ?>
										<?=implode(" / ", $arProperty["DISPLAY_VALUE"]);?>
									<? else: ?>
										<?=$arProperty["DISPLAY_VALUE"]; ?>
									<? endif; ?>
								</span>
							</div>
						<? endforeach; ?>
						<? unset($arProperty);?>
					</div>
				<? endif; ?>
			</div>
			
			<? if ($arResult["PARENT_SECTION"] == '60'): ?>
				<div class="b-catalog-detail_tab-content" data-entity="tab-container" data-value="protection">
					<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/detail/protection-properties.php",Array(),Array("MODE"=>"html")); ?>
				</div>
			<? endif; ?>

			<div class="b-catalog-detail_tab-content" data-entity="tab-container" data-value="guides">
				<? if (is_array($arResult['DISPLAY_PROPERTIES']['FILES']['VALUE']) && count($arResult['DISPLAY_PROPERTIES']['FILES']['VALUE']) > 0): ?>
					<? if (count($arResult['DISPLAY_PROPERTIES']['FILES']['VALUE']) == 1): ?>
						<span class="b-catalog-detail_tab-content_files_name"><?=$arResult['DISPLAY_PROPERTIES']['FILES']['FILE_VALUE']['ORIGINAL_NAME']; ?></span>
						<a class="b-catalog-detail_tab-content_files_link g-half-link" download href="<?=$arResult['DISPLAY_PROPERTIES']['FILES']['FILE_VALUE']['SRC']; ?>"><?=GetMessage("FILE_DOWNLOAD")?></a>
						<span class="b-catalog-detail_tab-content_files_size">(<?=number_format($arResult['DISPLAY_PROPERTIES']['FILES']['FILE_VALUE']['FILE_SIZE'] / 1024, 1, ','," "); ?> kb)</span>
					<? elseif (count($arResult['DISPLAY_PROPERTIES']['FILES']['VALUE']) > 1): ?>
						<? foreach($arResult['DISPLAY_PROPERTIES']['FILES']['FILE_VALUE'] as $key => $arFile): ?>
							<div class="b-catalog-detail_tab-content_file">
								<span class="b-catalog-detail_tab-content_files_name"><?=$arFile['ORIGINAL_NAME']; ?></span>
								<a class="b-catalog-detail_tab-content_files_link g-half-link" download href="<?=$arFile['SRC']; ?>"><?=GetMessage("FILE_DOWNLOAD")?></a>
								<span class="b-catalog-detail_tab-content_files_size">(<?=number_format($arFile['FILE_SIZE'] / 1024, 1, ',',' '); ?> kb)</span>
							</div>
						<? endforeach; ?>
					<? endif; ?>
				<? endif; ?>
			</div>


			<?
			if ($arParams['USE_COMMENTS'] === 'Y')
			{
				?>
				<div class="b-catalog-detail_tab-content" data-entity="tab-container" data-value="comments" style="display: none;">
					<?
					$APPLICATION->IncludeComponent(
						'bitrix:catalog.comments',
						'',
						array(
							'ELEMENT_ID' => $arResult['ID'],
							'ELEMENT_CODE' => '',
							'IBLOCK_ID' => $arParams['IBLOCK_ID'],
							'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
							'URL_TO_COMMENT' => '',
							'WIDTH' => '',
							'COMMENTS_COUNT' => '5',
							'BLOG_USE' => $arParams['BLOG_USE'],
							'FB_USE' => $arParams['FB_USE'],
							'FB_APP_ID' => $arParams['FB_APP_ID'],
							'VK_USE' => $arParams['VK_USE'],
							'VK_API_ID' => $arParams['VK_API_ID'],
							'CACHE_TYPE' => $arParams['CACHE_TYPE'],
							'CACHE_TIME' => $arParams['CACHE_TIME'],
							'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
							'BLOG_TITLE' => '',
							'BLOG_URL' => $arParams['BLOG_URL'],
							'PATH_TO_SMILE' => '',
							'EMAIL_NOTIFY' => $arParams['BLOG_EMAIL_NOTIFY'],
							'AJAX_POST' => 'Y',
							'SHOW_SPAM' => 'Y',
							'SHOW_RATING' => 'N',
							'FB_TITLE' => '',
							'FB_USER_ADMIN_ID' => '',
							'FB_COLORSCHEME' => 'light',
							'FB_ORDER_BY' => 'reverse_time',
							'VK_TITLE' => '',
							// 'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],

							// "USER_CONSENT" =>$arParams["USER_CONSENT"],
							// "USER_CONSENT_ID" =>$arParams["USER_CONSENT_ID"],
							// "USER_CONSENT_IS_CHECKED" =>$arParams["USER_CONSENT_IS_CHECKED"],
							// "USER_CONSENT_IS_LOADED" =>$arParams["USER_CONSENT_IS_LOADED"],
						),
						$component,
						array('HIDE_ICONS' => 'Y')
					);
					?>
				</div>
				<?
			}
			?>
		</div>

	</div>

</div>

<? include_once($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/offers-js-init.php'); ?>