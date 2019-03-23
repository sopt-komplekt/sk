			<? if (!$FL_CATALOG && !$FL_SOLUTIONS): ?>
				</div>
			<? endif;?>
		</main>
		<footer class="l-page__footer b-footer">
			<div class="b-footer__top">
				<div class="l-wrapper">

					<div class="b-footer__main">
						<div class="b-footer__logo">
							<img src="<?=SITE_TEMPLATE_PATH?>/img/footer/logo@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/footer/logo@2x.png 2x" alt="Сопт-Комплект" width="132" height="60">
						</div>
						<div class="b-footer__phone">
							<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/phone.php",Array(),Array("MODE"=>"html")); ?>
						</div>
						<div class="b-footer__search">
							<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/footer/search.php"); ?>
						</div>
						<div class="b-footer__personal">

							<a class="g-decorated-link" href="/personal/<?=(!$USER->IsAuthorized())?'private/':''?>">
								<span>Личный кабинет</span>
							</a>
						</div>
					</div>

					<div class="b-footer__navs">
						<div class="b-footer__menu b-footer__menu--catalog">
							<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/footer/catalog.php"); ?>
						</div>
						<div class="b-footer__menu b-footer__menu--bottom">
							<? include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/include/footer/menu.php"); ?>
						</div>
					</div>

					<div class="b-footer__payments">
						<img src="<?=SITE_TEMPLATE_PATH?>/img/footer/visa@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/footer/visa@2x.png 2x" alt="Visa" width="54" height="18">
						<img src="<?=SITE_TEMPLATE_PATH?>/img/footer/master-card@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/footer/master-card@2x.png 2x" alt="Master Card" width="32" height="19">
						<img src="<?=SITE_TEMPLATE_PATH?>/img/footer/mir@1x.png" srcset="<?=SITE_TEMPLATE_PATH?>/img/footer/mir@2x.png 2x" alt="Mir" width="62" height="18">
					</div>
					
				</div>
			</div>
			<div class="b-footer__bottom">
				<div class="l-wrapper b-footer__wrapper">
					<div class="b-personal-data">
						<? $APPLICATION->IncludeFile(SITE_DIR.SITE_TEMPLATE_PATH."/include/personal-data-policy.php",Array(),Array("MODE"=>"html")); ?>
					</div>

					<div class="b-media-army">
						Создание сайта — 
						<a title="Создание и продвижение сайтов и интернет-магазинов" target="_blank" href="https://media-army.ru">
							Media Army
							<svg class="b-media-army-star" width="10" height="10" viewbox="0 0 240 240">
								<path d="m48,234 73-226 73,226-192-140h238z"></path>
							</svg>
						</a>
					</div>
				</div>
			</div>
		</footer>
	</div>

	<? 
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/lib/owl.carousel.js");
		Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/main.js");
	?>

	</body>
</html>