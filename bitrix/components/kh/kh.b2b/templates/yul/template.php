<?
$this->setFrameMode(true);
if(is_array($arResult["YU_L"]) && count($arResult["YU_L"])):
    foreach($arResult["YU_L"] as $item):?>
        <p class="user-yul__yul-item-head"><?=$item['WORK_COMPANY']?></p>
<?
endforeach;
endif;
?>


