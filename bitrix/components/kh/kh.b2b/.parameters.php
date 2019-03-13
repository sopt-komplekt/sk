<?php
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 06.03.2019
 * Time: 19:05
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

$arComponentParameters = array(

    "GROUPS"=>array(
        "COMMON_SETTINGS" =>array(
            "NAME"=>Loc::getMessage("COMMON_SETTINGS_COMPONENT_B2B")
        )
    ),

    "PARAMETERS"=>array(
        "SET_TITLE" => "Y",
        "CACHE_TIME" => array(
            "DEFAULT"=>3600
        )
    )
);