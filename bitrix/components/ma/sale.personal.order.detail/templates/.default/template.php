<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

if ($arParams['GUEST_MODE'] !== 'Y')
{
	Asset::getInstance()->addJs("/bitrix/components/ma/sale.order.payment.change/templates/.default/script.js");
	Asset::getInstance()->addCss("/bitrix/components/ma/sale.order.payment.change/templates/.default/style.css");
}
CJSCore::Init(array('clipboard', 'fx'));

$APPLICATION->SetTitle(Loc::getMessage('SPOD_LIST_MY_ORDER', array('#ACCOUNT_NUMBER#' => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),'#DATE_ORDER_CREATE#' => $arResult["DATE_INSERT_FORMATED"])));
?>

<? if (!empty($arResult['ERRORS']['FATAL'])): ?>

	<?
		foreach ($arResult['ERRORS']['FATAL'] as $error) {
			ShowError($error);
		}

		$component = $this->__component;
		if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
		{
			$APPLICATION->AuthForm('', false, false, 'N', false);
		}
	?>

<? else: ?>

	<?
	if (!empty($arResult['ERRORS']['NONFATAL'])) {
		foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
			ShowError($error);
		}
	}
	?>
	<div class="b-order-detail">

		<div class="b-order-detail__general">
			<div class="row">

				<div class="col-md-4 col-sm-12 col-xs-12">

					<div class="b-order-detail__section">

						<div class="b-order-detail__section-title">
							<h2><? echo Loc::getMessage('SPOD_LIST_ORDER_INFO'); ?>:</h2>
						</div>

						<div class="b-order-detail__section-content">
							<div class="b-order-detail__about-name">
								<? //dump($arResult["USER"]); Нет имени, почему? ?>
								<? $userName = $arResult["USER"]["NAME"] ." ". $arResult["USER"]["SECOND_NAME"] ." ". $arResult["USER"]["LAST_NAME"]; ?>
								<? if (empty($userName)): ?>
									<strong><? echo Loc::getMessage('SPOD_LIST_FIO').':'; ?></strong>
									<? echo htmlspecialcharsbx($userName); ?>
								<? elseif (empty($arResult['FIO'])): ?>
									<strong><? echo Loc::getMessage('SPOD_LIST_FIO').':'; ?></strong>
									<? echo htmlspecialcharsbx($arResult['FIO']); ?>
								<? else: ?>
									<strong><? echo Loc::getMessage('SPOD_LOGIN').':'; ?></strong>
									<? echo htmlspecialcharsbx($arResult["USER"]['LOGIN']); ?>
								<? endif; ?>
							</div>

							<div class="b-order-detail__about-status">
								<strong><? echo Loc::getMessage('SPOD_LIST_CURRENT_STATUS', array('#DATE_ORDER_CREATE#' => $arResult["DATE_INSERT_FORMATED"])); ?></strong>
								<?
								if ($arResult['CANCELED'] !== 'Y') {
									echo htmlspecialcharsbx($arResult["STATUS"]["NAME"]);
								}
								else {
									echo Loc::getMessage('SPOD_ORDER_CANCELED');
								}
								?>
							</div>

							<div class="b-order-detail__about-sum">
								<? echo Loc::getMessage('SPOD_ORDER_PRICE');?>:
								<strong><?= $arResult["PRICE_FORMATED"]?></strong>
							</div>
							<div class="">
								<a class="sale-order-detail-about-order-inner-container-name-read-less">
									<?= Loc::getMessage('SPOD_LIST_LESS') ?>
								</a>
								<a class="sale-order-detail-about-order-inner-container-name-read-more">
									<?= Loc::getMessage('SPOD_LIST_MORE') ?>
								</a>
							</div>
							
							<div class="b-order-detail__about-details sale-order-detail-about-order-inner-container-details">
								<h4 class="b-order-detail__about-details-title">
									<?= Loc::getMessage('SPOD_USER_INFORMATION') ?>
								</h4>
								<ul class="b-order-detail__about-details-list">
									<? if (strlen($arResult["USER"]["LOGIN"]) && !in_array("LOGIN", $arParams['HIDE_USER_INFO'])): ?>
										<li class="b-order-detail__about-details-item">
											<div class="b-order-detail__about-details-prop">
												<?= Loc::getMessage('SPOD_LOGIN')?>:
											</div>
											<?= htmlspecialcharsbx($arResult["USER"]["LOGIN"]) ?>
										</li>
									<? endif; ?>
									<? if (strlen($arResult["USER"]["EMAIL"]) && !in_array("EMAIL", $arParams['HIDE_USER_INFO'])): ?>
										<li class="b-order-detail__about-details-item">
											<div class="b-order-detail__about-details-prop">
												<?= Loc::getMessage('SPOD_EMAIL')?>:
											</div>
											<a href="mailto:<?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?>">
												<span><?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?></span>
											</a>
										</li>
									<? endif; ?>
									<? if (strlen($arResult["USER"]["PERSON_TYPE_NAME"]) && !in_array("PERSON_TYPE_NAME", $arParams['HIDE_USER_INFO'])):?>
										<li class="b-order-detail__about-details-item">
											<div class="b-order-detail__about-details-prop">
												<?= Loc::getMessage('SPOD_PERSON_TYPE_NAME') ?>:
											</div>
											<?= htmlspecialcharsbx($arResult["USER"]["PERSON_TYPE_NAME"]) ?>
										</li>
									<? endif; ?>
									<? if (isset($arResult["ORDER_PROPS"])): ?>
										<?
										foreach ($arResult["ORDER_PROPS"] as $property)
										{
											?>
											<li class="b-order-detail__about-details-item">
												<div class="b-order-detail__about-details-prop">
													<?= htmlspecialcharsbx($property['NAME']) ?>:
												</div>
												<?
													if ($property["TYPE"] == "Y/N") {
														echo Loc::getMessage('SPOD_' . ($property["VALUE"] == "Y" ? 'YES' : 'NO'));
													}
													else {
														if ($property['MULTIPLE'] == 'Y'
															&& $property['TYPE'] !== 'FILE'
															&& $property['TYPE'] !== 'LOCATION')
														{
															$propertyList = unserialize($property["VALUE"]);
															foreach ($propertyList as $propertyElement)
															{
																echo $propertyElement . '</br>';
															}
														}
														elseif ($property['TYPE'] == 'FILE')
														{
															echo $property["VALUE"];
														}
														else
														{
															echo htmlspecialcharsbx($property["VALUE"]);
														}
													}
												?>
											</li>
											<?
										}
										?>
									<? endif; ?>
								</ul>
								<? if (strlen($arResult["USER_DESCRIPTION"])):?>
									<h4 class="b-order-detail__about-details-title">
										<?= Loc::getMessage('SPOD_ORDER_DESC') ?>
									</h4>
									<ul class="b-order-detail__about-details-list">
										<li class="b-order-detail__about-details-item">
											<?=nl2br(htmlspecialcharsbx($arResult["USER_DESCRIPTION"]))?>
										</li>
									</ul>
								<? endif; ?>
							</div>

							<? if ($arParams['GUEST_MODE'] !== 'Y'): ?>
								<div class="b-order-detail__buttons">
									<a href="<?=$arResult["URL_TO_COPY"]?>" class="b-button g-button">
										<?= Loc::getMessage('SPOD_ORDER_REPEAT') ?>
									</a>
									<? if ($arResult["CAN_CANCEL"] === "Y"): ?>
										<a class="cancel" href="<?=$arResult["URL_TO_CANCEL"]?>">
											<span><?= Loc::getMessage('SPOD_ORDER_CANCEL') ?></span>
										</a>
									<? endif; ?>
								</div>
							<? endif; ?>
						</div>

					</div>

				</div>

				<div class="col-md-4 col-sm-12 col-xs-12">

					<div class="b-order-detail__section">

						<div class="b-order-detail__section-title">
							<h2><? echo Loc::getMessage('SPOD_ORDER_PAYMENT'); ?>:</h2>
						</div>

						<div class="b-order-detail__section-content">

							<div class="b-order-detail__payment">

								<div class="b-order-detail__payment-title">
									<?= Loc::getMessage('SPOD_SUB_ORDER_TITLE', array(
										"#ACCOUNT_NUMBER#"=> htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
										"#DATE_ORDER_CREATE#"=> $arResult["DATE_INSERT_FORMATED"]
									))?>
									<?
									if ($arResult['CANCELED'] !== 'Y') {
										echo htmlspecialcharsbx($arResult["STATUS"]["NAME"]);
									}
									else {
										echo Loc::getMessage('SPOD_ORDER_CANCELED');
									}
									?>
								</div>
								<div class="b-order-detail__payment-price">
									<?=Loc::getMessage('SPOD_ORDER_PRICE_FULL')?>:
									<strong><?=$arResult["PRICE_FORMATED"]?></strong>
								</div>

							</div>


							<div class="b-order-detail__payment-list sale-order-detail-payment-options-methods">

								<? foreach ($arResult['PAYMENT'] as $payment): ?>

									<div class="b-order-detail__payment-item">

										<div class="sale-order-detail-payment-options-methods-info">

											<div class="b-order-detail__payment-item-title">
												<?
													$paymentData[$payment['ACCOUNT_NUMBER']] = array(
														"payment" => $payment['ACCOUNT_NUMBER'],
														"order" => $arResult['ACCOUNT_NUMBER'],
														"allow_inner" => $arParams['ALLOW_INNER'],
														"only_inner_full" => $arParams['ONLY_INNER_FULL'],
														"refresh_prices" => $arParams['REFRESH_PRICES'],
														"path_to_payment" => $arParams['PATH_TO_PAYMENT']
													);
													$paymentSubTitle = Loc::getMessage('SPOD_TPL_BILL')." ".Loc::getMessage('SPOD_NUM_SIGN').$payment['ACCOUNT_NUMBER'];
													if(isset($payment['DATE_BILL']))
													{
														$paymentSubTitle .= " ".Loc::getMessage('SPOD_FROM')." ".$payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
													}
													$paymentSubTitle .=",";
													echo htmlspecialcharsbx($paymentSubTitle);
												?>
												<?=$payment['PAY_SYSTEM_NAME']?>
											</div>
											<div class="b-order-detail__payment-item-price">
												<?= Loc::getMessage('SPOD_ORDER_PRICE_BILL')?>:
												<strong><?=$payment['PRICE_FORMATED']?></strong>
											</div>
											
											<div class="b-order-detail__payment-item-status">
												<? if ($payment['PAID'] === 'Y'): ?>
													<span class="b-order-detail__payment-item-status b-order-detail__payment-item-status--success">
														<?=Loc::getMessage('SPOD_PAYMENT_PAID')?>
													</span>
												<? elseif ($arResult['IS_ALLOW_PAY'] == 'N'): ?>
													<span class="b-order-detail__status status--restricted">
														<?=Loc::getMessage('SPOD_TPL_RESTRICTED_PAID')?>
													</span>
												<? else: ?>
													<span class="b-order-detail__status status--alert">
														<?=Loc::getMessage('SPOD_PAYMENT_UNPAID')?>
													</span>
												<? endif; ?>
											</div>

											<? if (!empty($payment['CHECK_DATA'])) : ?>
											<?
												$listCheckLinks = "";
												foreach ($payment['CHECK_DATA'] as $checkInfo)
												{
													$title = Loc::getMessage('SPOD_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID']))." - ". htmlspecialcharsbx($checkInfo['TYPE_NAME']);
													if (strlen($checkInfo['LINK']) > 0)
													{
														$link = $checkInfo['LINK'];
														$listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
													}
												}
												if (strlen($listCheckLinks) > 0)
												{
													?>
													<div class="sale-order-detail-payment-options-methods-info-total-check">
														<div class="sale-order-detail-sum-check-left"><?= Loc::getMessage('SPOD_CHECK_TITLE')?>:</div>
														<div class="sale-order-detail-sum-check-left">
															<?=$listCheckLinks?>
														</div>
													</div>
													<?
												}
											?>
											<? endif; ?>
											<? if (
												$payment['PAID'] !== 'Y'
												&& $arResult['CANCELED'] !== 'Y'
												&& $arParams['GUEST_MODE'] !== 'Y'
												&& $arResult['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'
											)
											{
												?>
												<div class="b-order-detail__payment-item-change">
													<a class="sale-order-detail-payment-options-methods-info-change-link" href="#" id="<?=$payment['ACCOUNT_NUMBER']?>"><?=Loc::getMessage('SPOD_CHANGE_PAYMENT_TYPE')?></a>
												</div>
												<?
											}
											?>
											<?
											if ($arResult['IS_ALLOW_PAY'] === 'N' && $payment['PAID'] !== 'Y')
											{
												?>
												<div class="sale-order-detail-status-restricted-message-block">
													<span class="sale-order-detail-status-restricted-message"><?=Loc::getMessage('SOPD_TPL_RESTRICTED_PAID_MESSAGE')?></span>
												</div>
												<?
											}
											?>
										</div>
										<?
										if ($payment['PAY_SYSTEM']["IS_CASH"] !== "Y")
										{
											?>
											<div class="b-order-detail__buttons sale-order-detail-payment-options-methods-button-container">
												<?
												if ($payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] === 'Y' && $arResult["IS_ALLOW_PAY"] !== "N")
												{
													?>
													<a class="btn-theme sale-order-detail-payment-options-methods-button-element-new-window"
													   target="_blank"
													   href="<?=htmlspecialcharsbx($payment['PAY_SYSTEM']['PSA_ACTION_FILE'])?>">
														<?= Loc::getMessage('SPOD_ORDER_PAY') ?>
													</a>
													<?
												}
												else
												{
													if ($payment["PAID"] === "Y" || $arResult["CANCELED"] === "Y" || $arResult["IS_ALLOW_PAY"] === "N")
													{
														?>
														<a class="btn-theme sale-order-detail-payment-options-methods-button-element inactive-button"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>
														<?
													}
													else
													{
														?>
														<a class="b-button g-button sale-order-detail-payment-options-methods-button-element active-button"><?= Loc::getMessage('SPOD_ORDER_PAY') ?></a>
														<?
													}
												}
												?>
											</div>
											<?
										}
										?>
										<div class="sale-order-detail-payment-inner-row-template">
											<a class="sale-order-list-cancel-payment" href="#">
												<?=Loc::getMessage('SPOD_CANCEL_PAYMENT')?>
											</a>
										</div>
										<?
										if ($payment["PAID"] !== "Y"
											&& $payment['PAY_SYSTEM']["IS_CASH"] !== "Y"
											&& $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y'
											&& $arResult['CANCELED'] !== 'Y'
											&& $arResult["IS_ALLOW_PAY"] !== "N")
										{
											?>
											<div class="row sale-order-detail-payment-options-methods-template">
												<span class="sale-paysystem-close active-button">
													<span class="sale-paysystem-close-item sale-order-payment-cancel"></span><!--sale-paysystem-close-item-->
												</span><!--sale-paysystem-close-->
												<?=$payment['BUFFERED_OUTPUT']?>
													<!--<a class="sale-order-payment-cancel">--><?//= Loc::getMessage('SPOD_CANCEL_PAY') ?><!--</a>-->
											</div>
											<?
										}
										?>

									</div>
								<? endforeach; ?>
							</div>
						</div>

					</div>

				</div>

				<div class="col-md-4 col-sm-12 col-xs-12">

						<?
						if (count($arResult['SHIPMENT']))
						{
							?>
							<div class="b-order-detail__section">
								<div class="b-order-detail__section-title">
									<h2><? echo Loc::getMessage('SPOD_ORDER_SHIPMENT');?>:</h2>
								</div>
								<div class="b-order-detail__section-content">
									<? foreach ($arResult['SHIPMENT'] as $shipment) :?>
										<div class="b-order-detail__shipment sale-order-detail-payment-options-shipment">

											<div class="b-order-detail__shipment-title">
												<?
													if (!strlen($shipment['PRICE_DELIVERY_FORMATED'])) {
														$shipment['PRICE_DELIVERY_FORMATED'] = 0;
													}
													$shipmentRow = Loc::getMessage('SPOD_SUB_ORDER_SHIPMENT')." ".Loc::getMessage('SPOD_NUM_SIGN').$shipment["ACCOUNT_NUMBER"];
													if ($shipment["DATE_DEDUCTED"])	{
														$shipmentRow .= " ".Loc::getMessage('SPOD_FROM')." ".$shipment["DATE_DEDUCTED"]->format($arParams['ACTIVE_DATE_FORMAT']);
													}
													$shipmentRow = htmlspecialcharsbx($shipmentRow);
													$shipmentRow .= ", ".Loc::getMessage('SPOD_SUB_PRICE_DELIVERY', array(
														'#PRICE_DELIVERY#' => $shipment['PRICE_DELIVERY_FORMATED']
													));
													echo $shipmentRow;
												?>
											</div>
											<? if (strlen($shipment["DELIVERY_NAME"])): ?>
												<div class="b-order-detail__shipment-prop">
													<?= Loc::getMessage('SPOD_ORDER_DELIVERY')?>: <?= htmlspecialcharsbx($shipment["DELIVERY_NAME"])?>
												</div>
											<? endif; ?>

											<div class="b-order-detail__shipment-prop">
												<?= Loc::getMessage('SPOD_ORDER_SHIPMENT_STATUS')?>:
												<?= htmlspecialcharsbx($shipment['STATUS_NAME'])?>
											</div>

											<? if (strlen($shipment['TRACKING_NUMBER'])): ?>
												<div class="b-order-detail__shipment-prop">
													<span class="sale-order-list-shipment-id-name"><?= Loc::getMessage('SPOD_ORDER_TRACKING_NUMBER')?>:</span>
													<span class="sale-order-detail-shipment-id"><?= htmlspecialcharsbx($shipment['TRACKING_NUMBER'])?></span>
													<span class="sale-order-detail-shipment-id-icon"></span>
												</div>
											<? endif; ?>

											<div class="sale-order-detail-payment-options-methods-shipment-list-item-link">
												<a class="sale-order-detail-show-link"><?= Loc::getMessage('SPOD_LIST_SHOW_ALL')?></a>
												<a class="sale-order-detail-hide-link"><?= Loc::getMessage('SPOD_LIST_LESS')?></a>
											</div>

											<? if (strlen($shipment['TRACKING_URL'])): ?>
												<div class="sale-order-detail-payment-options-shipment-button-container">
													<a class="sale-order-detail-payment-options-shipment-button-element" href="<?=$shipment['TRACKING_URL']?>">
														<?= Loc::getMessage('SPOD_ORDER_CHECK_TRACKING')?>
													</a>
												</div>
											<? endif; ?>

											<div class="sale-order-detail-payment-options-shipment-composition-map">
												<? $store = $arResult['DELIVERY']['STORE_LIST'][$shipment['STORE_ID']]; ?>
												<? if (isset($store)): ?>
													<div class="sale-order-detail-map-container">
														<h4 class="sale-order-detail-payment-options-shipment-composition-map-title">
															<?= Loc::getMessage('SPOD_SHIPMENT_STORE')?>
														</h4>
														<?
															$APPLICATION->IncludeComponent(
																"bitrix:map.yandex.view",
																"",
																Array(
																	"INIT_MAP_TYPE" => "COORDINATES",
																	"MAP_DATA" =>   serialize(
																		array(
																			'yandex_lon' => $store['GPS_S'],
																			'yandex_lat' => $store['GPS_N'],
																			'PLACEMARKS' => array(
																				array(
																					"LON" => $store['GPS_S'],
																					"LAT" => $store['GPS_N'],
																					"TEXT" => htmlspecialcharsbx($store['TITLE'])
																				)
																			)
																		)
																	),
																	"MAP_WIDTH" => "100%",
																	"MAP_HEIGHT" => "300",
																	"CONTROLS" => array("ZOOM", "SMALLZOOM", "SCALELINE"),
																	"OPTIONS" => array(
																		"ENABLE_DRAGGING",
																		"ENABLE_SCROLL_ZOOM",
																		"ENABLE_DBLCLICK_ZOOM"
																	),
																	"MAP_ID" => ""
																)
															);
														?>
													</div>
													<? if (strlen($store['ADDRESS'])):?>
														<div class="row">
															<div class="col-md-12 col-sm-12 sale-order-detail-payment-options-shipment-map-address">
																<div class="row">
																	<span class="col-md-2 sale-order-detail-payment-options-shipment-map-address-title">
																		<?= Loc::getMessage('SPOD_STORE_ADDRESS')?>:
																	</span>
																	<span class="col-md-10 sale-order-detail-payment-options-shipment-map-address-element">
																		<?= htmlspecialcharsbx($store['ADDRESS'])?>
																	</span>
																</div>
															</div>
														</div>
													<? endif; ?>
												<? endif; ?>
												<div class="b-order-detail__shipment-composition">

													<h4 class="b-order-detail__shipment-composition-title"><?= Loc::getMessage('SPOD_ORDER_SHIPMENT_BASKET')?></h4>

													<ul class="b-order-detail__shipment-composition-list">
														<? 
															foreach ($shipment['ITEMS'] as $item): 
															$basketItem = $arResult['BASKET'][$item['BASKET_ID']];
														?>
															<li class="b-order-detail__shipment-composition-item">
																<a href="<?=htmlspecialcharsbx($basketItem['DETAIL_PAGE_URL'])?>">
																	<span><?=htmlspecialcharsbx($basketItem['NAME'])?></span>
																</a>,
																<span><?=$item['QUANTITY']?>&nbsp;<?=htmlspecialcharsbx($item['MEASURE_NAME'])?></span>
															</li>
														<? endforeach; ?>

													</ul>
												</div>
											</div>
										</div>
									<? endforeach; ?>
								</div>
							</div>
							<?
						}
						?>
						
				</div>

			</div>
		</div>

		<div class="b-order-detail__summary">

				<div class="b-order-detail__summary-title">
					<h2><?= Loc::getMessage('SPOD_ORDER_BASKET')?>:</h2>
				</div>
				<div class="b-order-detail__summary-content">
					
					<div class="sale-order-detail-order-table-fade">
						<div style="width: 100%; overflow-x: auto; overflow-y: hidden;">
							<div class="sale-order-detail-order-item-table">
								<div class="sale-order-detail-order-item-tr hidden">
									<div class="sale-order-detail-order-item-td">
										<div class="sale-order-detail-order-item-td-title">
											<?= Loc::getMessage('SPOD_NAME')?>
										</div>
									</div>
									<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties">
										<div class="sale-order-detail-order-item-td-title">
											<?= Loc::getMessage('SPOD_PRICE')?>
										</div>
									</div>
									<?
									if (strlen($arResult["SHOW_DISCOUNT_TAB"]))
									{
										?>
										<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties">
											<div class="sale-order-detail-order-item-td-title">
												<?= Loc::getMessage('SPOD_DISCOUNT') ?>
											</div>
										</div>
										<?
									}
									?>
									<div class="sale-order-detail-order-item-nth-4p1"></div>
									<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties">
										<div class="sale-order-detail-order-item-td-title">
											<?= Loc::getMessage('SPOD_QUANTITY')?>
										</div>
									</div>
									<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties">
										<div class="sale-order-detail-order-item-td-title">
											<?= Loc::getMessage('SPOD_ORDER_PRICE')?>
										</div>
									</div>
								</div>
								<?
								foreach ($arResult['BASKET'] as $basketItem)
								{
									?>
									<div class="sale-order-detail-order-item-tr sale-order-detail-order-basket-info sale-order-detail-order-item-tr-first">
										<div class="sale-order-detail-order-item-td" style="min-width: 300px;">
											<div class="sale-order-detail-order-item-block">
												<div class="sale-order-detail-order-item-img-block">
													<a href="<?=$basketItem['DETAIL_PAGE_URL']?>">
														<?
														if (strlen($basketItem['PICTURE']['SRC']))
														{
															$imageSrc = $basketItem['PICTURE']['SRC'];
														}
														else
														{
															$imageSrc = $this->GetFolder().'/images/no_photo.png';
														}
														?>
														<div class="sale-order-detail-order-item-imgcontainer"
															 style="background-image: url(<?=$imageSrc?>);
																 background-image: -webkit-image-set(url(<?=$imageSrc?>) 1x,
																 url(<?=$imageSrc?>) 2x)">
														</div>
													</a>
												</div>
												<div class="sale-order-detail-order-item-content">
													<div class="sale-order-detail-order-item-title">
														<a href="<?=$basketItem['DETAIL_PAGE_URL']?>">
															<span><?=htmlspecialcharsbx($basketItem['NAME'])?></span>
														</a>
													</div>
													<?
													if (isset($basketItem['PROPS']) && is_array($basketItem['PROPS']))
													{
														foreach ($basketItem['PROPS'] as $itemProps)
														{
															?>
															<div class="sale-order-detail-order-item-color">
															<span class="sale-order-detail-order-item-color-name">
																<?=htmlspecialcharsbx($itemProps['NAME'])?>:</span>
																<span class="sale-order-detail-order-item-color-type">
																<?=htmlspecialcharsbx($itemProps['VALUE'])?></span>
															</div>
															<?
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right">
											<div class="sale-order-detail-order-item-td-title visible-xs visible-sm">
												<?= Loc::getMessage('SPOD_PRICE')?>
											</div>
											<div class="sale-order-detail-order-item-td-text">
												<span class="bx-price"><?=$basketItem['BASE_PRICE_FORMATED']?></span>
											</div>
										</div>
										<?
										if (strlen($basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"]))
										{
											?>
											<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right">
												<div class="sale-order-detail-order-item-td-title visible-xs visible-sm">
													<?= Loc::getMessage('SPOD_DISCOUNT') ?>
												</div>
												<div class="sale-order-detail-order-item-td-text">
													<span class="bx-price"><?= $basketItem['DISCOUNT_PRICE_PERCENT_FORMATED'] ?></span>
												</div>
											</div>
											<?
										}
										elseif (strlen($arResult["SHOW_DISCOUNT_TAB"]))
										{
											?>
											<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right">
												<div class="sale-order-detail-order-item-td-title visible-xs visible-sm">
													<?= Loc::getMessage('SPOD_DISCOUNT') ?>
												</div>
												<div class="sale-order-detail-order-item-td-text">
													<span class="bx-price"></span>
												</div>
											</div>
											<?
										}
										?>
										<div class="sale-order-detail-order-item-nth-4p1"></div>
										<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right">
											<div class="sale-order-detail-order-item-td-title visible-xs visible-sm">
												<?= Loc::getMessage('SPOD_QUANTITY')?>
											</div>
											<div class="sale-order-detail-order-item-td-text">
											<span><?=$basketItem['QUANTITY']?>
												<?
													if (strlen($basketItem['MEASURE_NAME'])) {
														echo htmlspecialcharsbx($basketItem['MEASURE_NAME']);
													}
													else {
														echo Loc::getMessage('SPOD_DEFAULT_MEASURE');
													}
												?>
											</span>
											</div>
										</div>
										<div class="sale-order-detail-order-item-td sale-order-detail-order-item-properties bx-text-right">
											<div class="sale-order-detail-order-item-td-title visible-xs visible-sm"><?= Loc::getMessage('SPOD_ORDER_PRICE')?></div>
											<div class="sale-order-detail-order-item-td-text">
												<span class="bx-price all"><?=$basketItem['FORMATED_SUM']?></span>
											</div>
										</div>
									</div>
									<?
								}
								?>
							</div>
						</div>
					</div>

					<div class="b-order-detail__total g-clearfix">
						<table class="b-order-detail__total-table b-order-detail__total-table--left">
							<? if (floatval($arResult["ORDER_WEIGHT"])): ?>
								<tr>
									<td><?= Loc::getMessage('SPOD_TOTAL_WEIGHT')?>:</td>
									<td><?= $arResult['ORDER_WEIGHT_FORMATED'] ?></td>
								</tr>
							<? endif; ?>
							<? if ($arResult['PRODUCT_SUM_FORMATED'] != $arResult['PRICE_FORMATED'] && !empty($arResult['PRODUCT_SUM_FORMATED'])): ?>
								<tr>
									<td><?= Loc::getMessage('SPOD_COMMON_SUM')?>:</td>
									<td><span class="b-order-detail__total-product-price"><?=$arResult['PRODUCT_SUM_FORMATED']?></span></td>
								</tr>
							<? endif; ?>
							<? if (strlen($arResult["PRICE_DELIVERY_FORMATED"])): ?>
								<tr>
									<td><?= Loc::getMessage('SPOD_DELIVERY')?>:</td>
									<td><?= $arResult["PRICE_DELIVERY_FORMATED"] ?></td>
								</tr>
							<? endif; ?>
							<? if ((float)$arResult["TAX_VALUE"] > 0): ?>
								<tr>
									<td><?= Loc::getMessage('SPOD_TAX') ?>:</td>
									<td><?= $arResult["TAX_VALUE_FORMATED"] ?></td>
								</tr>
							<? endif; ?>
						</table>
						<table class="b-order-detail__total-table b-order-detail__total-table--right">
							<tr>
								<td><?= Loc::getMessage('SPOD_SUMMARY')?>:</td>
								<td><span class="b-order-detail__total-price"><?= $arResult["PRICE_FORMATED"] ?></span></td>
							</tr>
						</table>
					</div>
				</div>
		</div>

		<? if ($arParams['GUEST_MODE'] !== 'Y' && $arResult['LOCK_CHANGE_PAYSYSTEM'] !== 'Y') :?>
			<div class="b-order-detail__back">
				<a href="<?= $arResult["URL_TO_LIST"] ?>">&larr; <span><? echo Loc::getMessage('SPOD_RETURN_LIST_ORDERS');?></span></a>
			</div>
		<? endif; ?>

	</div>
	<?
	$javascriptParams = array(
		"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
		"templateFolder" => CUtil::JSEscape($templateFolder),
		"paymentList" => $paymentData
	);
	$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
	?>
	<script>
		BX.Sale.PersonalOrderComponent.PersonalOrderDetail.init(<?=$javascriptParams?>);
	</script>
<? endif; ?>