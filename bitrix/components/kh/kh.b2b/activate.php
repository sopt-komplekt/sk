<?php
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 20.03.2019
 * Time: 22:39
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context;
use Bitrix\Main\Mail\Event;
global $USER;
$request = Context::getCurrent()->getRequest();


$ID = $request->getPost("legal_entity_id");
$soglashenie=$request->getPost("soglashenie");
$user = new CUser;
$fields = Array(
    "ACTIVE" => "Y",
    "GROUP_ID"=> [$soglashenie]
);

$emailFields = $USER->GetByID($ID)->Fetch();
$nameOfPhys = $USER->GetByID($emailFields['UF_USERS_LINKS'])->Fetch();
if($user->Update($ID, $fields)){
    BXClearCache(true, "/kh.b2b/inactive_yulick/");
    BXClearCache(true, "/kh.b2b/yu_lick/");
    Event::send(array(
        "EVENT_NAME" => "NEW_YUL_APPLICATION_ADOPT",
        "LID" => "s1",
        "C_FIELDS" => array(
            "CONTACT_EMAIL" => $emailFields["EMAIL"],
            "WORK_COMPANY"=>$emailFields["WORK_COMPANY"],
            "PHYSICAL_ENTITY"=>implode(" ", [$nameOfPhys['LAST_NAME'], $nameOfPhys['NAME']])
        ),
    ));
    die($ID);
} else die($user->LAST_ERROR);
