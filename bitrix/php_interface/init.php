<?

	if (!function_exists('dump')) {
        function dump($var = null) {
            if($_GET['dump'] == 'off'){
                $_SESSION['DUMP'] = 'N';
            }
            elseif($_GET['dump'] == 'on' || $_SESSION['DUMP'] == 'Y'){
                $_SESSION['DUMP'] = 'Y';
                if ($var == null) $var = 'Empty';
                echo '<pre style="display: block; padding: 10px; margin: 10px 0; clear: both; word-break: break-all; word-wrap: break-word; background-color: #f5f5f5; border: 1px solid #ccc; text-align: left; font: 12px Menlo, Courier New, monospace; color: green; border-radius: 0;">';
                print_r($var);
                echo '</pre>';
            }
        }
    }

    if (!function_exists('getWordEnding')) {
        function getWordEnding($number, $suffix = array('день', 'дня', 'дней')) {
            $keys = array(2, 0, 1, 1, 1, 2);
            $mod = $number % 100;
            $suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
            return $suffix[$suffix_key];
        }
    }

    #Remove advertising tab
    #AddEventHandler('main','OnAdminTabControlBegin','RemoveYandexDirectTab');
    #function RemoveYandexDirectTab(&$TabControl){
    #   if ($GLOBALS['APPLICATION']->GetCurPage()=='/bitrix/admin/iblock_element_edit.php') {
    #      foreach($TabControl->tabs as $Key => $arTab){
    #         if($arTab['DIV']=='seo_adv_seo_adv') {
    #            unset($TabControl->tabs[$Key]);
    #         }
    #      }
    #   }
    #}

    AddEventHandler('iblock', 'OnIBlockPropertyBuildList', array('Solution', 'GetIBlockPropertyDescription'));

    class Solution {
        // инициализация пользовательского свойства для инфоблока
        function GetIBlockPropertyDescription() {
            return array(
                'PROPERTY_TYPE' => 'E',
                'USER_TYPE' => 'solution',
                'DESCRIPTION' => 'Количество × Привязка к элементам',
                'GetPropertyFieldHtml' => array('Solution', 'GetPropertyFieldHtml'),
                'ConvertToDB' => array('Solution', 'ConvertToDB'),
                'ConvertFromDB' => array('Solution', 'ConvertFromDB'),
            );
        }

        function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName) {
            // $value['DESCRIPTION'] = unserialize($value['DESCRIPTION']);
            $arItem = array(
                'ID' => 0,
                'IBLOCK_ID' => 0,
                'NAME' => ''
            );
            if (intval($value['VALUE']) > 0) {
                $arFilter = array(
                    'ID' => intval($value['VALUE']),
                    'IBLOCK_ID' => $arProperty['LINK_IBLOCK_ID'],
                );
                $rsItem = CIBlockElement::GetList(Array(), $arFilter, false, false, Array('ID', 'IBLOCK_ID', 'NAME'));
                $arItem = $rsItem->GetNext();
            }

            $html.=
            '<input type="text" size="3" id="quan" name="'.$strHTMLControlName["DESCRIPTION"].'" value="'.htmlspecialcharsex($value["DESCRIPTION"]).'" placeholder="кол-во" style="text-align: right;"> × '.
            '<input name="'.$strHTMLControlName['VALUE'].'" id="'.$strHTMLControlName['VALUE'].'" value="'.htmlspecialcharsex($value['VALUE']).'" size="5" type="text" placeholder="товар">'.
            '<input type="button" value="…" onClick="jsUtils.OpenWindow(\'/bitrix/admin/iblock_element_search.php?lang='.LANG.'&IBLOCK_ID='.$arProperty['LINK_IBLOCK_ID'].'&n='.$strHTMLControlName['VALUE'].'\', 600, 500);">'.
            ' <span id="sp_'.md5($strHTMLControlName['VALUE']).'_'.$key.'" >'.$arItem['NAME'].'</span>'.
            '';
            return  $html;
        }      

        function GetAdminListViewHTML($arProperty, $value, $strHTMLControlName) {
            return;
        }

        function ConvertToDB($arProperty, $value) {// сохранение в базу
            if (empty($arProperty) ) return false;
            if (is_array($value) && empty($value['VALUE'])) return false;
            if (is_array($value) && empty($value['DESCRIPTION'])) return false;
            $return = false;
            if (is_array($value) && array_key_exists('VALUE', $value)) {
                $return = array('VALUE' => serialize($value['VALUE']));
            }
            if (is_array($value)&& array_key_exists('DESCRIPTION', $value)) {
                $return['DESCRIPTION'] = $value['DESCRIPTION'];
                // $return['DESCRIPTION'] = serialize($value['DESCRIPTION']);
            }
            return $return; 
        }

        function ConvertFromDB($arProperty, $value) {//извлечение из БД
            $return = false;
            if (!is_array($value['VALUE'])) {
                $return = array('VALUE' => unserialize($value['VALUE']));
            }
            return $return;
        }
    }

AddEventHandler("main", "OnBeforeUserSendPassword", Array("MyClass", "OnBeforeUserSendPasswordHandler"));
AddEventHandler("main", "OnBeforeUserRegister", Array("MyClassBeforeRegister", "OnBeforeUserRegisterHandler"));

class MyClass
{
    // создаем обработчик события "OnBeforeUserAdd"
    function OnBeforeUserSendPasswordHandler(&$arFields)
    {
        //проверяем, что пришло в поле, если не email, то пропускаем
        if(strpos($arFields["LOGIN"], '@') != FALSE ){
            $res = \CUSER::GetList(
                ($by="personal_country"),
                ($order="desc"),
                array("EMAIL"=>trim(strip_tags($arFields["LOGIN"]))),
                array("SELECT"=>"LOGIN")
            );
            $users2check = [];
            while($result = $res->Fetch()){
                $users2check[] = $result;
            }

            //исключаем юридические лица
            foreach($users2check as $key=>$item){
                if($item["WORK_COMPANY"] && $item["WORK_COMPANY"] != ""){
                    unset($users2check[$key]);
                }
            }

            //если были только юридические лица, то обнуляем запрос
            if( count($users2check)!= 1){
                $arFields["LOGIN"] = '';
                $arFields["EMAIL"] = '';
                LocalRedirect("/personal/private/?forgot_password=yes");
            }

            foreach($users2check as $key=>$item){
                $arFields["LOGIN"] = $item["LOGIN"];
                $arFields["EMAIL"] = $item["LOGIN"];
            }
        }
    }
}
class MyClassBeforeRegister
{
    // создаем обработчик события "OnBeforeUserRegister"
    function OnBeforeUserRegisterHandler(&$arFields)
    {
        if(!$arFields["WORK_COMPANY"] && !$arFields["UF_INN"]){
            $res = \CUSER::GetList(
                ($by="personal_country"),
                ($order="desc"),
                array("EMAIL"=>trim(strip_tags($arFields["EMAIL"]))),
                array("SELECT"=>"ID")
            );

            while($result = $res->Fetch()){
                if(trim($result["WORK_COMPANY"]) == '')
                $users2check[] = $result;
            }

            if(count($users2check)>0){
                $_SESSION['REGISTER_ERROR_EMAIL'] = 'Y';
                LocalRedirect('/personal/private/?register=yes');
            }
        }

    }
}
    
?>