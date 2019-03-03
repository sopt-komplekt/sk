<?
	// Шаблон меню каталога, отображает правильную html структуру с дополнительными классами.
	// Может выводится как развернутым до указанного уровня, так и с подразделами активной рубрики.

	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

	if(empty($arResult["SECTIONS"])) return false; 
	
	if($arParams['SEF_MODE'] == 'Y')
	{
		$SECTION_ID = intval($arParams['VARIABLES']['SECTION_ID']);
	}
	else {
		$SECTION_ID = $_REQUEST['SECTION_ID'];
	}

	if($arParams["ACTIVE_SUBSECTION"] == 'Y')
	{
		// получаем все активные разделы
		$arResult['_SECTIONS'] = array();
		foreach($arResult["SECTIONS"] as $arSection){
			$arResult['_SECTIONS'][$arSection['ID']] = $arSection;
		}
		
		$active_id = $SECTION_ID;
		$ACTIVE_SECTIONS = array();
		while($active_id){
			if($active_id) $ACTIVE_SECTIONS[] = $active_id;
			$active_id = $arResult['_SECTIONS'][$active_id]['IBLOCK_SECTION_ID']; // родительская рубрика	
		}
	}

	// Показываем название первой не корневой категории 
	if (is_array($arResult['SECTION']['PATH']) && count($arResult['SECTION']['PATH']) > 0 && !empty($arResult['SECTION']['PATH'][0]['NAME'])) {
		$firstSectionName = $arResult['SECTION']['PATH'][0]['NAME'];
	} else {
		$firstSectionName = !empty($arResult['SECTION']['NAME']) ? $arResult['SECTION']['NAME'] : 'Каталог';
	}
?>
<div class="b-section-list">
	<div class="b-section-list_title">
		<?= $firstSectionName; ?>
	</div>

	<ul class="ul-deep-1">
		<?
		foreach($arResult["SECTIONS"] as $key => $arSection):
			
			$CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
		
			if($arParams["ACTIVE_SUBSECTION"] == 'Y')
			{
				$NEXT_DEPTH = 1;
				$i = $key;
				while ($i < count($arResult["SECTIONS"])) {
					$i++;
					if(in_array($arResult["SECTIONS"][$i]['IBLOCK_SECTION_ID'], $ACTIVE_SECTIONS)){
						$NEXT_DEPTH = $arResult["SECTIONS"][$i]["DEPTH_LEVEL"];
						break;
					}
				}
			}
			else {
				$NEXT_DEPTH = $arResult["SECTIONS"][$key+1]["DEPTH_LEVEL"];
			}

			// если уровень вложености больше чем 1 и мы находимся в этом разделе
			if($arParams["ACTIVE_SUBSECTION"] != 'Y' || ($CURRENT_DEPTH == 1 || ($CURRENT_DEPTH > 1 && in_array($arSection['IBLOCK_SECTION_ID'], $ACTIVE_SECTIONS)))): 

			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
		?>
			<? 
				
			?>
				<li id="<?=$this->GetEditAreaId($arSection['ID']);?>" class="li-deep-<?=$CURRENT_DEPTH?> li-item-<?=$arSection['ID']?><? if($arSection['ID'] == $SECTION_ID): ?> active<? endif; ?>">
					<a class="a-deep-<?=$CURRENT_DEPTH?><? if($arSection['ID'] == $SECTION_ID): ?> active<? endif; ?>" href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a>
					<?
						if($NEXT_DEPTH && ($CURRENT_DEPTH < $NEXT_DEPTH) && ($arParams["ACTIVE_SUBSECTION"] != 'Y' || in_array($arResult["SECTIONS"][$key+1]['IBLOCK_SECTION_ID'], $ACTIVE_SECTIONS))){
							echo '<ul class="ul-deep-'.$NEXT_DEPTH.'">';
						}
						elseif (($NEXT_DEPTH && ($CURRENT_DEPTH > $NEXT_DEPTH)) || (!$NEXT_DEPTH && ($CURRENT_DEPTH > 1))) {
							echo '</li></ul></li>';
							$NUM_DIFF = $NEXT_DEPTH ? $CURRENT_DEPTH - $NEXT_DEPTH :  $CURRENT_DEPTH - 1;
							if($NUM_DIFF > 1)
							{
								for ($i=0; $i<$NUM_DIFF-1; $i++) { 
									echo '</ul></li>';
								}
							}
						}
						else {
							echo '</li>';
						}
					?>
			<? endif; ?>
		<?endforeach?>
	</ul>
</div>

<? //dump($arParams["ACTIVE_SUBSECTION"]); ?> 
