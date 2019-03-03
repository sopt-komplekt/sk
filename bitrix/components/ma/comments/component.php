<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION, $USER;
use Bitrix\Main\Loader;
use Bitrix\Main\Type;
use Bitrix\Main\Config\Option;
use Ma\Comments\MaComments;


$MODULE_ID = 'ma.comments';
$arResult = array();
$arModuleParams['USE_CAPTCHA'] = Option::get($MODULE_ID, "CAPTCHA", "off");
$arModuleParams['SEND_ADMIN_NOTIFY'] = Option::get($MODULE_ID, "SEND_ADMIN_NOTIFICATION", "off");

if (is_object($USER)) {
	if ($USER->IsAuthorized()) {
		$arModuleParams['USE_CAPTCHA'] = 'off';	
	}
	$rsUser = CUser::GetByID($USER->GetId());
	$arUser = $rsUser->Fetch();
	$arResult['CUR_USER'] = $arUser;
}
if (Loader::includeModule($MODULE_ID)) {
	/* Send comment part */
	if (!empty($_REQUEST['submit'])) {
		if ($arModuleParams['USE_CAPTCHA'] == "on") {
			//Check captcha
			include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php"); 
			$cptcha = new CCaptcha(); 
			if(!strlen($_REQUEST["captcha_word"])>0) {
				$arResult['MESSAGE']['ERROR'] .= "Вы не ввели код CAPTCHA";
			} 
			elseif(!$cptcha -> CheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"])) {
				$arResult['MESSAGE']['ERROR'] .= "Код с картинки заполнен неправильно";
			}
		}

		//Check require fields
		$arFormFields = array(
			"COMMENT_NAME" => "Имя",
			"COMMENT_EMAIL" => "Email",
			"COMMENT_CITY" => "Город",
			"COMMENT_TEXT" => "Комментарий",
		);
		$arFormFieldsReq = array(
			"COMMENT_NAME",
			"COMMENT_TEXT",
		);

		foreach ($arFormFields as $FIELD_CODE => $FIELD_NAME) {
			if (in_array($FIELD_CODE, $arFormFieldsReq) && empty($_REQUEST[$FIELD_CODE])) {
				$arResult['MESSAGE']['ERROR'] .= "<br>Вы не заполнили поле \"".$FIELD_NAME."\"";
			} else if (!empty($_REQUEST[$FIELD_CODE])) {
				$_REQUEST[$FIELD_CODE] = htmlspecialchars($_REQUEST[$FIELD_CODE]);
			}
		}

		if (empty($arResult['MESSAGE'])) {
			if (is_object($USER)) {
				$CUR_USER_ID = $USER->GetId();

				$IS_ADMIN = false;
				if ($USER->IsAdmin()) {
					$IS_ADMIN = true;
				}
			}
			$arFields = array(
				'ACTIVE' => "N",
				'USER_NAME' => $_REQUEST['COMMENT_NAME'],
				'USER_EMAIL' => $_REQUEST['COMMENT_EMAIL'],
				'USER_CITY' => $_REQUEST['COMMENT_CITY'],
				'COMMENT_TEXT' => $_REQUEST['COMMENT_TEXT'],
				'USER_ID' => $CUR_USER_ID,
				'LINKED_ELEMENT_ID' => $arParams['LINKED_ELEMENT_ID'],
				'LINKED_ELEMENT_IBLOCK' => $arParams['LINKED_ELEMENT_IBLOCK'],
				'LINKED_URL' => $APPLICATION->GetCurPage(false),
				'USER_IP' => $_SERVER["REMOTE_ADDR"],
				'LINKED_COMMENT_ID' => $_REQUEST['REPLY_COMMENT_ID'],
				//'LINKED_COMMENT_ID' => 3,
				//'MARK' => "Y",
			);
			if ($IS_ADMIN === true) {
				$arFields['ACTIVE'] = "Y";
				$arFields['MARK'] = "Y";
			}

			$res = MaComments::addComment($arFields);
			if ($res > 0) {
				$arFields['ID'] = $res;
				$arResult['MESSAGE']['GOOD'] = 'Спасибо! Ваш комментарий успешно отправлен.';
				if ($arModuleParams['SEND_ADMIN_NOTIFY'] == "on") {
					CEvent::Send("MA_NEW_COMMENT", SITE_ID, $arFields);
				}
			}
		}
	}
	if ($arModuleParams['USE_CAPTCHA'] == "on") {
		$arResult["CAPTCHA_CODE"] = htmlspecialchars($APPLICATION->CaptchaGetCode()); 
	}
	/* End of Send coment part */


	/* Get comments part */	
	$arFilter = array("ACTIVE" => "Y");
	$arSelect = array('*');
	$arOrder = array("DATE_CREATED");
	if ($arParams['LINKED_ELEMENT_ID'] > 0) {
		$arFilter['LINKED_ELEMENT_ID'] = $arParams['LINKED_ELEMENT_ID'];
	} else {
		$arFilter['LINKED_URL'] = $APPLICATION->GetCurPage(false);
	}
	$arTemp = MaComments::getComments($arOrder, $arFilter, $arSelect);
	$COMMENTS_COUNT = count($arTemp);
	
	//Format date, change key by id, mark admin comments
	foreach ($arTemp as $key => $arItem) {
		if (!empty($arItem['DATE_CREATED']) && is_object($arItem['DATE_CREATED'])) {
			$arItem['DATE_CREATED'] = FormatDate('d.m.Y', MakeTimeStamp($arItem['DATE_CREATED']->toString()));
		}
		if (array_intersect(array(1, 6), CUser::GetUserGroup($arItem['USER_ID']))) {
			$arItem['MARK'] = "Y";
		}
		$arResult['ITEMS'][$arItem['ID']] = $arItem;
	}

	//Link comments betwen them
	foreach ($arResult['ITEMS'] as $ITEM_ID => $arItem) {
		$LINK_ID = $arItem['LINKED_COMMENT_ID'];
		if ($LINK_ID > 0 && !empty($arResult['ITEMS'][$LINK_ID])) {
			$arResult['ITEMS'][$LINK_ID]['CHILD_ITEMS'][] = $arItem;
			unset($arResult['ITEMS'][$ITEM_ID]);
		}
		unset($LINK_ID);
	}
	
	//dump($arResult);


	/* End of Get comments part */
}

// dump($arTemp);

$this->IncludeComponentTemplate();

return $COMMENTS_COUNT;
?>