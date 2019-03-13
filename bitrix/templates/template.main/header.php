<?
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	include('profile.php');
?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
<head>
	<title><? $APPLICATION->ShowTitle() ?></title>
	<link rel="icon" type="image/png" href="<?=SITE_TEMPLATE_PATH?>/img/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?=SITE_TEMPLATE_PATH?>/img/favicon-16x16.png" sizes="16x16">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:100,300,400,400i,600,700&amp;subset=cyrillic" rel="stylesheet">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="cmsmagazine" content="e6fd439a227530d5512cab76bd319bb3">
	<?  
		// для адаптивной верстки
		//<meta content="True" name="HandheldFriendly">
		//<meta name="viewport" content="width=device-width, initial-scale=1">
	?>
	<? $APPLICATION->ShowHead() ?>
	<?
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/lib/owl.carousel.css"); 
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/lib/owl.theme.css"); 

		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/global/global.css"); 
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/global/font.css");
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/layout/holster.css");
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/layout/blocks.css");
		Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/css/layout/content.css");
	?>
</head>
<body>

	<? //svg icons ?>

	<? /*
	<svg class="visually-hidden">
		<defs>
			<linearGradient id="gradient" x1="0%" y1="100%" x2="80%" y2="0">
				<stop offset="0%" style="stop-color: #fad400"></stop>
				<stop offset="100%" style="stop-color: #ff9600"></stop>
			</linearGradient>
		</defs>

		<symbol viewBox="0 0 569.43 569.45" id="icon-services">
			<defs>
				<clipPath id="clip-path" transform="translate(-0.55)">
					<rect width="569" height="569" fill="none"/>
				</clipPath>
			</defs>
			<g>
				<g>
					<g clip-path="url(#clip-path)">
						<path d="M1.8,52.2,39.75,118.6a9.5,9.5,0,0,0,5.93,4.5l35.4,8.85L202.5,253.37,215.92,240,92.59,116.64a9.43,9.43,0,0,0-4.4-2.5l-34-8.54L21.87,49l27.7-27.7,56.59,32.34,8.54,34a9.47,9.47,0,0,0,2.49,4.41L240.52,215.43,253.93,202,132.51,80.59,123.66,45.2a9.51,9.51,0,0,0-4.5-5.94L52.75,1.32A9.48,9.48,0,0,0,41.37,2.84L3.42,40.79A9.48,9.48,0,0,0,1.8,52.2Zm0,0" transform="translate(-0.55)"/>
					</g>
					<path d="M396.2,187,187.5,395.67l-13.42-13.41,208.71-208.7Zm0,0" transform="translate(-0.55)"/>
					<g clip-path="url(#clip-path)">
						<path d="M151,403.05a9.49,9.49,0,0,0-8.13-4.6H85.93a9.48,9.48,0,0,0-8.13,4.6L49.34,450.48a9.49,9.49,0,0,0,0,9.77L77.8,507.69a9.49,9.49,0,0,0,8.13,4.6h56.92a9.5,9.5,0,0,0,8.13-4.6l28.46-47.43a9.48,9.48,0,0,0,0-9.77Zm-13.5,90.26H91.3L68.53,455.37,91.3,417.42h46.18l22.77,37.95Zm0,0" transform="translate(-0.55)"/>
						<path d="M455.9,227.7A113.43,113.43,0,0,0,566.24,86.35a9.48,9.48,0,0,0-15.91-4.42l-59.05,59-46.85-15.61L428.8,78.48l59.05-59.07A9.49,9.49,0,0,0,483.41,3.5,113.49,113.49,0,0,0,342.06,113.86a111.53,111.53,0,0,0,2.3,22.23L136.61,343.84a111.87,111.87,0,0,0-22.23-2.3A113.84,113.84,0,1,0,228.22,455.37a111.53,111.53,0,0,0-2.31-22.23l49.74-49.74,21.75,21.75a9.49,9.49,0,0,0,13.41,0l4.74-4.75a10.64,10.64,0,0,1,15.07,15l-4.76,4.76a9.49,9.49,0,0,0,0,13.41L439,546.78A76.56,76.56,0,1,0,547.8,439l-.49-.49L434.14,325.34a9.49,9.49,0,0,0-13.41,0L416,330.08a10.64,10.64,0,0,1-15.07-15l0,0,4.75-4.75a9.48,9.48,0,0,0,0-13.41l-21.75-21.75,49.74-49.74a111.52,111.52,0,0,0,22.23,2.31Zm37.27,322.54A57.67,57.67,0,0,1,473,546.56l74.09-74.09a57.53,57.53,0,0,1-53.91,77.77ZM385.7,303.68a29.61,29.61,0,0,0,41.74,41.68L533.9,451.91c1.16,1.16,2.24,2.38,3.28,3.62l-81.11,81.11c-1.25-1-2.47-2.12-3.62-3.28L345.9,426.82a29.61,29.61,0,0,0-41.74-41.69L289,370l81.54-81.41ZM424,208.27,208.8,423.43a9.5,9.5,0,0,0-2.51,9,95.5,95.5,0,1,1-69-69,9.57,9.57,0,0,0,9-2.5L361.48,145.79a9.48,9.48,0,0,0,2.49-9A94.41,94.41,0,0,1,461.28,19.15l-50,50.06a9.48,9.48,0,0,0-2.3,9.7l19,56.92a9.48,9.48,0,0,0,6,6l56.92,19a9.49,9.49,0,0,0,9.7-2.28l50-50c.11,1.81.17,3.6.17,5.39A94.38,94.38,0,0,1,433,205.77a9.48,9.48,0,0,0-9,2.5H424Zm0,0" transform="translate(-0.55)"/>
					</g>
					<path d="M491.07,477.12l-13.42,13.42L382.8,395.67l13.41-13.41Zm0,0" transform="translate(-0.55)"/>
				</g>
			</g>
		</symbol>
		<symbol viewBox="0 0 480 480" id="icon-support">
			<g>
				<g>
					<path d="M472,432H448V280a8,8,0,0,0-14.55-4.58l-112,160A8,8,0,0,0,328,448H432v24a8,8,0,0,0,16,0V448h24a8,8,0,0,0,0-16ZM432,305.38V432H343.36Z"/>
					<path d="M328,464H233.29l88.06-103.69a8.61,8.61,0,0,0,.56-.74A55.65,55.65,0,0,0,309.34,284,64,64,0,0,0,208,336a8,8,0,0,0,16,0,48,48,0,0,1,76-39,39.5,39.5,0,0,1,8.8,53.32l-98.9,116.5A8,8,0,0,0,216,480H328a8,8,0,0,0,0-16Z"/>
					<path d="M216.18,424.15a8,8,0,0,0-7.69-8.3h0A199.76,199.76,0,0,1,16.28,224H48a8,8,0,1,0,0-16H16.28A199.52,199.52,0,0,1,208,16.29V40a8,8,0,0,0,16,0V16.29a199.66,199.66,0,0,1,191.62,188l-31.2-31.2A8,8,0,0,0,373.1,184.4l44.66,44.66a7.87,7.87,0,0,0,3.15,2.3,9.18,9.18,0,0,0,1,.23,8,8,0,0,0,1.7.41H424a7.73,7.73,0,0,0,1.79-.35,7.52,7.52,0,0,0,1-.18,7.88,7.88,0,0,0,2.89-1.81l45.26-45.25a8,8,0,0,0-11.31-11.31l-32,32A215.66,215.66,0,0,0,216.57.11c-.2,0-.37-.11-.57-.11s-.37.1-.57.11C96.58.28.28,96.58.11,215.43c0,.2-.11.37-.11.57s.1.37.11.57c.2,115.92,91.94,211,207.78,215.28h.3A8,8,0,0,0,216.18,424.15Z"/>
					<path d="M323.48,108.52a8,8,0,0,0-11.31,0l-86,86a25.06,25.06,0,0,0-20.41,0l-40.7-40.7a8,8,0,0,0-11.31,11.31l40.62,40.62A24,24,0,0,0,233,233h0a23.74,23.74,0,0,0,4.62-27.26l85.89-85.89A8,8,0,0,0,323.48,108.52ZM221.66,221.66h0a8.18,8.18,0,0,1-11.31,0,8,8,0,1,1,11.31,0Z"/>
				</g>
			</g>
		</symbol>
		<symbol viewBox="0 0 512 511.61" id="icon-storage">
			<g>
				<g>
					<path d="M512,174.35c0-3.1-2.33-6.21-4.65-7l-152-56.63a6.63,6.63,0,0,0-5.43,0l-57.41,20.95V105.31l4.65-1.55c3.1-.78,4.65-3.88,4.65-7V56.44a7.45,7.45,0,0,0-5.43-7L166.79.58c-2.33-.78-3.88-.78-5.43,0L27.15,49.45h0a7.45,7.45,0,0,0-5.43,7V95.22c0,3.1,2.33,6.21,4.65,7l3.88,1.55V220.9c0,3.1,1.55,6.21,4.65,7L90,250.38l-85.33,31c-2.33.78-4.65,3.88-4.65,7v38.79c0,3.1,2.33,6.21,4.65,7l3.88,1.55V452.85c0,3.1,1.55,6.21,4.65,7L139.64,511a6.63,6.63,0,0,0,5.43,0l121-46.55c3.1-.78,4.65-3.88,4.65-7V401.65l78.35,31.81a6.63,6.63,0,0,0,5.43,0l141.19-54.3c3.1-.78,4.65-3.88,4.65-7v-142l6.21-2.33q4.65-2.33,4.65-7V174.35Zm-298.67,187V234.86l131.1,50.42V414.06ZM15.52,322.52V300l118.69,46.55v21.72Zm134.21,23.27,48.1-19.39v22.5l-48.1,18.62ZM344.44,241.07V269l-141.19-54.3V186C232,196.85,206.35,186.76,344.44,241.07Zm7.76-114.81,130.33,48.87-130.33,52c-40.34-15.52-7.76-3.1-135-52Zm-75.25,10.86-83.78,30.25h0a7.45,7.45,0,0,0-5.43,7h0v45.77c0,3.1,2.33,6.21,4.65,7l5.43,2.33v20.95l-26.38,10.08V152.63l105.5-41.89v26.38ZM37.24,89.79V68.07c25.6,10.08,91.54,35.68,118.69,46.55v21.72Zm249-21.72v22.5l-4.65,1.55h-.78L170.67,135.56V113.84C241.26,85.92,216.44,96,286.25,68.07Zm-122.57-52L272.29,57.21C211,82,234.28,72.73,163.68,100.65,123.35,85.14,91.54,72.73,51.2,57.21ZM45.77,110l110.16,41.89V259.68L45.77,216.24Zm65.94,148.95,48.87,20.17c2.33.78,3.88.78,5.43,0h0l31-12.41v43.44l-55.85,22.5L29.48,289.16ZM24,341.92l110.16,41.89V491.64L24,448.19ZM255.22,452.07l-105.5,41.12V384.58L197.82,366v.78c0,3.1,1.55,6.21,4.65,7l52.75,20.95ZM485.62,366,360,414.84V286.06l125.67-49.65Zm10.86-150.5C488.73,218.57,391.76,256.58,360,269v-28.7c45.77-18.62,90.76-36.46,136.53-54.3Z"/>
				</g>
			</g>
		</symbol>
		<symbol viewBox="0 0 40.9 45.76" id="icon-delivery">
			<defs>
				<clipPath id="clip-path-delivery">
					<rect width="40.8" height="46" fill="none"/>
				</clipPath>
			</defs>
			<g>
				<g>
					<g clip-path="url(#clip-path-delivery)">
						<path d="M35.12,11.09,37,9.23l.82.82,1-1L36.07,6.25l-1,1,.91.91-1.87,1.87a20.55,20.55,0,1,0,1.06,1ZM21.29,44.27V40.65H19.61v3.62A19,19,0,0,1,1.48,26h3V24.57h-3A19,19,0,0,1,19.72,6.34V9.5h1.46V6.34A19,19,0,0,1,39.41,24.57H36.65V26h2.76A19,19,0,0,1,21.29,44.27Zm0,0"/>
					</g>
					<path d="M21.29,22.92V14.78a.7.7,0,1,0-1.37,0v8a2.54,2.54,0,0,0,0,5v1.11a.71.71,0,1,0,1.38,0v-1.2a2.52,2.52,0,0,0,0-4.77Zm0,0"/>
					<rect x="19.72" width="1.46" height="3.91"/>
				</g>
			</g>
		</symbol>

		<symbol viewBox="0 0 18.08 24.47" id="icon-guarantee">
			<g>
				<g>
					<path d="M2.79,9a.4.4,0,0,1,.4-.4h9.53a.4.4,0,0,1,0,.8H3.19a.4.4,0,0,1-.4-.4Zm.4,3.87h9.53a.4.4,0,0,0,0-.8H3.19a.4.4,0,1,0,0,.8Zm4.12,2.67H3.19a.4.4,0,1,0,0,.8H7.31a.4.4,0,0,0,0-.8ZM6.78,19H3.19a.4.4,0,1,0,0,.8H6.78a.4.4,0,0,0,0-.8Zm11.3.47a5,5,0,0,1-8.41,3.73H.4a.4.4,0,0,1-.4-.4V4.06a.4.4,0,0,1,.4-.4H3.78V2.56a.4.4,0,0,1,.4-.4H5.82v0a2.14,2.14,0,0,1,4.28,0v0h1.64a.4.4,0,0,1,.4.4v1.1h3.38a.4.4,0,0,1,.4.4V15.31a5,5,0,0,1,2.17,4.13ZM4.58,4.92h6.75V3H9.64a.4.4,0,0,1-.39-.5,1.28,1.28,0,0,0,0-.32,1.34,1.34,0,0,0-2.68,0,1.44,1.44,0,0,0,0,.32.4.4,0,0,1-.39.5H4.58ZM.8,22.37H9a5,5,0,0,1,6.15-7.51V4.46h-3v.86a.4.4,0,0,1-.4.4H4.18a.4.4,0,0,1-.4-.4V4.46H.8Zm16.48-2.92A4.23,4.23,0,1,0,13,23.67a4.24,4.24,0,0,0,4.23-4.23Zm-2-1.67L12.8,20.12,11.14,18.8a.4.4,0,1,0-.5.63L12.57,21a.42.42,0,0,0,.25.09.41.41,0,0,0,.28-.11l2.7-2.59a.4.4,0,0,0-.55-.58Zm0,0"/>
				</g>
			</g>
		</symbol>
	</svg>
	*/ ?>

	<div class="l-page jsPage">

		<? $APPLICATION->ShowPanel() ?>
		<? include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/site-settings.php"); ?>
		<? if(!$USER->IsAdmin()): ?>
			<? include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/statistics.php"); ?>
		<? endif; ?>

		<header class="l-page__header b-header jsHeader">
			<div class="l-wrapper b-header__wrapper">
				<div class="b-header__nav">
					<button class="b-header__nav-btn jsHeaderNavButton">
						<span class="b-header__nav-icon"></span>
					</button>
					<div class="b-header__nav-block">
						<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/header/menu.php"); ?>
					</div>
				</div>
				<a class="b-header__logo"<? if (!$FL_MAIN): ?> href="/"<? endif; ?>>
					<img src="<?=SITE_TEMPLATE_PATH?>/img/header/logo@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/header/logo@2x.png 2x" alt="Сопт-Комплект" width="100" height="45">
				</a>
				<div class="b-header__phone">
					<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/phone.php",Array(),Array("MODE"=>"html")); ?>
				</div>
				<div class="b-header__menu">
					<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/header/catalog.php"); ?>
				</div>
				<div class="b-header__user<? if ($USER->IsAuthorized()): ?> is-auth<?endif;?>">
					<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/header/search.php"); ?>
					<?/*<a class="b-header__user-item search" href="/catalog/search/">Поиск</a>*/?>
					<?/*<a class="b-header__user-item personal" href="/personal/">Личный кабинет</a>*/?>
					<? if (!$USER->IsAuthorized()): ?>
						<a class="b-header__user-item login" href="/personal/private/">
							<i class="personal-icon"></i>
							<span class="personal-text">Войти</span>
						</a>
					<? else: ?>

                            <a class="b-header__user-item personal" href="/personal/" title="Личный кабинет">Личный кабинет</a>

                            <? //if ($USER->IsAdmin()): ?>
                                <div class="b-header__user-item user-info">
                                    <?
                                    $rsUser = CUser::GetByID($USER->GetID());
                                    $arUser = $rsUser->Fetch();
                                    ?>
                                    <? if ($arUser["WORK_COMPANY"]): ?>
                                        <span>
                                            <?=$arUser["WORK_COMPANY"];?>
                                        </span>
                                    <? endif; ?>
                                    <? if (!$arUser["WORK_COMPANY"]): ?>
                                    <span><?=$USER->GetFullName();?></span>
                                    <? endif; ?>
                                </div>
                            <? //endif; ?>
					<? endif; ?>
					<div class="b-header__user-item">
						<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/header/cart.php"); ?>
					</div>
				</div>
			</div>
