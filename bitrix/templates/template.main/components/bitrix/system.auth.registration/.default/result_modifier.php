<?php
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 24.03.2019
 * Time: 14:14
 */

if($_SESSION['REGISTER_ERROR_EMAIL'] == 'Y'){
    $arResult["REGISTER_ERROR_EMAIL"] = "Y";
    unset($_SESSION['REGISTER_ERROR_EMAIL']);
}
