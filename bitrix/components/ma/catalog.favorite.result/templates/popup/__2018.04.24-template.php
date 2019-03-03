<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>

<style>
.b-mod-title {
    display: none !important;
}

.b-content-ajax,
.m-box-modal {
    padding: 0 !important;
}

.b-added-item {
    max-width: 550px;
    padding: 20px 30px 25px 25px;
    background-color: #fff;
}

.b-added-item_holder {
	overflow: hidden;
}

.b-added-item_title.h2 {
	margin: 0 0 15px;
	font-size: 22px;
}

.b-added-item_pic {
    float: left;
    width: 112px;
    margin-top: 5px;
    margin-right: 20px;
    text-align: center;
    border: 1px solid #d2d2d2;
}

.b-added-item_text {
    font-size: 16px;
    line-height: 1.5;
    overflow: hidden;
}

.b-added-item_name {
    margin-bottom: 10px;
}

.b-added-item_info {
    margin-bottom: 15px;
    color: #5f5f5f;
}
    
.b-added-item_buttons .g-button {
    margin-right: 15px !important;
}

.b-added-item_buttons .g-close {
    font-size: 16px;
    color: #5f5f5f;
}
</style>

<?	
	$ELEMENT_ID = $_REQUEST['id'];

	if(is_array($arResult["ITEMS"]) && !empty($ELEMENT_ID)){
		foreach ($arResult["ITEMS"] as $key => $arItem) {
			if ($arItem['ID'] == $ELEMENT_ID) {
				$arResultElement = $arItem;
				break;
			}
		}
	}

?>

<div class="b-added-item">
	<div class="b-added-item_title h2">
		<?=GetMessage("MA_CATALOG_FAVORITE_RESULT_ADD")?>
	</div>
	<div class="b-added-item_holder">
		<? if(is_array($arResultElement['DETAIL_PICTURE'])): ?>
			<div class="b-added-item_pic">
				<img src="<?=$arResultElement['DETAIL_PICTURE']['SRC']?>" alt="<?=$arResultElement['NAME']?>">
			</div>
		<? endif; ?>
		<div class="b-added-item_text">
			<div class="b-added-item_name">
				<?=$arResultElement['NAME']?>
			</div>
			<div class="b-added-item_info">
				<?=GetMessage("MA_CATALOG_FAVORITE_RESULT_COUNT")?> <?=count($arResult["ITEMS"])?> <?=getWordEnding(count($arResult["ITEMS"]), array('товар', 'товара', 'товаров'))?>
			</div>
			<div class="b-added-item_buttons">
				<a href="<?=$arParams['FAVORITE_URL']?>" class="g-button"><?=GetMessage("MA_CATALOG_FAVORITE_RESULT_GET")?></a>
				<a href="javascript:void(0)" class="g-close arcticmodal-close"><?=GetMessage("MA_CATALOG_FAVORITE_RESULT_CONTINUE")?></a>
			</div>
		</div>
	</div>
</div>