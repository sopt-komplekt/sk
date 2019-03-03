<? 
	if($arParams['USE_POPUP_SCRIPTS'] == 'Y') {
        
	    if($arParams['MODAL_SCRIPTS_LIST'] == 'AM') {
	    	
	    	if($arParams['MODAL_FORM_DESKTOP'] == "Y") {
	    		$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/arcticmodal/events.modal_scripts_list_am_desktop.js');
	    	} else {
	    		$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/arcticmodal/events.modal_scripts_list_am.js');
	    	}

	        if($arParams['MODAL_FORM'] == "Y") {
				$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/arcticmodal/events.modal_form_am.js');     	
	        }
	    }
	    elseif($arParams['MODAL_SCRIPTS_LIST'] == 'FB'){
	    
	    	$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/fancybox2/events.modal_scripts_list_fb.js');

	        if($arParams['MODAL_FORM'] == "Y") {
	        	$APPLICATION->AddHeadScript('/bitrix/components/ma/site.settings/fancybox2/events.modal_form_fb.js');   
	        }
	    
	    }

	}

	if($arParams['USE_POSHYTIP'] == 'Y'){
		$APPLICATION->AddHeadScript($templateFolder.'/poshytip/poshytip.events.js');
		$APPLICATION->SetAdditionalCSS($templateFolder.'/poshytip/poshytip.css');
	}

?>