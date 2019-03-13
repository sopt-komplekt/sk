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
Loc::loadMessages(__FILE__);


class b2b extends CBitrixComponent{

    private $log_file = "/_tmp/log.log";
    private $userArr = [];
    private $currentIdUser;
    private $groupsOfYul = [
        '9'=> 'Партнёр',
        '10'=> 'Дилер',
        '11'=> 'МРЦ'
    ];

    public function onPrepareComponentParams($arParams){

        global $USER;
        if (!$USER->IsAuthorized()) {
            LocalRedirect('/', false, '301 Moved permanently');
        }

        $this->currentIdUser = $USER->GetID();

        $request = Context::getCurrent()->getRequest();

        if ($request->isAjaxRequest() && $arParams["newUserData"]) {
            foreach($arParams["newUserData"] as $key=>$value){
                if($key == 'UF_INN'){
                    $result["USER"]["LOGIN"] = htmlspecialchars($value)."_".$this->currentIdUser;
                }
                if($key == 'UF_USERS_LINKS'){
                    $result["USER"]["UF_USERS_LINKS"][] = htmlspecialchars($value);
                }
                $result["USER"][$key] = htmlspecialchars($value);
            }

            $salt = randString(8);
            $result["USER"]["PASSWORD"] = $salt.md5($salt.randString(10));
            $result["AJAX"] = $arParams["AJAX"];
        }

        $res = $USER->GetByID($this->currentIdUser);
        $this->userArr = $res->Fetch();

        $result['PARAMS'] = array(
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ?$arParams["CACHE_TIME"]: 36000000,
            "SET_TITLE" =>$arParams["SET_TITLE"]
        );

       return $result;
    }

    protected function createNewUser($data){
        //Заводим новое юр.лицо
        $user = new CUser;
        $arFields = $data;
        $ID = $user->Add($arFields);
        if (intval($ID) > 0){
            self::addWorkNote(intval($ID));
            return "Y";
        }
        else
           return $user->LAST_ERROR;
    }

    public function getAllYuF(){
        global $USER;
        $yu_lick = [];
        $res_group = [];
        //Находим все связанные юридические лица
            $idArr = explode(";", $this->userArr["WORK_NOTES"]);
            foreach($idArr as $user_yl){
                $res = $USER->GetByID($user_yl);
                $yu_lick[] = $res->Fetch();
                $res_group = $USER->GetUserGroupArray();
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
        $this->arResult['newUserCreated'] = false;
        if($this->arParams["AJAX"]){
            $userID = $this->createNewUser($this->arResult['USER']);
            if($userID == "Y"){
                unset($this->arResult["USER"]);
                $this->arResult['newUserCreated'] = "Y";
            }else{
                $this->arResult['newUserCreated'] = $userID;
            }
        }

        if($this->userArr["WORK_NOTES"] !== "") {
            $this->arResult["YU_L"] = $this->getAllYuF();
        }
        if($this->userArr["UF_USERS_LINKS"] !== "") {
            $this->arResult["USERS_LINKS"] = $this->getConnectedPhysPerson();
        }

       $this->includeComponentTemplate();
    }

}