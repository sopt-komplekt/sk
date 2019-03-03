<? 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 
$this->setFrameMode(true);

if (is_array($arResult["SECTION"]))
	$arSection = $arResult["SECTION"];

if (is_array($arResult["SECTIONS"]) && count($arResult["SECTIONS"]) > 0)
	$arSections = $arResult["SECTIONS"];
?>

<? 
	if (is_array($arSection)):

	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CATALOG_SECTION_DELETE_CONFIRM')));	
?>
	<div class="b-catalog-section b-ssbi-<?=$arSection['ID']?>" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
	
		<div class="b-catalog-section__pic">
			<? if($arSection['PREVIEW_PICTURE']['SRC']): ?>
				<a href="<?=$arSection["SECTION_PAGE_URL"]?>">
					<img src="<?=$arSection['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arSection['NAME']?>" width="<?=$arSection['PREVIEW_PICTURE']['WIDTH']?>" height="<?=$arSection['PREVIEW_PICTURE']['HEIGHT']?>">
				</a>
			<? endif; ?>
		</div>

		<div class="b-catalog-section__title">
			<a class="g-decorated-link" href="<?=$arSection["SECTION_PAGE_URL"]?>">
				<span><?=$arSection["NAME"]?></span>
			</a>
		</div>

		<ul class="b-catalog-section__list">
			<? if (is_array($arSections)): ?>
				<?
					foreach ($arSections as $key => $arChild): 

					$this->AddEditAction($arChild['ID'], $arChild['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT"));
					$this->AddDeleteAction($arChild['ID'], $arChild['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CATALOG_SECTION_DELETE_CONFIRM')));	
				?>

					<li class="b-catalog-section__item" id="<?=$this->GetEditAreaId($arChild['ID']);?>">
						<a class="g-decorated-link" href="<?=$arSection["SECTION_PAGE_URL"]?>">
							<span><?= empty($arChild["UF_SHORT_NAME"]) ? $arChild["NAME"] : $arChild["~UF_SHORT_NAME"] ?></span>
						</a>
					</li>
					
				<? endforeach; ?>
			<? endif; ?>
		</ul>


	
		
	</div>

<? endif; ?>