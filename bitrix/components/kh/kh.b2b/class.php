<?php
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 06.03.2019
 * Time: 19:06
 */

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;
use Bitrix\Main\IO;
use Bitrix\Main\Mail\Event;
Loc::loadMessages(__FILE__);


class b2b extends CBitrixComponent{

    private $log_file = "/_tmp/log.log";
    /*private $name;*/
    private $userArr = [];
    private $currentIdUser;
    private $groupsOfYul = [
        'PARTNER'=> '9',
        'DILER'=> '10',
        'MRC'=> '11',
        'ROZNICA' => '12'
    ];

    public function onPrepareComponentParams($arParams){

        global $USER;
        if (!$USER->IsAuthorized()) {
            LocalRedirect('/', false, '301 Moved permanently');
        }
        //Get current user
        $this->currentIdUser = $USER->GetID();
        $res = $USER->GetByID($this->currentIdUser);
        $this->userArr = $res->Fetch();
        //Param to get list of inactive users
        $result['LEGAL_ENTITY'] = $arParams['LEGAL_ENTITY'];

        //Prepare params for new user create
        $request = Context::getCurrent()->getRequest();
        if ($request->isAjaxRequest() && $arParams["newUserData"]) {

            foreach($arParams["newUserData"] as $key=>$value){
                if($key == 'UF_INN'){
                    $result["USER"]["LOGIN"] = htmlspecialchars($value)."_".$this->currentIdUser;
                    $result["USER"]["UF_INN"] = htmlspecialchars($value);
                }elseif($key == 'UF_USERS_LINKS'){
                    $result["USER"]["UF_USERS_LINKS"] = htmlspecialchars($value);
                }
                elseif($key == 'WORK_COMPANY'){
                    $result["USER"]["WORK_COMPANY"] = $value;
                }else $result["USER"][$key] = htmlspecialchars($value);
            }

            $salt = randString(8);
            $result["USER"]["PASSWORD"] = $salt.md5($salt.randString(10));
            $result["AJAX"] = $arParams["AJAX"];
        }

        //Params for cache
        $result['PARAMS'] = array(
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ?$arParams["CACHE_TIME"]: 36000000,
            "SET_TITLE" =>$arParams["SET_TITLE"]
        );

       return $result;
    }

    protected function getIALegalEntities(){

        $legalEntitiesList = [];

        $obCache = new CPHPCache();
        $cachePath = '/kh.b2b/inactive_yulick/';
        $cacheLifeTime = intval($this->arResult["PARAMS"]["CACHE_TIME"]);
        $cacheID =  $this->getName();
        if($obCache->initCache($cacheLifeTime,$cacheID,$cachePath)){
            $arVars = $obCache->getVars();
            $legalEntitiesList = $arVars['legalEntitiesList'];
            $obCache->Output();
        }elseif($obCache->StartDataCache()) {

       $userFilter = ["ACTIVE"=>"N", "!UF_USERS_LINKS"=> '', "!WORK_COMPANY"=> '', "!UF_INN" => ''];
        $userSelect = ["ID", "WORK_COMPANY", "WORK_CITY", "WORK_STREET", "LAST_NAME", "NAME", "PERSONAL_CITY", "PERSONAL_STREET", "PERSONAL_PHONE", "EMAIL", "UF_INN", "UF_KPP", "UF_GENERAL_DIRECTOR"];
        $legalEntities =  \CUser::GetList(($by="UF_USERS_LINKS"), ($order="ASC"), $userFilter, ["SELECT"=>$userSelect]);
        while($legalEntityItem = $legalEntities->Fetch())
        {
            foreach($userSelect as $select_item){
                $legalEntitiesList[$legalEntityItem['ID']][$select_item] = $legalEntityItem[$select_item];
            }
            $connectedPerson = \CUSER::GetByID(explode("_", $legalEntityItem['LOGIN'])[1])->Fetch();
            $legalEntitiesList[$legalEntityItem['ID']]["CONNECTED_PERSON"] = implode(" ", [$connectedPerson["LAST_NAME"], $connectedPerson["NAME"]]);
            $legalEntitiesList[$legalEntityItem['ID']]["CONNECTED_PERSON_ID"] = $connectedPerson["ID"];
        }
            $obCache->EndDataCache(array("legalEntitiesList"=>$legalEntitiesList));
        }
        return $legalEntitiesList;
    }

