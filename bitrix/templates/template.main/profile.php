<?

    if($APPLICATION->GetCurPage(false) == '/') {
        $FL_MAIN = true;
    }
    elseif($_SERVER['SCRIPT_NAME'] == '/catalog/index.php' || $_SERVER['REAL_FILE_PATH'] == '/catalog/index.php'){
        $FL_CATALOG = true;   
    }
    elseif($_SERVER['SCRIPT_NAME'] == '/complex-solutions/index.php' || $_SERVER['REAL_FILE_PATH'] == '/complex-solutions/index.php'){
        $FL_SOLUTIONS = true;   
    }
    elseif($_SERVER['SCRIPT_NAME'] == '/catalog/search/index.php' || $_SERVER['REAL_FILE_PATH'] == '/catalog/search/index.php'){
        $FL_SEARCH = true;   
    }

    // Почта в настройках сайта
    if(empty($_SESSION['SITE_EMAIL'])){
        $rsSites = CSite::GetByID('s1');
        $arSite = $rsSites->Fetch();
        $_SESSION['SITE_EMAIL'] = $arSite['EMAIL'];
    }

    // Обработка выхода из пользователя
    if ($_REQUEST['logout'] == "Y" && is_object($USER) && $USER->IsAuthorized()) {
        $USER->Logout();
        LocalRedirect('/');
    }

    // FormatDate("d F", MakeTimeStamp($arResult["DATE"]))

?>