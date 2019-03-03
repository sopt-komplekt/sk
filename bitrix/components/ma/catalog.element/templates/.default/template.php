<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<div class="b-catalog-detail">
	<? if(is_array($arResult['DETAIL_PICTURE']) || is_array($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'])): ?>
		<div class="b-catalog-detail_holder-pic">
			<? if(is_array($arResult['DETAIL_PICTURE'])): ?>
				<div class="b-catalog-detail_detail-pic">
					<a class="g-fancybox" rel="fancybox-pic" href="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
                        <img
                            src="<?=$arResult['DETAIL_PICTURE']['SRC']?>"
                            alt="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]?>"
                            title="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]?>"
                        />
                    </a>
				</div>
			<? endif; ?>
			<? if(is_array($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE']) && count($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE']) > 0): ?>
				<div class="b-catalog-detail_more-pic">
				<? foreach($arResult['PROPERTIES'][$arParams['ADD_PICT_PROP']]['VALUE'] as $arItem):?>
					<div class="b-catalog-detail_more-pic_item">
						<a class="g-fancybox" rel="fancybox-pic" href="<?=$arItem['DETAIL_PICTURE']['SRC']?>">
                            <img
                                src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"
                                alt="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]?>"
                                title="<?=$arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]?>"
                                />
                        </a>
					</div>
				<? endforeach; ?>
				</div>
			<? endif; ?>
		</div>
        <?php if ($arParams['DETAIL_PICTURE_MODE'] == "POPUP"): ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('a.g-fancybox').fancybox();
                });
            </script>

        <?php endif ?>		
        
    <? else: ?>
    
        <div class="b-catalog-detail_holder-no_pic_wrap">
    
            <div class="b-catalog-detail_holder-no_pic"></div>
        
        </div>
        
	<? endif; ?>
    
    <? if($arResult['CATALOG_QUANTITY_TRACE'] == 'Y'): ?> 
        <div class="b-catalog-detail-availability">
            <? if($arResult['CATALOG_QUANTITY'] > 0): ?> 
                <?=GetMessage("CATALOG_AVAILABLE");?> <?=$arResult['CATALOG_QUANTITY']; ?> <?=$arResult['CATALOG_MEASURE_NAME']; ?>.)
            <? else: ?>
                <?=GetMessage("CATALOG_NOT_AVAILABLE"); ?>.
            <? endif; ?>
        </div>
    <? endif; ?>	

	<div class="b-mod-catalog-detail_supply">
        <?
            foreach ($arResult['PRICES'] as $code => $arPrice) {
                if ($arPrice['CAN_ACCESS']) {
                    if ($arPrice['DISCOUNT_VALUE'] < $arPrice['VALUE']) {
                        $curPrice = $arPrice['PRINT_DISCOUNT_VALUE'];
                        $oldPrice = $arPrice['PRINT_VALUE'];
                    } else {
                        $curPrice = $arPrice['PRINT_VALUE'];
                        $oldPrice = false;
                    }
                }
            }
        ?>        
        <div class="b-catalog-detail-price">
            <span class="b-cur_price">
                <?php if ($curPrice): ?>
                    <?php echo $curPrice; ?>
                <?php else: ?>
                    <span class="not_price"><?=GetMessage("NOT_PRICE")?></span>
                <?php endif ?>
            </span>
            
            <? if($arResult["CAN_BUY"]): ?>
                <!--noindex-->
				<a class="g-button g-add-cart g-ajax-data" href="<?=$arResult["ADD_TO_BASKET_URL"]?>" rel="nofollow" id="catalog_add2cart_link">
                    <?=GetMessage("CATALOG_ADD_TO_BASKET")?>
                </a>
                <!--/noindex-->
			<? endif; ?>
            
            <? if(!$arResult["CAN_BUY"] && (count($arResult["PRICES"]) > 0)): ?>
				<?=GetMessage("CATALOG_NOT_AVAILABLE");?>
			<? endif; ?>

            <? if ($arParams["USE_COMPARE"] == "Y"): ?>
                <a class="g-ajax-data" href="<?=$arResult["ADD_TO_COMPARE_URL"]?>"><?=GetMessage("CATALOG_COMPARE")?></a>
            <? endif; ?>

            <? if ($arParams["USE_FAVORITE"] == "Y"): ?>
                <a class="g-ajax-data" href="<?=$arResult["ADD_TO_FAVORITE_URL"]?>"><?=GetMessage("CATALOG_FAVORITE")?></a>
            <? endif; ?>

        </div>
        
        <? if($oldPrice): ?>
            <div class="b-catalog-detail-old_price">
                <?=GetMessage("OLD_PRICE"); ?> <span class="b-old_price"><?=$oldPrice; ?></span>        
            </div>
        <? endif; ?>
	</div>

	
	<div class="b-catalog-detail_holder-prop">
		<? if (is_array($arResult['DISPLAY_PROPERTIES']) && count($arResult['DISPLAY_PROPERTIES']) > 0): ?>
			<div class="b-catalog-detail_properties">
				<? foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty): ?>
					<div class="b-catalog-detail_properties_item">
						<span class="b-catalog-detail_properties_item_title"><?=$arProperty["NAME"]?>:</span>
						<span class="b-catalog-detail_properties_item_value">
							<? if(is_array($arProperty["DISPLAY_VALUE"])): ?>
								<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
							<? elseif($pid=="MANUAL"): ?>
								<a href="<?=$arProperty["VALUE"]?>"><?=GetMessage("CATALOG_DOWNLOAD")?></a>
							<? else: ?>
								<?=$arProperty["DISPLAY_VALUE"]; ?>
							<? endif; ?>
						</span>
					</div>
				<? endforeach; ?>
			</div>
		<? endif; ?>
	</div>
    
    <? if($arResult["PREVIEW_TEXT"]): ?>
		<div class="b-catalog-detail_preview-text">
			<?=$arResult["PREVIEW_TEXT"];?>
		</div>
	<? endif; ?>
    
    <div class="g-clean"></div>

	<? if($arResult["DETAIL_TEXT"]): ?>
		<div class="b-catalog-detail_detail-text">
			<?=$arResult["DETAIL_TEXT"];?>
		</div>
	<? endif; ?>
    

    <?php if (!empty($arResult['COMMENTS'])): ?>
        <div class="b-catalog-detail-comments">
            <?=$arResult['COMMENTS']; ?>
        </div>
    <?php endif ?>        
	<div class="g-clean"></div>
</div>