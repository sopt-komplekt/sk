<?php
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 07.03.2019
 * Time: 09:09
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Context;
$request = Context::getCurrent()->getRequest();
$newUserData = $request->getPostList()->toArray();

$APPLICATION->IncludeComponent(
    "kh:kh.b2b",
    "",
    array(
        "AJAX"=>"Y",
        "newUserData"=>$newUserData
    ),
    false
);
