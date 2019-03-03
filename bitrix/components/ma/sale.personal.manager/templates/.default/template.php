<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

$this->setFrameMode(false); 
?>
<? if (is_array($arResult)): ?>
	<aside class="b-personal-manager">
		<h2 class="b-personal-manager-title">
			<i class="b-personal-manager-ico"></i>
			Ваш личный менеджер
		</h2>
		<div class="b-personal-manager-wrapper">
			<div class="b-personal-manager-item">
				<div class="b-personal-manager-image">
					<img src="<? echo $arResult["PREVIEW_PICTURE"]["SRC"]?>" alt="<? echo$arResult["NAME"] ?>">
				</div>
				<div class="b-personal-manager-name">
					<span>Ваш менеджер</span>
					<b><? echo $arResult["NAME"] ?></b>
				</div>
				<? if (!empty($arParams['PATH_TO_MESSAGE_FORM']) || !empty($arParams['PATH_TO_ORDER_CALL_FORM'])): ?>
					<div class="b-personal-manager-actions">
						<? if (!empty($arParams['PATH_TO_MESSAGE_FORM'])):?>
							<a class="b-personal-manager-button b-personal-manager-button-highlight g-ajax-data" href="<?=$arParams['PATH_TO_MESSAGE_FORM']?>">Написать</a>
						<? endif; ?>
						<? if(!empty($arParams['PATH_TO_ORDER_CALL_FORM'])): ?>
							<a class="b-personal-manager-button g-ajax-data" href="<?=$arParams['PATH_TO_ORDER_CALL_FORM']?>">Заказать звонок</a>
						<? endif; ?>
					</div>
				<? endif; ?>
				
				<? if ($arParams["DISPLAY_CONTACTS"] === "Y" && is_array($arResult["CONTACTS"])): ?>
					<div class="b-personal-manager-contacts">
						<ul>
							<? foreach ($arResult["CONTACTS"] as $val):?>
								<li><a class="b-personal-manager-<? echo strtolower($val["TYPE"])?>" href="<? echo $val["HREF"]?>"><? echo $val["VALUE"]?></a></li>
							<? endforeach; ?>
						</ul>
					</div>
				<? endif; ?>
			</div>
		</div>
	</aside>
<? endif; ?>