<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 

$this->setFrameMode(true);
?>
<? if (count($arResult["SECTIONS"]) > 0): ?>

	<div class="b-catalog-sections__list owl-carousel owl-theme jsCatalogSectionSlider">
		<? 
			foreach($arResult['SECTIONS'] as $arSection):
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT"));
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CATALOG_SECTION_DELETE_CONFIRM')));	
		?>
			<div class="b-catalog-sections__item b-ssbi-<?=$arSection['ID']?>" id="<?=$this->GetEditAreaId($arSection['ID']);?>">

				<div class="b-catalog-sections__holder">
				
					<? if($arSection['PREVIEW_PICTURE']['SRC']): ?>
						<? $src = $arSection['PREVIEW_PICTURE']['SRC']; ?>
					<? else: ?>
						<? $src = $templateFolder."/img/no-image_220x170.png"; ?>
					<? endif; ?>

					<div class="b-catalog-sections__image">
						<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><img src="<?= $src?>" alt="<?=$arSection["NAME"]?>"></a>
					</div>
					
					<div class="b-catalog-sections__text">
						<? if($arSection['NAME'] && $arResult['SECTION']['ID'] != $arSection['ID']): ?>
							<div class="b-catalog-sections__name">
								<a class="g-decorated-link" href="<?=$arSection["SECTION_PAGE_URL"]?>">
									<span><?=$arSection["NAME"]?></span>
								</a>
							</div>
						<? endif; ?>
						<div class="b-catalog-sections__more">
							<a class="g-button" href="<?=$arSection["LIST_PAGE_URL"]?>">Каталог</a>
						</div>
					</div>

				</div>
				
			</div>
		<? endforeach; ?>
	</div>

<? endif; ?>