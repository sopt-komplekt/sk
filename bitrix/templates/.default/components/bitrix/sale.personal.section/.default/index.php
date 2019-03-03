<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

$arAvailablePages = array();

if ($arParams['SHOW_ORDER_PAGE'] === 'Y') {
	$arAvailablePages[] = array(
		"PATH" => $arResult['PATH_TO_ORDERS'],
		"NAME" => Loc::getMessage("SPS_ORDER_PAGE_NAME"),
		"ICON" => '<svg width="36" height="36"><use xlink:href="#icon-order"></use></svg>'
	);
}

if ($arParams['SHOW_ACCOUNT_PAGE'] === 'Y') {
	$arAvailablePages[] = array(
		"PATH" => $arResult['PATH_TO_ACCOUNT'],
		"NAME" => Loc::getMessage("SPS_ACCOUNT_PAGE_NAME"),
		"ICON" => '<svg width="31" height="36"><use xlink:href="#icon-person"></use></svg>'
	);
}

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y') {
	$arAvailablePages[] = array(
		"PATH" => $arResult['PATH_TO_PRIVATE'],
		"NAME" => Loc::getMessage("SPS_PERSONAL_PAGE_NAME"),
		"ICON" => '<svg width="31" height="36"><use xlink:href="#icon-person"></use></svg>'
	);
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y' && false) {

	$delimeter = ($arParams['SEF_MODE'] === 'Y') ? "?" : "&";
	$arAvailablePages[] = array(
		"PATH" => $arResult['PATH_TO_ORDERS'].$delimeter."filter_history=Y",
		"NAME" => Loc::getMessage("SPS_ORDER_PAGE_HISTORY"),
		"ICON" => '<svg width="36" height="36"><use xlink:href="#icon-order"></use></svg>'
	);
}

if ($arParams['SHOW_PROFILE_PAGE'] === 'Y') {
	$arAvailablePages[] = array(
		"PATH" => $arResult['PATH_TO_PROFILE'],
		"NAME" => Loc::getMessage("SPS_PROFILE_PAGE_NAME"),
		"ICON" => '<svg width="31" height="36"><use xlink:href="#icon-person"></use></svg>'
	);
}

if ($arParams['SHOW_BASKET_PAGE'] === 'Y') {
	$arAvailablePages[] = array(
		"PATH" => $arParams['PATH_TO_BASKET'],
		"NAME" => Loc::getMessage("SPS_BASKET_PAGE_NAME"),
		"ICON" => '<svg width="36" height="31"><use xlink:href="#icon-basket"></use></svg>'
	);
}

if ($arParams['SHOW_SUBSCRIBE_PAGE'] === 'Y') {
	$arAvailablePages[] = array(
		"PATH" => $arResult['PATH_TO_SUBSCRIBE'],
		"NAME" => Loc::getMessage("SPS_SUBSCRIBE_PAGE_NAME"),
		"ICON" => '<svg width="36" height="33"><use xlink:href="#icon-heart"></use></svg>'
	);
}

if ($arParams['SHOW_CONTACT_PAGE'] === 'Y') {
	$arAvailablePages[] = array(
		"PATH" => $arParams['PATH_TO_CONTACT'],
		"NAME" => Loc::getMessage("SPS_CONTACT_PAGE_NAME"),
		"ICON" => '<svg width="36" height="36"><use xlink:href="#icon-order"></use></svg>'
	);
}

/* Выход */
$arAvailablePages[] = array(
	"PATH" => '/?logout=Y',
	"NAME" => Loc::getMessage("SPS_LOGOUT_PAGE_NAME"),
	"ICON" => '<svg width="36" height="36"><use xlink:href="#icon-logout"></use></svg>'
);

$arCustomPages = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($arCustomPages)
{
	foreach ($arCustomPages as $page)
	{
		$arAvailablePages[] = array(
			"PATH" => $page[0],
			"NAME" => $page[1],
			"ICON" => (strlen($page[2])) ? '<i class="fa '.htmlspecialcharsbx($page[2]).'"></i>' : ""
		);
	}
}

