<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? global $arTemplateParams; ?>
											</td>
											<td style="width:30px;"></td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0; padding:0;">
									<tbody>
										<tr>
											<td style="width:30px;"></td>
											<td style="padding-top:10px; padding-bottom:10px;">
												<? $DEFAULT_EMAIL_FROM = COption::GetOptionString("main", "email_from"); ?>
												<p>
													С уважением,<br>
													администрация Интернет-магазина «<?=$arTemplateParams['SITE_NAME'] ?>»
												</p>
												<p>
													E-mail: <?=$DEFAULT_EMAIL_FROM?><br>
												</p>
											</td>
											<td style="width:30px;"></td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</table>
				</center>
			</td>
		</tr>
	</table>
</body>
</html>