<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<? if (count($arResult["SECTIONS"]) > 0): ?>

	<div class="b-catalog-section-blocks">
		<?
		foreach($arResult['SECTIONS'] as $arSection):
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT"));
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CATALOG_SECTION_DELETE_CONFIRM')));	
		?>
			<div class="b-catalog-section-blocks_item b-ssbi-<?=$arSection['ID']?>" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
				
				<div class="b-catalog-section-blocks_holder" style="width: <?=($arParams["DISPLAY_IMG_WIDTH"]+6)?>px">
					<? if($arSection['PREVIEW_PICTURE']['SRC']): ?>
						<div class="b-catalog-section-blocks_image">
							<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><img src="<?=$arSection['PREVIEW_PICTURE']['SRC']?>" alt="" /></a>
						</div>
					<? else: ?>
						<div class="b-catalog-section-blocks_no-image">
							<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a>
						</div>
					<? endif; ?>
					<div class="b-catalog-section-blocks_text">
						<? if($arSection['NAME'] && $arResult['SECTION']['ID'] != $arSection['ID']): ?>
							<div class="b-catalog-section-blocks_name">
								<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a>
							</div>
						<? endif; ?>
						<? if ($arSection['DESCRIPTION']): ?>
							<div class="b-catalog-section-blocks_description">
								<?=$arSection['DESCRIPTION_TYPE'] == 'text' ? $arSection['DESCRIPTION'] : $arSection['~DESCRIPTION']?>
							</div>
						<? endif; ?>
					</div>
				</div>		
				
			</div>
			
		<? endforeach; ?>
	</div>

<? endif; ?>