if (empty($arAvailablePages)) {
	ShowError(Loc::getMessage("SPS_ERROR_NOT_CHOSEN_ELEMENT"));
}
else
{
	?>

	<svg display="none">
		<symbol viewBox="0 0 23.06 20.4" id="icon-basket">
			<g>
				<g>
					<polyline points="0.5 4.22 3.49 15.12 18.82 15.12 18.45 0.5 22.56 0.5" fill="none" stroke="#5682ff" stroke-linecap="round" stroke-linejoin="round"/>
					<ellipse cx="5.35" cy="19.08" rx="0.87" ry="0.82" fill="none" stroke="#5682ff" stroke-linecap="round" stroke-linejoin="round"/>
					<ellipse cx="16.25" cy="19.08" rx="0.87" ry="0.82" fill="none" stroke="#5682ff" stroke-linecap="round" stroke-linejoin="round"/>
					<line x1="0.5" y1="4.22" x2="18.11" y2="4.22" fill="none" stroke="#5682ff" stroke-linecap="round" stroke-linejoin="round"/>
				</g>
			</g>
		</symbol>
		<symbol viewBox="0 0 20.9 19" id="icon-heart">
			<g>
				<g>
					<path d="M18.74,2.17a5.69,5.69,0,0,0-8,0l-.18.2h0l0,0,0,0h0l-.18-.2a5.69,5.69,0,0,0-8,8l.2.18h0l8.09,8.09,8.09-8.09h0l.2-.18A5.69,5.69,0,0,0,18.74,2.17Z" fill="none" stroke="#5682ff" stroke-linecap="round" stroke-linejoin="round"/>
				</g>
			</g>
		</symbol>
		<symbol viewBox="0 0 42.4 44" id="icon-logout">
			<g>
				<g>
					<path d="M42.34,19.5a.82.82,0,0,0,0-.61.86.86,0,0,0-.18-.26L32.57,9a.8.8,0,1,0-1.13,1.13l8.23,8.23H22.4a.8.8,0,0,0,0,1.6H39.67l-8.23,8.23a.8.8,0,1,0,1.13,1.13l9.6-9.6a.83.83,0,0,0,.18-.26Zm0,0"/>
					<path d="M28,23.2a.8.8,0,0,0-.8.8V36.8h-8V6.4a.8.8,0,0,0-.56-.76L6,1.6H27.2V14.4a.8.8,0,0,0,1.6,0V.8A.8.8,0,0,0,28,0H.8L.73,0,.6,0A.75.75,0,0,0,.39.13L.33.15.26.22l0,0A.73.73,0,0,0,.07.47l0,0A.83.83,0,0,0,0,.8V37.6a.76.76,0,0,0,.06.28A.45.45,0,0,0,.1,38a.71.71,0,0,0,.11.16l.07.07.16.11.09,0,0,0L18.16,44a.85.85,0,0,0,.24,0,.83.83,0,0,0,.47-.15.8.8,0,0,0,.33-.65V38.4H28a.8.8,0,0,0,.8-.8V24a.8.8,0,0,0-.8-.8ZM17.6,42.11,1.6,37V1.9L17.6,7Zm0,0"/>
				</g>
			</g>
		</symbol>
		<symbol viewBox="0 0 92.89 108.58" id="icon-person">
			<g>
				<g>
					<path d="M67.07,23.53c0,21.4-7.25,31.75-20.63,31.75-14.75,0-20.62-12.23-20.62-31.75C25.82,10.37,33.32,2,46.44,2,59.08,2,67.07,10.8,67.07,23.53Z" fill="none" stroke="#5682ff" stroke-miterlimit="10" stroke-width="4"/>
					<path d="M33.22,59.48s-11.86,7.41-21.77,10c-8.83,2.32-9.88,14.1-9.32,23.9a4.05,4.05,0,0,0,2.1,3.35c12.55,6.77,27,9.63,42.23,9.84" fill="none" stroke="#5682ff" stroke-miterlimit="10" stroke-width="4"/>
					<path d="M59.67,59.48s11.86,7.41,21.77,10c8.83,2.32,9.88,14.1,9.32,23.9a4.05,4.05,0,0,1-2.1,3.35c-12.55,6.77-27,9.63-42.23,9.84" fill="none" stroke="#5682ff" stroke-miterlimit="10" stroke-width="4"/>
				</g>
			</g>
		</symbol>
		<symbol viewBox="0 0 60 60" id="icon-order">
			<g>
				<path d="M45,25H20c-0.552,0-1,0.447-1,1s0.448,1,1,1h25c0.552,0,1-0.447,1-1S45.552,25,45,25z" fill="#5682ff"/>
				<path d="M20,19h10c0.552,0,1-0.447,1-1s-0.448-1-1-1H20c-0.552,0-1,0.447-1,1S19.448,19,20,19z" fill="#5682ff"/>
				<path d="M45,33H20c-0.552,0-1,0.447-1,1s0.448,1,1,1h25c0.552,0,1-0.447,1-1S45.552,33,45,33z" fill="#5682ff"/>
				<path d="M45,41H20c-0.552,0-1,0.447-1,1s0.448,1,1,1h25c0.552,0,1-0.447,1-1S45.552,41,45,41z" fill="#5682ff"/>
				<path d="M45,49H20c-0.552,0-1,0.447-1,1s0.448,1,1,1h25c0.552,0,1-0.447,1-1S45.552,49,45,49z" fill="#5682ff"/>
				<path d="M49,14.586V0H6v55h5v5h43V19.586L49,14.586z M40,8.414l9,9L50.586,19H40V8.414z M8,53V2h39v10.586L39.414,5H11v48H8z
					 M13,58v-3V7h25v14h14v37H13z" fill="#5682ff"/>
			</g>
		</symbol>
	</svg>

	<div class="b-personal-header">
		<div class="b-personal-title">
			<p><? echo Loc::getMessage("SPS_HEADER_TITLE"); ?></p>
		</div>
		<div class="b-personal-text">
			<p><? echo Loc::getMessage("SPS_HEADER_TEXT"); ?></p>
		</div>
	</div>

	<div class="b-personal-blocks">

		<? foreach ($arAvailablePages as $arPage): ?>

			<div class="b-personal-block">
				<a href="<? echo htmlspecialcharsbx($arPage['PATH']);?>" class="b-personal-block_holder">
					<div class="b-personal-block_ico">
						<?=$arPage['ICON']?>
					</div>
					<div class="b-personal-block_title"><? echo ($arPage['NAME']);?></div>
				</a>
			</div>

		<? endforeach; ?>

	</div>
	<?
}
?>
