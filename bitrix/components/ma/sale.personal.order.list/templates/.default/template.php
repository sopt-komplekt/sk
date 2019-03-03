<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs("/bitrix/components/ma/sale.order.payment.change/templates/.default/script.js");
Asset::getInstance()->addCss("/bitrix/components/ma/sale.order.payment.change/templates/.default/style.css");
CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);

?>

<? if (!empty($arResult['ERRORS']['FATAL'])): ?>

	<? 
		foreach($arResult['ERRORS']['FATAL'] as $error) {
			ShowError($error);
		}

		$component = $this->__component;
		if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
			$APPLICATION->AuthForm('', false, false, 'N', false);
		}
	?>

<? else: ?>

	<? 
		if (!empty($arResult['ERRORS']['NONFATAL'])) {
			foreach($arResult['ERRORS']['NONFATAL'] as $error) {
				ShowError($error);
			}
		}
	?>

	<div class="b-order-list">

		<div class="b-order-list__links">
			<? $clearFromLink = array("filter_history","filter_status","show_all", "show_canceled"); ?>
			<? if ($_REQUEST["filter_history"] === 'Y' && $_REQUEST["show_canceled"] === 'Y'): ?>
				<a href="<?=$APPLICATION->GetCurPageParam("", $clearFromLink, false)?>">
					<span><?echo Loc::getMessage("SPOL_TPL_VIEW_CURRENT_ORDERS")?></span>
				</a>
				<a href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>">
					<span><?echo Loc::getMessage("SPOL_TPL_VIEW_FINISHED_ORDERS")?></span>
				</a>
			<? elseif ($_REQUEST["filter_history"] === 'Y' ): ?>
				<a href="<?=$APPLICATION->GetCurPageParam("", $clearFromLink, false)?>">
					<span><?echo Loc::getMessage("SPOL_TPL_VIEW_CURRENT_ORDERS")?></span>
				</a>
				<a href="<?=$APPLICATION->GetCurPageParam("filter_history=Y&show_canceled=Y", $clearFromLink, false)?>">
					<span><?echo Loc::getMessage("SPOL_TPL_VIEW_CANCELED_ORDERS")?></span>
				</a>
			<? else: ?>
				<a href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>">
					<span><?echo Loc::getMessage("SPOL_TPL_VIEW_FINISHED_ORDERS")?></span>
				</a>
				<a href="<?=$APPLICATION->GetCurPageParam("filter_history=Y&show_canceled=Y", $clearFromLink, false)?>">
					<span><?echo Loc::getMessage("SPOL_TPL_VIEW_CANCELED_ORDERS")?></span>
				</a>
			<? endif; ?>
		</div>

		<? if (count($arResult['ORDERS']) > 0): ?>

			<? if ($_REQUEST["filter_history"] === 'Y'): ?>
				
				<? if ($_REQUEST["show_canceled"] === 'Y'): ?>
					<h2 class="b-order-list__title">
						<?= Loc::getMessage('SPOL_TPL_ORDERS_CANCELED_HEADER') ?>
					</h2>
				<? else: ?>
					<h2 class="b-order-list__title">
						<?= Loc::getMessage('SPOL_TPL_ORDERS_FINISHED_HEADER') ?>
					</h2>
				<? endif; ?>

				<? foreach ($arResult['ORDERS'] as $key => $order): ?>

					<div class="b-order-list__item">

						<div class="b-order-list__header">

							<h3>
								<?= Loc::getMessage('SPOL_TPL_ORDER') ?>
								<?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') ?>
								<?= htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER'])?>
								<?= Loc::getMessage('SPOL_TPL_FROM_DATE') ?>
								<?= $order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT'])?>,
								<?= count($order['BASKET_ITEMS']); ?>
								<?
								$count = substr(count($order['BASKET_ITEMS']), -1);
								if ($count == '1')
								{
									echo Loc::getMessage('SPOL_TPL_GOOD');
								}
								elseif ($count >= '2' || $count <= '4')
								{
									echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
								}
								else
								{
									echo Loc::getMessage('SPOL_TPL_GOODS');
								}
								?>
								<?= Loc::getMessage('SPOL_TPL_SUMOF') ?>
								<?= $order['ORDER']['FORMATED_PRICE'] ?>
							</h3>

							<? if ($_REQUEST["show_canceled"] === 'Y'): ?>
								<span class="b-order-list__status b-order-list__status--alert">
									<?= Loc::getMessage('SPOL_TPL_ORDER_CANCELED')?>
								</span>
							<? else: ?>
								<span class="b-order-list__status b-order-list__status--success">
									<?= Loc::getMessage('SPOL_TPL_ORDER_FINISHED')?>
								</span>
							<? endif; ?>
						</div>

						<div class="b-order-list__footer sale-order-list-inner-row">
							<a class="b-order-list__link b-order-list__link--about" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>">
								<span><?=Loc::getMessage('SPOL_TPL_MORE_ON_ORDER')?></span> &rarr;
							</a>
							<a class="b-order-list__link b-order-list__link--repeat" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>">
								&#8635; <span><?=Loc::getMessage('SPOL_TPL_REPEAT_ORDER')?></span>
							</a>
						</div>
					</div>
				<? endforeach; ?>

				
			<? else: ?>

				<?
					$paymentChangeData = array();
					$orderHeaderStatus = null;
				?>

				<? foreach ($arResult['ORDERS'] as $key => $order): ?>

					<? if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $arResult['SORT_TYPE'] == 'STATUS'): ?>
						<? $orderHeaderStatus = $order['ORDER']['STATUS_ID']; ?>
						<h2 class="b-order-list__title">
							<?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])?>&raquo;
						</h2>
					<? endif; ?>

					<div class="b-order-list__item">
						<div class="b-order-list__header">
							<h3>
								<?=Loc::getMessage('SPOL_TPL_ORDER')?>
								<?=Loc::getMessage('SPOL_TPL_NUMBER_SIGN').$order['ORDER']['ACCOUNT_NUMBER']?>
								<?=Loc::getMessage('SPOL_TPL_FROM_DATE')?>
								<?=$order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT'])?>,
								<?=count($order['BASKET_ITEMS']);?>
								<?
								$count = count($order['BASKET_ITEMS']) % 10;
								if ($count == '1')
								{
									echo Loc::getMessage('SPOL_TPL_GOOD');
								}
								elseif ($count >= '2' && $count <= '4')
								{
									echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
								}
								else
								{
									echo Loc::getMessage('SPOL_TPL_GOODS');
								}
								?>
								<?=Loc::getMessage('SPOL_TPL_SUMOF')?>
								<?=$order['ORDER']['FORMATED_PRICE']?>
							</h3>
						</div>
						<div class="b-order-list__general">
							<div class="b-order-list__section">
								<h4 class="b-order-list__section-title"><?=Loc::getMessage('SPOL_TPL_ABOUT')?></h4>
								<div class="b-order-list__about">
									<? /*
									<div class="b-order-list__about-name">
										<? $userName = $arResult["USER"]["NAME"] ." ". $arResult["USER"]["SECOND_NAME"] ." ". $arResult["USER"]["LAST_NAME"]; ?>
										<? if (empty($userName)): ?>
											<strong><? echo Loc::getMessage('SPOL_TPL_FIO').':'; ?></strong>
											<? echo htmlspecialcharsbx($userName); ?>
										<? elseif (empty($arResult['FIO'])): ?>
											<strong><? echo Loc::getMessage('SPOL_TPL_FIO').':'; ?></strong>
											<? echo htmlspecialcharsbx($arResult['FIO']); ?>
										<? else: ?>
											<strong><? echo Loc::getMessage('SPOL_TPL_LOGIN').':'; ?></strong>
											<? echo htmlspecialcharsbx($arResult["USER"]['LOGIN']); ?>
										<? endif; ?>
									</div>
									*/ ?>
									<div class="b-order-list__about-status">
										<strong><? echo Loc::getMessage('SPOL_TPL_CURRENT_STATUS', array('#DATE_ORDER_CREATE#' => $order["ORDER"]["DATE_INSERT_FORMATED"])); ?></strong>
										<?
										if ($order["ORDER"]['CANCELED'] !== 'Y')
										{
											echo htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']);
										}
										else
										{
											echo Loc::getMessage('SPOL_TPL_ORDER_CANCELED');
										}
										?>
									</div>

									<div class="b-order-list__about-sum">
										<? echo Loc::getMessage('SPOL_TPL_PRICE');?>:
										<strong><?=$order["ORDER"]["FORMATED_PRICE"]?></strong>
									</div>
								</div>
							</div>
							<div class="b-order-list__section">

								<h4 class="b-order-list__section-title"><?=Loc::getMessage('SPOL_TPL_PAYMENT')?></h4>

								<div class="b-order-list__payment">

									<? //dump($order); ?>

									<div class="b-order-list__payment-title">
										<?= Loc::getMessage('SPOL_SUB_ORDER_TITLE', array(
											"#ACCOUNT_NUMBER#"=> htmlspecialcharsbx($order["ORDER"]["ACCOUNT_NUMBER"]),
											"#DATE_ORDER_CREATE#"=> $order["ORDER"]["DATE_INSERT_FORMATED"]
										))?>
										<?
										if ($order["ORDER"]['CANCELED'] !== 'Y')
										{
											echo htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']);
										}
										else
										{
											echo Loc::getMessage('SPOL_ORDER_CANCELED');
										}
										?>
									</div>
									<div class="b-order-list__payment-price">
										<?=Loc::getMessage('SPOL_ORDER_PRICE_FULL')?>:
										<strong><?=$order["ORDER"]["FORMATED_PRICE"]?></strong>
									</div>

								</div>

								<div class="b-order-list__payment-list">
									<? foreach ($order['PAYMENT'] as $payment): ?>
										<? 
											if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y') {
												$paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
													"order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
													"payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
													"allow_inner" => $arParams['ALLOW_INNER'],
													"refresh_prices" => $arParams['REFRESH_PRICES'],
													"path_to_payment" => $arParams['PATH_TO_PAYMENT'],
													"only_inner_full" => $arParams['ONLY_INNER_FULL']
												);
											}
										?>
										<div class="sale-order-list-inner-row">
											<div class="sale-order-list-inner-row-body">

												<div class="b-order-list__payment-item">
													<div class="b-order-list__payment-item-title">
														<?
														$paymentSubTitle = Loc::getMessage('SPOL_TPL_BILL')." ".Loc::getMessage('SPOL_TPL_NUMBER_SIGN').htmlspecialcharsbx($payment['ACCOUNT_NUMBER']);
														if(isset($payment['DATE_BILL']))
														{
															$paymentSubTitle .= " ".Loc::getMessage('SPOL_TPL_FROM_DATE')." ".$payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
														}
														$paymentSubTitle .=",";
														echo $paymentSubTitle;
														?>
														<?=$payment['PAY_SYSTEM_NAME']?>
													</div>
													<div class="b-order-list__payment-item-price">
														<?=Loc::getMessage('SPOL_TPL_SUM_TO_PAID')?>:
														<strong><?=$payment['FORMATED_SUM']?></strong>
													</div>

													<div class="b-order-list__payment-item-status">
														<? if ($payment['PAID'] === 'Y'): ?>
															<span class="b-order-list__status b-order-list__status--success"><?=Loc::getMessage('SPOL_TPL_PAID')?></span>
														<? elseif ($order['ORDER']['IS_ALLOW_PAY'] == 'N'): ?>
															<span class="b-order-list__status b-order-list__status--restricted"><?=Loc::getMessage('SPOL_TPL_RESTRICTED_PAID')?></span>
														<? else: ?>
															<span class="b-order-list__status b-order-list__status--alert"><?=Loc::getMessage('SPOL_TPL_NOTPAID')?></span>
														<? endif; ?>
													</div>

													<?
													if (!empty($payment['CHECK_DATA']))
													{
														$listCheckLinks = "";
														foreach ($payment['CHECK_DATA'] as $checkInfo)
														{
															$title = Loc::getMessage('SPOL_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID']))." - ". htmlspecialcharsbx($checkInfo['TYPE_NAME']);
															if (strlen($checkInfo['LINK']))
															{
																$link = $checkInfo['LINK'];
																$listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
															}
														}
														if (strlen($listCheckLinks) > 0)
														{
															?>
															<div class="sale-order-list-payment-check">
																<div class="sale-order-list-payment-check-left"><?= Loc::getMessage('SPOL_CHECK_TITLE')?>:</div>
																<div class="sale-order-list-payment-check-left">
																	<?=$listCheckLinks?>
																</div>
															</div>
															<?
														}
													}
													?>

													<? if ($payment['PAID'] !== 'Y' && $order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'): ?>
														<div class="b-order-list__payment-item-change">
															<a class="sale-order-list-change-payment" href="#" id="<?= htmlspecialcharsbx($payment['ACCOUNT_NUMBER']) ?>">
																<?= Loc::getMessage('SPOL_TPL_CHANGE_PAY_TYPE') ?>
															</a>
														</div>
													<? endif; ?>

													<? if ($order['ORDER']['IS_ALLOW_PAY'] == 'N' && $payment['PAID'] !== 'Y'): ?>
														<div class="sale-order-list-status-restricted-message-block">
															<span class="sale-order-list-status-restricted-message"><?=Loc::getMessage('SOPL_TPL_RESTRICTED_PAID_MESSAGE')?></span>
														</div>
													<? endif;?>

												</div>
												<? if ($payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y'): ?>

													<div class="b-order-list__buttons">
														<? if ($order['ORDER']['IS_ALLOW_PAY'] == 'N'): ?>
															<a class="b-button g-button sale-order-list-button inactive-button">
																<?=Loc::getMessage('SPOL_TPL_PAY')?>
															</a>
														<? elseif ($payment['NEW_WINDOW'] === 'Y'): ?>
															<a class="b-button g-button sale-order-list-button" target="_blank" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>">
																<?=Loc::getMessage('SPOL_TPL_PAY')?>
															</a>
														<? else: ?>
															<a class="b-button g-button" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>">
																<?=Loc::getMessage('SPOL_TPL_PAY')?>
															</a>
														<? endif; ?>
													</div>
												<? endif; ?>
											</div>
											<div class="sale-order-list-inner-row-template">
												<a class="sale-order-list-cancel-payment" href="#">
													<?=Loc::getMessage('SPOL_CANCEL_PAYMENT')?>
												</a>
											</div>
										</div>
										
									<? endforeach; ?>
								</div>

							</div>
							<div class="b-order-list__section">

							<? if (!empty($order['SHIPMENT'])): ?>

								<h4 class="b-order-list__section-title"><?=Loc::getMessage('SPOL_TPL_DELIVERY')?></h4>
								<? foreach ($order['SHIPMENT'] as $shipment): ?>
									<? 
										if (empty($shipment)) {
											continue;
										}
									?>

										<div class="b-order-list__shipment sale-order-list-inner-row">

											<div class="b-order-detail__shipment-title">
												<?=Loc::getMessage('SPOL_TPL_LOAD')?>
												<?
												$shipmentSubTitle = Loc::getMessage('SPOL_TPL_NUMBER_SIGN').htmlspecialcharsbx($shipment['ACCOUNT_NUMBER']);
												if ($shipment['DATE_DEDUCTED'])
												{
													$shipmentSubTitle .= " ".Loc::getMessage('SPOL_TPL_FROM_DATE')." ".$shipment['DATE_DEDUCTED']->format($arParams['ACTIVE_DATE_FORMAT']);
												}

												if ($shipment['FORMATED_DELIVERY_PRICE'])
												{
													$shipmentSubTitle .= ", ".Loc::getMessage('SPOL_TPL_DELIVERY_COST')." ".$shipment['FORMATED_DELIVERY_PRICE'];
												}
												echo $shipmentSubTitle;
												?>
											</div>

											<? if (!empty($shipment['DELIVERY_ID'])): ?>
												<div class="b-order-detail__shipment-prop">
													<?=Loc::getMessage('SPOL_TPL_DELIVERY_SERVICE')?>:
													<?=$arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]['NAME']?>
												</div>
											<? endif; ?>

											<div class="b-order-detail__shipment-prop">
												<?=Loc::getMessage('SPOL_ORDER_SHIPMENT_STATUS');?>:
												<?=htmlspecialcharsbx($shipment['DELIVERY_STATUS_NAME'])?>
											</div>

											<? if (!empty($shipment['TRACKING_NUMBER'])): ?>
												<div class="b-order-detail__shipment-prop">
													<span class="sale-order-list-shipment-id-name"><?=Loc::getMessage('SPOL_TPL_POSTID')?>:</span>
													<span class="sale-order-list-shipment-id"><?=htmlspecialcharsbx($shipment['TRACKING_NUMBER'])?></span>
													<span class="sale-order-list-shipment-id-icon"></span>
												</div>
											<? endif; ?>
										</div>

										<? if (strlen($shipment['TRACKING_URL']) > 0): ?>
											<div class="b-order-detail__shipment-prop">
												<a href="<?=$shipment['TRACKING_URL']?>" target="_blank">
													<span><?=Loc::getMessage('SPOL_TPL_CHECK_POSTID')?></span>
												</a>
											</div>
										<? endif; ?>

								<? endforeach; ?>

							<? endif; ?>

							</div>
						</div>

						<div class="b-order-list__footer sale-order-list-inner-row">
							<a class="b-order-list__link b-order-list__link--about" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>">
								<span><?=Loc::getMessage('SPOL_TPL_MORE_ON_ORDER')?></span> &rarr;
							</a>
							<a class="b-order-list__link b-order-list__link--repeat" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>">
								&#8635; <span><?=Loc::getMessage('SPOL_TPL_REPEAT_ORDER')?></span>
							</a>
							<? if ($order["ORDER"]["CAN_CANCEL"] === "Y"): ?>
								<a class="b-order-list__link b-order-list__link--cancel" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"])?>">
									<span><?=Loc::getMessage('SPOL_TPL_CANCEL_ORDER')?></span>
								</a>
							<? endif; ?>
						</div>
					</div>
					<?
				endforeach;
				?>

				
			<? endif; ?>

			<?
				echo $arResult["NAV_STRING"];
			?>
			<? if ($_REQUEST["filter_history"] !== 'Y'): ?>
				<?
				$javascriptParams = array(
					"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
					"templateFolder" => CUtil::JSEscape($templateFolder),
					"paymentList" => $paymentChangeData
				);
				$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
				?>
				<script>
					BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
				</script>
			<? endif; ?>

		<? else: ?>

			<? if ($_REQUEST["filter_history"] === 'Y' && $_REQUEST["show_canceled"] === 'Y'): ?>
				<h2 class="b-order-list__title"><?= Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER')?></h2>
			<? elseif ($_REQUEST["filter_history"] === 'Y'): ?>
				<h2 class="b-order-list__title"><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST')?></h2>
			<? else: ?>
				<h2 class="b-order-list__title"><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST')?></h2>
			<? endif; ?>
		
			<a class="b-button g-button" href="<?=htmlspecialcharsbx($arParams['PATH_TO_CATALOG'])?>">
				<?=Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG')?>
			</a>

		<? endif; ?>

	</div>

<? endif; ?>
