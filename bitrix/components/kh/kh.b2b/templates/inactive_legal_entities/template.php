<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 06.03.2019
 * Time: 19:08
 */
?>
    <?if(is_array($arResult["INACTIVE_LEGAL_ENTITIES"]) && count($arResult["INACTIVE_LEGAL_ENTITIES"]>0)):?>
        <div id="accordion">
        <?$division = true;
        foreach($arResult["INACTIVE_LEGAL_ENTITIES"] as $item):?>
            <?if($division !== $item["CONNECTED_PERSON_ID"]):?>
                <br>
                <h5><?=GetMessage('LEGAL_ENTITIES_OF')?>: <?=$item["CONNECTED_PERSON"]?></h5>
                <br>
                <?$division = $item["CONNECTED_PERSON_ID"];?>
            <?endif;?>

                <div class="card">
                    <div class="card-header">
                        <a class="card-link" data-toggle="collapse" href="#INN_<?=$item['UF_INN']?>">
                            <?=str_replace('&amp;quot;', '"', $item['WORK_COMPANY'])?> (<?=GetMessage('INN')?>: <?=$item["UF_INN"]?>)
                        </a>
                    </div>
                    <div id="INN_<?=$item['UF_INN']?>" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <p><b><?=GetMessage('INN')?>/<?=GetMessage('KPP')?>:</b> <?=$item['UF_INN']?>/<?=$item['UF_KPP']?></p>
                            <p><b><?=GetMessage('PH_ADDRESS')?>:</b> <?=implode(", ", [$item['PERSONAL_ZIP'], $item['PERSONAL_CITY'], $item['PERSONAL_STREET']])?></p>
                            <p><b><?=GetMessage('YU_ADDRESS')?>:</b> <?=$item['WORK_ZIP']?>, <?=$item['WORK_CITY']?>, <?=$item['WORK_STREET']?></p>
                            <p><b><?=GetMessage('CONTACT_PERSONE')?>:</b> <?=$item['LAST_NAME']?> <?=$item['NAME']?></p>
                            <p><b><?=GetMessage('CONTACT_EMAIL')?>:</b> <?=$item['EMAIL']?></p>
                            <p><b><?=GetMessage('CONTACT_PHONE')?>:</b> <?=$item['PERSONAL_PHONE']?></p>
                        </div>
                        <div class="activate_user">
                            <div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value='<?=$arResult["GROUP_OF_LEGAL_ENTITIES"]["PARTNER"]?>' name="soglashenie_<?=$item['UF_INN']?>"><?=GetMessage('PARTNER')?>
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value='<?=$arResult["GROUP_OF_LEGAL_ENTITIES"]["DILER"]?>' name="soglashenie_<?=$item['UF_INN']?>"><?=GetMessage('DILER')?>
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value='<?=$arResult["GROUP_OF_LEGAL_ENTITIES"]["MRC"]?>' name="soglashenie_<?=$item['UF_INN']?>"><?=GetMessage('MRC')?>
                                    </label>
                                </div>
                            </div>
                            <span data-inn="<?=$item['UF_INN']?>" data-activate="<?=$item['ID']?>"><?=GetMessage('ACTIVATE')?></span>
                        </div>
                    </div>
                </div>
            <div id="soglashenie_error_div"></div>
            <?endforeach;?>
        </div>
    <?else:?>
        <?=GetMessage('NO_INACTIVE_LEGAL_ENTITIES')?>
<?endif;?>