    protected function createNewUser($data){
        //Заводим новое юр.лицо
        BXClearCache(true, "/kh.b2b/inactive_yulick/");
        $user = new CUser;
        $arFields = $data;
        $arFields["ACTIVE"] = 'N';
        $ID = $user->Add($arFields);
        if (intval($ID) > 0){
            self::addWorkNote(intval($ID));
            Event::send(array(
                "EVENT_NAME" => "NEW_YUL_APPLICATION",
                "LID" => "s1",
                "C_FIELDS" => array(
                    "CONTACT_EMAIL" => $arFields["EMAIL"],
                    "NEW_LEGAL_ENTITY" => $ID,
                    "NAME_WHO_ADD" => implode("", [$this->userArr["LAST_NAME"], $this->userArr["NAME"]]),
                    "ID_WHO_ADD" => $this->currentIdUser,
                    "WORK_COMPANY"=>$arFields["WORK_COMPANY"],
                    "CONTACT_NAME"=> implode(' ', [$arFields["LAST_NAME"], $arFields["NAME"]]),
                    "INN"=> $arFields["UF_INN"],
                    "KPP"=>$arFields["UF_KPP"]
                ),
            ));
            return "Y";
        }
        else
           return $user->LAST_ERROR;
    }

    public function getAllYuF(){
        global $USER;
        $yu_lick = [];
        //Закэшируем результат
         $obCache = new CPHPCache();
         $cachePath = '/kh.b2b/yu_lick/';
         $cacheLifeTime = intval($this->arResult["PARAMS"]["CACHE_TIME"]);
         $cacheID =  $this->getName();
         if($obCache->initCache($cacheLifeTime,$cacheID,$cachePath)){
             $arVars = $obCache->getVars();
             $yu_lick = $arVars['yu_lick'];
             $obCache->Output();
         }elseif($obCache->StartDataCache()) {
             //Находим все связанные юридические лица
             $idArr = explode(";", $this->userArr["WORK_NOTES"]);
             foreach($idArr as $user_yl){
                 $res = $USER->GetByID($user_yl)->Fetch();
                 if($res["ACTIVE"] == 'Y') $yu_lick[] = $res;
             }
             $obCache->EndDataCache(array("yu_lick"=>$yu_lick));
         }
        return $yu_lick;
    }

    public function getConnectedPhysPerson(){
        global $USER;
        $phys = [];
        //Находим все связанные юридические лица
           $res = $USER->GetByID($this->userArr["UF_USERS_LINKS"]);
           $phys[] = $res->Fetch();
           return $phys;
    }

    protected function addWorkNote($newYL){
        $workNotes = [];
        if($this->userArr["WORK_NOTES"] && $this->userArr["WORK_NOTES"]!== ''){
            $workNotes = explode(";", $this->userArr["WORK_NOTES"]);
        }

        //Заносим информацию о новом юр лице в поле рабочая доп. информация
        $fields = Array(
           "WORK_NOTES"=> implode(";", array_merge_recursive([$newYL], $workNotes))
        );

        try{
            $user_update = new CUser;
            $user_update->Update($this->userArr["ID"], $fields);
            $user_update->LAST_ERROR;
        }catch(Exception $e){
            $file = new IO\File(Application::getDocumentRoot() . $this->log_file);
            $file->putContents("Error on update user: ".date("d-m-Y H:i:s")."\n", IO\File::APPEND);
            $file->putContents($e->getMessage()."\n\n", IO\File::APPEND);
        }
    }

        public function executeComponent()
    {
        unset($this->arResult);
        $this->arResult = $this->arParams;
        //If call to get list of inactive legal enities
        if($this->arResult['LEGAL_ENTITY'] && $this->arResult['LEGAL_ENTITY'] == "moderate_list"){
            $this->arResult["INACTIVE_LEGAL_ENTITIES"] = $this->getIALegalEntities();
        }

        $this->arResult['newUserCreated'] = false;
        if($this->arParams["AJAX"]){
            $userID = $this->createNewUser($this->arResult['USER']);
            if($userID == "Y"){
                unset($this->arResult["USER"]);
                $this->arResult['newUserCreated'] = "Y";
            }else{
                $this->arResult['newUserCreated'] = $userID;
            }
            die($this->arResult['newUserCreated']);
        }

        if($this->userArr["WORK_NOTES"] !== "") {
            $this->arResult["YU_L"] = $this->getAllYuF();
        }
        if($this->userArr["UF_USERS_LINKS"] !== "") {
            $this->arResult["USERS_LINKS"] = $this->getConnectedPhysPerson();
        }
        $this->arResult["GROUP_OF_LEGAL_ENTITIES"] = $this->groupsOfYul;
        $this->arResult["CURRENT_USER"] = $this->userArr;
       $this->includeComponentTemplate();
    }

}