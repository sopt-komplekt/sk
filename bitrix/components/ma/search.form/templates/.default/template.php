<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="b-search-form">
	<form action="<?=$arResult["FORM_ACTION"]?>" method="get" class="search-form">
		
		<?if($arParams["USE_SUGGEST"] === "Y"):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:search.suggest.input",
				"",
				array(
					"NAME" => "q",
					"VALUE" => "",
					"INPUT_SIZE" => 15,
					"DROPDOWN_SIZE" => 10,
				),
				$component, array("HIDE_ICONS" => "Y")
			);?>
		<?else:?>
        
			<input class="input search-suggest" type="text" name="q" value="<?=$_REQUEST['q']?>" maxlength="50" autocomplete="off" placeholder="<?=GetMessage("PLACEHOLDER"); ?>" />
            
		<?endif;?>
	
		<input class="submit" name="s" type="submit" value="<?=GetMessage("BSF_T_SEARCH_BUTTON");?>" />

	</form>
</div>