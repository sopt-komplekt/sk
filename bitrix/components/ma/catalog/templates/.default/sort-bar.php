<?
    /* 
        Панель пользовательской сортировки
    */
?>
<? if($arParams['USE_SECTION_SORT'] == "Y"): ?>
    <? 
    $APPLICATION->SetAdditionalCSS($templateFolder.'/css/sort-bar.css');

    if ('section' == $this->GetPageName()) { 
        CModule::IncludeModule('catalog'); 
            $dbRes = CCatalogGroup::GetList( 
            array(), array('NAME' => $arParams['PRICE_CODE'][0]) 
        ); 
    
        if ($arRes = $dbRes->Fetch()) 
            $arResult['_PRICE_ID'] = $arRes['ID']; 
    } 
    
    $arAvailableSort = array(
    	"name" => Array("name", "asc"), 
    	"price" => Array('catalog_PRICE_'.$arResult['_PRICE_ID'], "asc"),
    	"shows" => Array('shows', "desc"),
    	"id" => Array('ID', "desc"),
    );
    $sort = array_key_exists("sort", $_REQUEST) && array_key_exists(ToLower($_REQUEST["sort"]), $arAvailableSort) ? $arAvailableSort[ToLower($_REQUEST["sort"])][0] : 'CATALOG_AVAILABLE';
    $sort_order = array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ? ToLower($_REQUEST["order"]) : $arAvailableSort[$sort][1];	
    
    if($_REQUEST['sectview'] == 'blocks' || $_REQUEST['sectview'] == 'table'){
	   $_SESSION['SECTION_VIEW'] = $_REQUEST['sectview'];
	}
	if(empty($_SESSION['SECTION_VIEW'])){
		$catalog_section_view = 'blocks';
	}
	else {
		$catalog_section_view = $_SESSION['SECTION_VIEW'];
	}
    
    if($_REQUEST['count'] == 25 || $_REQUEST['count'] == 50 || $_REQUEST['count'] == 75 || $_REQUEST['count'] == 100 || $_REQUEST['count'] == 1000){
       $_SESSION['PAGE_ELEMENT_COUNT'] = $_REQUEST['count'];
    }
    if(empty($_SESSION['PAGE_ELEMENT_COUNT'])){
    	$PAGE_ELEMENT_COUNT = 25;
    }
    else {
    	$PAGE_ELEMENT_COUNT = $_SESSION['PAGE_ELEMENT_COUNT'];
    }
    
    ?>
    
    <!--noindex-->
    <div class="b-catalog-elements-display">
    	<div class="b-catalog-item-sorting">
    		<span><?=GetMessage('SECT_SORT_LABEL')?>:</span>
    		<?
    			foreach ($arAvailableSort as $key => $val):
    			$className = $sort == $val[0] ? 'selected' : '';
    			if ($className) 
    				$className .= $sort_order == 'asc' ? ' asc' : ' desc';
    			$newSort = $sort == $val[0] ? $sort_order == 'desc' ? 'asc' : 'desc' : $arAvailableSort[$key][1];
    		?>
    		<a href="<?=$APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order'))?>" class="<?=$className?>" rel="nofollow"><?=GetMessage('SECT_SORT_'.$key)?></a>
    		<? endforeach; ?>
    	</div>
        
        <? if($arParams['USE_SECTION_SORT_VIEW'] == "Y"): ?>
        
        <div class="b-catalog-elements-view">
			<span><?=GetMessage('SECT_VIEW_LABEL')?>:</span>
			<a href="<?=$APPLICATION->GetCurPageParam('sectview=table', array('sectview'))?>" class="b-catalog-elements-view_table<? if($catalog_section_view == 'table'): ?> b-catalog-elements-view_table_selected selected<? endif; ?> g-ico" rel="nofollow"><?=GetMessage('VIEW_TABLE')?></a>
			<a href="<?=$APPLICATION->GetCurPageParam('sectview=blocks', array('sectview'))?>" class="b-catalog-elements-view_blocks<? if($catalog_section_view == 'blocks'): ?> b-catalog-elements-view_blocks_selected selected<? endif; ?> g-ico" rel="nofollow"><?=GetMessage('VIEW_BLOCKS')?></a>
		</div>
        
        <? endif; ?>
        
    	<div class="b-catalog-elements-count">
    		<span><?=GetMessage('SECT_COUNT')?>:</span>
    		<div class="b-catalog-elements-count_holder" id="i-catalog-elements-count-holder">
                <select onchange="window.location.href=this.value">
                
                    <option value="<?=$APPLICATION->GetCurPageParam('count=25', array('count'))?>" <? if($PAGE_ELEMENT_COUNT == 25): ?>selected="selected"<? endif; ?>>25 <?=GetMessage('SECT_UNITS')?></option>
                    <option value="<?=$APPLICATION->GetCurPageParam('count=50', array('count'))?>" <? if($PAGE_ELEMENT_COUNT == 50): ?>selected="selected"<? endif; ?>>50 <?=GetMessage('SECT_UNITS')?></option>
                    <option value="<?=$APPLICATION->GetCurPageParam('count=75', array('count'))?>" <? if($PAGE_ELEMENT_COUNT == 75): ?>selected="selected"<? endif; ?>>75 <?=GetMessage('SECT_UNITS')?></option>
                    <option value="<?=$APPLICATION->GetCurPageParam('count=100', array('count'))?>" <? if($PAGE_ELEMENT_COUNT == 100): ?>selected="selected"<? endif; ?>>100 <?=GetMessage('SECT_UNITS')?></option>
                    <option value="<?=$APPLICATION->GetCurPageParam('count=1000', array('count'))?>" <? if($PAGE_ELEMENT_COUNT == 1000): ?>selected="selected"<? endif; ?>><?=GetMessage('ALL')?></option>
                
                </select>
    		</div>
    	</div>
    </div>
    <!--/noindex-->
    
    <?
    
        if ($sort) {
        	$arParams["ELEMENT_SORT_FIELD"] = $sort;
        }
        if ($sort_order) {
        	$arParams["ELEMENT_SORT_ORDER"] = $sort_order;
        }
        $arParams['ELEMENT_LIST_TEMPLATE'] = ($arParams['USE_SECTION_SORT_VIEW'] == "Y" ? $catalog_section_view : $arParams['ELEMENT_LIST_TEMPLATE']);
        $arParams["PAGE_ELEMENT_COUNT"] = $PAGE_ELEMENT_COUNT;
    
    ?>

<? endif; ?>