<?=\Bitrix\Main\Config\Option::get("slam.counters","META_STRING","",SITE_ID)?> 
		</header>
		<main class="l-page__content b-content<? if ($FL_MAIN): ?> b-main<? endif; ?>">
			
			<? if ($FL_MAIN): ?>

				<div class="b-main__intro g-pattern-filled">
					<section class="b-main__catalog-presents b-catalog-presents">
						<div class="l-wrapper b-catalog-presents__wrapper">
							<div class="b-catalog-presents__text">
								<h1 class="b-catalog-presents__title">
									<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/catalog-presents-title.php",Array(),Array("MODE"=>"html")); ?>
								</h1>
								<div class="b-catalog-presents__description">
									<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/catalog-presents-description.php",Array(),Array("MODE"=>"html")); ?>
								</div>
								<div class="b-catalog-presents__more">
									<a class="g-button g-button--big" href="/catalog/">Каталог</a>
								</div>
							</div>

							<ul class="b-catalog-presents__sections">
								<li class="b-catalog-presents__item b-catalog-presents__item--controllers">
									<img src="<?=SITE_TEMPLATE_PATH?>/img/main/catalog-presents-controllers-2@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/main/catalog-presents-controllers-2@2x.png 2x" alt="Контроллеры" width="214" height="217">
									<div class="b-catalog-presents__tooltip g-tooltip" title="Контроллеры<br> <a class='g-decorated-link' href='http://sopt-komplekt.ru/catalog/kontrollery/'><span>Подробнее</span></a>"></div>
								</li>
								<li class="b-catalog-presents__item b-catalog-presents__item--sensors">
									<img src="<?=SITE_TEMPLATE_PATH?>/img/main/catalog-presents-sensors@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/main/catalog-presents-sensors@2x.png 2x" alt="Датчики тока, блоки питания и силовые разъемы" width="190" height="148">
									<div class="b-catalog-presents__tooltip g-tooltip" title="Датчики тока, блоки питания и силовые разъемы<br> <a class='g-decorated-link' href=''><span>Подробнее</span></a>"></div>
								</li>
								<li class="b-catalog-presents__item b-catalog-presents__item--data-systems">
									<img src="<?=SITE_TEMPLATE_PATH?>/img/main/catalog-presents-data-systems@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/main/catalog-presents-data-systems@2x.png 2x" alt="Системы сбора информации RTU" width="285" height="179">
									<div class="b-catalog-presents__tooltip g-tooltip" title="Системы сбора информации RTU<br> <a class='g-decorated-link' href='http://sopt-komplekt.ru/catalog/sistemy_sbora_informatsii_rtu/'><span>Подробнее</span></a>"></div>
								</li>
								<li class="b-catalog-presents__item b-catalog-presents__item--modules">
									<img src="<?=SITE_TEMPLATE_PATH?>/img/main/catalog-presents-modules-2@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/main/catalog-presents-modules-2@2x.png 2x" alt="Выпрямительные модули" width="387" height="379">
									<div class="b-catalog-presents__tooltip g-tooltip" title="Выпрямительные модули<br> <a class='g-decorated-link' href='http://sopt-komplekt.ru/catalog/vysokochastotnye_vypryamitelnye_moduli/'><span>Подробнее</span></a>"></div>
								</li>
							</ul>
						</div>
					</section>
					<section class="b-main__catalog-product b-catalog-product">
						<div class="l-wrapper b-catalog-product__wrapper">
							<header class="b-catalog-product__header">
								<h2 class="b-catalog-product__title">
									<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/catalog-product-title.php",Array(),Array("MODE"=>"html")); ?>
								</h2>
								<div class="b-catalog-product__description">
									<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/catalog-product-description.php",Array(),Array("MODE"=>"html")); ?>
								</div>
							</header>
							<div class="">
								<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/main/catalog-section-main.php"); ?>
							</div>
						</div>
					</section>
				</div>

				<section class="b-main__catalog-sections b-catalog-sections">
					<div class="l-wrapper">
						<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/main/catalog-section-first.php"); ?>
					</div>
				</section>

				<section class="b-main__features b-features">
					<div class="l-wrapper">
						<ul class="b-features__list">
							<li class="b-features__item">
								<?/*
								<svg class="b-features__icon b-features__icon--service" width="50" height="50" fill="url(#gradient)">
									<use xlink:href="#icon-services"></use>
								</svg>
								*/ ?>
								<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/features-services.php",Array(),Array("MODE"=>"html")); ?>
							</li>
							<li class="b-features__item">
								<?/*
								<svg class="b-features__icon b-features__icon--support" width="50" height="50" fill="url(#gradient)">
									<use xlink:href="#icon-support"></use>
								</svg>
								*/ ?>
								<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/features-support.php",Array(),Array("MODE"=>"html")); ?>
							</li>
							<li class="b-features__item">
								<?/*
								<svg class="b-features__icon b-features__icon--storage" width="56" height="56" fill="url(#gradient)">
									<use xlink:href="#icon-storage"></use>
								</svg>
								*/ ?>
								<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/features-storage.php",Array(),Array("MODE"=>"html")); ?>
							</li>
							<li class="b-features__item">
								<?/*
								<svg class="b-features__icon b-features__icon--delivery" width="41" height="46" fill="url(#gradient)">
									<use xlink:href="#icon-delivery"></use>
								</svg>
								*/ ?>
								<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/features-delivery.php",Array(),Array("MODE"=>"html")); ?>
							</li>
							<li class="b-features__item">
								<?/*
								<svg class="b-features__icon b-features__icon--guarantee" width="35" height="46" fill="url(#gradient)">
									<use xlink:href="#icon-guarantee"></use>
								</svg>
								*/ ?>
								<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/features-guarantee.php",Array(),Array("MODE"=>"html")); ?>
							</li>
						</ul>
					</div>
				</section>

				<section class="b-main__catalog-sections b-catalog-sections b-catalog-sections--filled-bg">
					<div class="l-wrapper">
						<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/main/catalog-section-second.php"); ?>
					</div>
				</section>


				<div class="l-wrapper">

					<section class="b-main__advantages b-advantages">
						<h2 class="b-main__title">
							<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/advantages-title.php",Array(),Array("MODE"=>"html")); ?>
						</h2>
						<ul class="b-advantages__list">
							<li class="b-advantages__item">
								<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/advantages-item-first.php",Array(),Array("MODE"=>"html")); ?>
							</li>
							<li class="b-advantages__item">
								<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/advantages-item-second.php",Array(),Array("MODE"=>"html")); ?>
							</li>
							<li class="b-advantages__item">
								<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/advantages-item-third.php",Array(),Array("MODE"=>"html")); ?>
							</li>
						</ul>
					</section>
					
					<section class="b-main__brands b-brands">
						<h2 class="b-main__title b-brands__title">
							<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/brands-title.php",Array(),Array("MODE"=>"html")); ?>
						</h2>
						<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/main/brands-list.php"); ?>
					</section>
				</div>

				<section class="b-main__about b-about">
					<div class="l-wrapper b-about__wrapper">
						<div class="b-about__pic">
							<img src="<?=SITE_TEMPLATE_PATH?>/img/main/about-pic@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/main/about-pic@2x.png 2x" alt="СОПТ-Комплект" width="570" height="360">
						</div>
						<div class="b-about__text">
							<h2 class="b-main__title b-about__title">
								<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/about-title.php",Array(),Array("MODE"=>"html")); ?>
							</h2>
							<div class="b-about__description">
								<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/main/about-description.php",Array(),Array("MODE"=>"html")); ?>
							</div>
							<div class="b-about__more">
								<a class="g-decorated-link" href="/company/">
									<span>Подробнее</span>
								</a>
							</div>
						</div>
					</div>
				</section>

				<div class="l-wrapper">
					<div class="b-main__banner b-main-banner">
						<img src="<?=SITE_TEMPLATE_PATH?>/img/main/banner@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/main/banner@2x.png 2x" alt="СОПТ-Комплект Might of Energy" width="1170" height="400">
					</div>
				</div>

			<? endif ?>
			
			<? if (!$FL_CATALOG && !$FL_SOLUTIONS): ?>
				<div class="l-wrapper">
			<? endif;?>


				<? if (!$FL_MAIN && !$FL_CATALOG && !$FL_SOLUTIONS): ?>
					<div class="b-page-title">
						<? include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/breadcrumb.php"); ?>
						<h1><? $APPLICATION->ShowTitle(false) ?></h1>
					</div>
				<? endif ?>

