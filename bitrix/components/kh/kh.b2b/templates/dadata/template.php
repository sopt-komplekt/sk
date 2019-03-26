<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 06.03.2019
 * Time: 19:08
 */
$this->setFrameMode(true);
global $USER;
?>

<?if(empty($arResult["USERS_LINKS"][0])):?>
<div id="container_kh_b2b">
    <? $frame = $this->createFrame()->begin(""); ?>
    <div class="row">
        <div class="col-sm-12">
            <br/>
            <div class="form-group">
                <div class="col-sm-12">
                    <div id="inn_to_check_errors"></div>
                    <input type="text" class="form-control" placeholder="<?=GetMessage('INN_TO_CHECK')?>" id="INN_TO_CHECK"/>
                </div>
                <div class="col-sm-12" id="inn_to_check">
                     <span><?=GetMessage('CHECK_INN_BUTTON')?></span>
                </div>
            </div>
        </div>

    </div>

    <div class="container-fluid <?=($arParams["AJAX"] && $arResult['newUserCreated'] != "Y")? '' : 'collapse'?>" style="border:1px dotted #ccc;" id="new_yulick">
        <form id="new_yulick_form"  action="" class="form-horizontal">
            <input type="hidden" name="UF_USERS_LINKS" value="<?=$USER->GetID()?>">
            <div >
                <div class="row">
                    <div class="col-sm-12">
                        <br/>
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('COMPANY_NAME')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['WORK_COMPANY']?>" class="form-control" name="WORK_COMPANY" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <br/>
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('GENERAL_DIRECTOR')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['UF_GENERAL_DIRECTOR']?>" class="form-control" name="UF_GENERAL_DIRECTOR"/>
                            </div>
                        </div>
                    </div>
                </div>
                <h5><?=GetMessage('YU_ADDRESS')?></h5>
                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('CITY_NAME')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['WORK_CITY']?>" class="form-control" name="WORK_CITY" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('STREET_HOUSE')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['WORK_STREET']?>" class="form-control" name="WORK_STREET" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('ZIP_CODE')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['WORK_ZIP']?>" class="form-control" name="WORK_ZIP"/>
                            </div>
                        </div>
                    </div>
                </div>
                <h5><?=GetMessage('PH_ADDRESS')?></h5>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('CITY_NAME')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['PERSONAL_CITY']?>" class="form-control" name="PERSONAL_CITY" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('STREET_HOUSE')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['PERSONAL_STREET']?>" class="form-control" name="PERSONAL_STREET" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('ZIP_CODE')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['PERSONAL_ZIP']?>" class="form-control" name="PERSONAL_ZIP"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <br/>
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('INN')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['UF_INN']?>" class="form-control" name="UF_INN" pattern="[0-9]{10}" required readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <br/>
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('KPP')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['UF_KPP']?>" class="form-control" name="UF_KPP" pattern="[0-9]{9}" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <h5><?=GetMessage('CONTACT_PERSONE')?></h5>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('NAME')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['CURRENT_USER']['NAME']?>" class="form-control" name="NAME"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('LAST_NAME')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['CURRENT_USER']['LAST_NAME']?>" class="form-control" name="LAST_NAME"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('EMAIL')?></label>
                            <div class="col-sm-12">
                                <input type="text" value="<?=$arResult['USER']['EMAIL']?>" class="form-control" name="EMAIL" pattern="([A-z0-9_.-]{1,})@([A-z0-9_.-]{1,}).([A-z]{2,8})" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-6" for="count_num"><?=GetMessage('PERSONAL_PHONE')?></label>
                            <div class="col-sm-12">
                                <input type="text" id="phone" value="<?=$arResult['USER']['PERSONAL_PHONE']?>" class="form-control" name="PERSONAL_PHONE"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <button class="new_yulick_button"><?=GetMessage('SUBMIT')?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>
    <?if($arResult['newUserCreated'] != "Y"):?>
        <p class="text-red"><?=$arResult['newUserCreated']?></p>
    <?endif;?>

    <? $frame->end(); ?>
    <?
    if(is_array($arResult["YU_L"]) && !empty($arResult["YU_L"][0])):
        foreach($arResult["YU_L"] as $item):
            ?>
            <div id="accordion">
                <div class="card">
                    <div class="card-header">
                        <a class="card-link" data-toggle="collapse" href="#INN_<?=$item['UF_INN']?>">
                            <?=$item['WORK_COMPANY']?> (<?=GetMessage('INN')?>: <?=$item["UF_INN"]?>)
                        </a>
                        <a title="<?=GetMessage('AUTHORIZE')?>" class="user-yul_accordion_authorize" href="/personal/authorize.php?lang=ru&ID=<?=$item['ID']?>&action=authorize&<?=bitrix_sessid_get('sessid')?>">
                            <?=GetMessage('AUTHORIZE')?>
                        </a>
                        <span  data-yulid=""></span>
                    </div>
                    <div id="INN_<?=$item['UF_INN']?>" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <p><b><?=GetMessage('GENERAL_DIRECTOR')?>:</b> <?=$item['UF_GENERAL_DIRECTOR']?></p>
                             <p><b><?=GetMessage('INN')?>/<?=GetMessage('KPP')?>:</b> <?=$item['UF_INN']?>/<?=$item['UF_KPP']?></p>
                            <p><b><?=GetMessage('PH_ADDRESS')?>:</b> <?=$item['PERSONAL_ZIP']?>, <?=$item['PERSONAL_CITY']?>, <?=$item['PERSONAL_STREET']?></p>
                            <p><b><?=GetMessage('YU_ADDRESS')?>:</b> <?=$item['WORK_ZIP']?>, <?=$item['WORK_CITY']?>, <?=$item['WORK_STREET']?></p>
                            <p><b><?=GetMessage('CONTACT_PERSONE')?>:</b> <?=$item['LAST_NAME']?> <?=$item['NAME']?></p>
                            <p><b><?=GetMessage('CONTACT_EMAIL')?>:</b> <?=$item['EMAIL']?></p>
                            <p><b><?=GetMessage('CONTACT_PHONE')?>:</b> <?=$item['PERSONAL_PHONE']?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?
        endforeach;
    endif;
    ?>
    <div class="loader_cover">
        <div class="loader"></div>
    </div>
    <div class="yul_add_popup_cover">
        <div id="success_yul_add_popup">
            <div class="cross_close_popup">
                <span>X</span>
            </div>
            <h2><?=GetMessage('NEW_YL_MODERATE')?></h2>
            <div><?=GetMessage("NEW_YL_CONTENT")?></div>
        </div>
    </div>
    <div class="yul_add_popup_cover">
        <div id="exists_yul_add_popup">
            <div class="cross_close_popup">
                <span>X</span>
            </div>
            <h2><?=GetMessage('NEW_YL_EXISTS')?></h2>
            <div><?=GetMessage("NEW_YL_EXISTS_CONTENT")?></div>
        </div>
    </div>
    <div class="yul_add_popup_cover">
        <div id="error_yul_add_popup">
            <div class="cross_close_popup">
                <span>X</span>
            </div>
            <h2><?=GetMessage('ERROR_YL_MODERATE')?></h2>
            <div><?=GetMessage("ERROR_YL_CONTENT")?></div>
        </div>
    </div>
</div>
<?else:?>
<div class="no_le_notice">
<?=GetMessage('NO_LEGAL_ENTITIES')?><br/>
</div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <tbody>
                    <?foreach($arResult["USERS_LINKS"] as $item):?>
                    <tr>
                        <td><?=$item["LAST_NAME"]." ".$item["NAME"]?></td>
                        <td><?=$item["EMAIL"]?></td>
                        <td>
                            <a title="<?=GetMessage('AUTHORIZE')?>" class="user-yul_accordion_authorize" href="/personal/authorize.php?lang=ru&ID=<?=$item['ID']?>&action=authorize&<?=bitrix_sessid_get('sessid')?>">
                                <?=GetMessage('AUTHORIZE')?>
                            </a>
                        </td>
                     </tr>
                    <?$num++;?>
                <?endforeach;?>
                </tbody>
            </table>
<?endif;?>




