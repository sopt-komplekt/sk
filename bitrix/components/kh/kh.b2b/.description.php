<?php
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 06.03.2019
 * Time: 19:05
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

$arComponentDescription = array(
    "NAME" => Loc::getMessage("COMP_B2B_NAME"),
    "DESCRIPTION"=> Loc::getMessage("COMP_B2B_DESCRIPTION"),
    "PATH"=> array(
        "ID"=> 'content',
        "CHILD"=>array(
            "ID"=> "kh_b2b",
            "NAME"=> Loc::getMessage("COMP_B2B")
        )
    ),
    "CACHE_PATH"=> "Y",
    "COMPLEX"=>''
);