<?php
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 12.03.2019
 * Time: 20:42
 */
require_once ($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $USER;
if($_REQUEST["action"] == "authorize" && check_bitrix_sessid())
{
    $USER->Logout();
    $USER->Authorize(intval($_REQUEST["ID"]));
    LocalRedirect("/personal/");
}