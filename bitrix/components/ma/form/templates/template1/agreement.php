<? 
	$APPLICATION->RestartWorkarea();
	$APPLICATION->SetTitle(GetMessage('AGREEMENT_TITTLE'));

	echo GetMessage('AGREEMENT_TEXT', array('#SITE_URL#' => $arParams['SITE_URL'], '#COMPANY_NAME#' => $arParams['COMPANY_NAME'], '#COMPANY_INN#' => $arParams['COMPANY_INN'], '#COMPANY_ADDRESS#' => $arParams['COMPANY_ADDRESS']));
?>

