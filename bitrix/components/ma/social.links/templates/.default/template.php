<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();
$this->setFrameMode(true);
?>
<? if (is_array($arResult["SOCSERV"]) && !empty($arResult["SOCSERV"])): ?>
	<div class="b-socials">
		<div class="b-socials__title"><?=GetMessage("MA_SOCIAL_LINKS_TITLE")?></div>
		<div class="b-socials__items">
			<?foreach($arResult["SOCSERV"] as $socserv):?>
				<a class="b-socials__link <?=$socserv["CLASS"]?>" href="<?=htmlspecialcharsbx($socserv["LINK"])?>" target="_blank" rel="nofollow">
					<img src="<?=$templateFolder?>/img/<?=$socserv["CLASS"]?>.png" alt="">
				</a>
			<?endforeach?>
		</div>
	</div>
<? endif; ?>