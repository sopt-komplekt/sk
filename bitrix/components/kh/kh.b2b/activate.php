<?php
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 20.03.2019
 * Time: 22:39
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context;
global $USER;
$request = Context::getCurrent()->getRequest();


$ID = $request->getPost("legal_entity_id");
$user = new CUser;
$fields = Array(
    "ACTIVE" => "Y",
);
if($user->Update($ID, $fields)){
    die($ID);
} else die($user->LAST_ERROR);
