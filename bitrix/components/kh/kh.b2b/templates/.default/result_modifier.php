<?php
/**
 * Created by PhpStorm.
 * User: A.Khudenko
 * Date: 12.03.2019
 * Time: 22:48
 */
if(strpos($arResult['newUserCreated'], "Пользователь с логином") !== FALSE)
    $arResult['newUserCreated'] = "Пользователь с таким логином уже существует";