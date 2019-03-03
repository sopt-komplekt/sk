<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<span id="<?=$arResult['FORM_ID']?>"></span>

<? if($arResult['DESCRIPTION_FORM'] && $arResult['MESSAGE_RESULT'] != 'MESSAGE_RESULT_OK'): ?>
	<div class="b-message-form-text">
		<?=$arResult['DESCRIPTION_FORM']?>
	</div>
<? endif; ?>

<? if($arResult['MESSAGE_RESULT'] == 'MESSAGE_RESULT_OK'): ?>
	<? ShowMessage(Array('TYPE'=>'OK', 'MESSAGE'=>$arParams['MESSAGE_RESULT_OK_TEXT'])); ?>
<? elseif($arResult['MESSAGE_RESULT'] == 'MESSAGE_RESULT_ERROR'): ?>
	<? ShowMessage($arResult['MESSAGE_RESULT_ERROR_TEXT']); ?>
<? endif; ?>

<? if($arResult['FORM_ITEMS'] && $arResult['MESSAGE_RESULT'] != 'MESSAGE_RESULT_OK'): ?>
	
	<div class="b-message-form b-message-form_<?=$arParams['IBLOCK_ID']?>">
		<form method="post" action="<?=$arParams['ACTION_FORM']?>#<?=$arResult['FORM_ID']?>" enctype="multipart/form-data">

			<input type="hidden" name="FORM_ID" value="<?=$arResult['FORM_ID']?>" />
			
			<? foreach($arResult['FORM_ITEMS'] as $key => $arProperties):
				if($arProperties['PROPERTY_TYPE'] == 'HIDDEN_CAPTCHA' && $arParams['USE_CAPTCHA'] == 'HIDDEN_CAPTCHA'): ?>
					<input type="text" id="captcha" name="captcha" value="" class="b-hidden-captcha"><?
					continue;
				endif;

				if($arProperties['PROPERTY_TYPE'] == 'S' && $arProperties['USER_TYPE'] == 'HTML'){
					$sufics = 'textarea';
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'S' && $arProperties['USER_TYPE'] == 'DateTime'){
					$sufics = 'date';
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'S'){
					$sufics = 'text';
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['LIST_TYPE'] == 'L'){
					$sufics = '';
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['LIST_TYPE'] == 'C' && $arProperties['MULTIPLE'] == 'N' && count($arProperties['VALUE_LIST']) > 1){
					$sufics = '';
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['LIST_TYPE'] == 'C' && $arProperties['MULTIPLE'] == 'N' && count($arProperties['VALUE_LIST']) == 1){
					$sufics = '';
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['LIST_TYPE'] == 'C' && $arProperties['MULTIPLE'] == 'Y'){
					$sufics = '';
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'F'){
					$sufics = 'file';
				}
				elseif($arProperties['PROPERTY_TYPE'] == 'COLOR_CAPTCHA'){
					$sufics = 'captcha';
				}
				else {
					$sufics = '';
				} ?>

				<div class="b-message-form_item b-message-form_item_<?=$sufics?><? if($arProperties['ERROR']): ?> b-message-form_error<? endif ?>" id="i-message-form-item-<?=$arProperties['ID']?>">
					
					<? if($arProperties['PROPERTY_TYPE'] != 'COLOR_CAPTCHA' && $arProperties['PROPERTY_TYPE'] != 'GRAHIC_CAPTCHA' && $arProperties['PROPERTY_TYPE'] != 'HIDDEN_CAPTCHA'): ?>
						<label for="i-message-form-field-<?=$arProperties['ID']?>"><?=$arProperties['NAME']?><? if($arProperties['IS_REQUIRED'] == 'Y'): ?> <span class="required">*</span><? endif; ?></label>	
					<? endif; ?>
					
					<? if($arProperties['PROPERTY_TYPE'] == 'S' && $arProperties['USER_TYPE'] == 'HTML'): ?>
						<div class="b-message-form_field b-message-form_textarea">
							<textarea id="i-message-form-field-<?=$arProperties['ID']?>" class="textarea g-input-undo-label" name="FIELD_<?=$arProperties['ID']?>"><?=$arResult['POST']['FIELD_'.$arProperties['ID']]?></textarea>
						</div>
					<? elseif($arProperties['PROPERTY_TYPE'] == 'S' && $arProperties['USER_TYPE'] == 'DateTime'): ?>
						<div class="b-message-form_field b-message-form_date">
							<input id="i-message-form-field-<?=$arProperties['ID']?>" class="inputtext" name="FIELD_<?=$arProperties['ID']?>" type="text" value="<?=$arResult['POST']['FIELD_'.$arProperties['ID']]?>" />
							<?
								$APPLICATION->IncludeComponent(
									'bitrix:main.calendar',
									'',
									array(
										'SHOW_INPUT' => 'N',
										//'FORM_NAME' => 'iblock_add',
										'INPUT_NAME' => 'FIELD_'.$arProperties['ID'],
										'INPUT_VALUE' => $arResult['POST']['FIELD_'.$arProperties['ID']],
										'SHOW_TIME' => 'Y',
										'HIDE_TIMEBAR' => 'Y',
									),
									null,
									array('HIDE_ICONS' => 'Y')
								);
							?>
						</div>
					<? elseif($arProperties['PROPERTY_TYPE'] == 'S'): ?>
						<div class="b-message-form_field b-message-form_text">
							<input id="i-message-form-field-<?=$arProperties['ID']?>" class="inputtext g-input-undo-label" name="FIELD_<?=$arProperties['ID']?>" type="text" value="<?=$arResult['POST']['FIELD_'.$arProperties['ID']]?>" />
						</div>
					<? elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['LIST_TYPE'] == 'L'): ?>
						<div class="b-message-form_field b-message-form_dropdown">
							<select id="i-message-form-field-<?=$arProperties['ID']?>" class="select" name="FIELD_<?=$arProperties['ID']?>">
								<? foreach($arProperties['VALUE_LIST'] as $key => $value): ?>
									<option value="<?=$value['ID']?>"<? if($arResult['POST']['FIELD_'.$arProperties['ID']] == $value['ID']): ?> selected<? endif; ?>><?=$value['VALUE']?></option>
								<? endforeach; ?>
							</select>
						</div>
					<? elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['LIST_TYPE'] == 'C' && $arProperties['MULTIPLE'] == 'N' && count($arProperties['VALUE_LIST']) > 1): ?>
						<div class="b-message-form_field b-message-form_radio">
							<? foreach($arProperties['VALUE_LIST'] as $key => $value): ?>
								<div class="b-message-form_field_item">
									<input id="i-message-form-radio-<?=$value['ID']?>" type="radio" name="FIELD_<?=$arProperties['ID']?>" value="<?=$value['ID']?>"<? if($arResult['POST']['FIELD_'.$arProperties['ID']] == $value['ID']): ?> checked<? endif; ?> />&nbsp;<label for="i-message-form-radio-<?=$value['ID']?>"><?=$value['VALUE']?></label>
								</div>
							<? endforeach; ?>
						</div>
					<? elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['LIST_TYPE'] == 'C' && $arProperties['MULTIPLE'] == 'N' && count($arProperties['VALUE_LIST']) == 1): ?>
						<div class="b-message-form_field b-message-form_checkbox">
							<? foreach($arProperties['VALUE_LIST'] as $key => $value): ?>
								<div class="b-message-form_field_item">
									<input id="i-message-form-checkbox-<?=$value['ID']?>" type="checkbox" name="FIELD_<?=$arProperties['ID']?>" value="<?=$value['ID']?>"<? if(in_array($value['ID'], $arResult['POST']['FIELD_'.$arProperties['ID']])): ?> checked<? endif; ?> />&nbsp;<label for="i-message-form-checkbox-<?=$value['ID']?>"><?=$value['VALUE']?></label>
								</div>
							<? endforeach; ?>
						</div>
					<? elseif($arProperties['PROPERTY_TYPE'] == 'L' && $arProperties['LIST_TYPE'] == 'C' && $arProperties['MULTIPLE'] == 'Y'): ?>
						<div class="b-message-form_field b-message-form_checkbox">
							<? foreach($arProperties['VALUE_LIST'] as $key => $value): ?>
								<div class="b-message-form_field_item">
									<input id="i-message-form-checkbox-<?=$value['ID']?>" type="checkbox" name="FIELD_<?=$arProperties['ID']?>[]" value="<?=$value['ID']?>"<? if(in_array($value['ID'], $arResult['POST']['FIELD_'.$arProperties['ID']])): ?> checked<? endif; ?> />&nbsp;<label for="i-message-form-checkbox-<?=$value['ID']?>"><?=$value['VALUE']?></label>
								</div>
							<? endforeach; ?>
						</div>
					<? elseif($arProperties['PROPERTY_TYPE'] == 'F'): ?>
						<div class="b-message-form_field b-message-form_file">
							<input id="i-message-form-field-<?=$arProperties['ID']?>" class="inputfile" name="FIELD_<?=$arProperties['ID']?>" type="file" value="" />
						</div>
					<? elseif($arProperties['PROPERTY_TYPE'] == 'COLOR_CAPTCHA' && $arParams['USE_CAPTCHA'] == 'COLOR_CAPTCHA'): ?>
						<div class="b-message-form_field b-captcha b-color-captcha">
							<? foreach($arProperties['CAPTCHA_COLORS_USE'] as $key => $arColor): ?>
								<div class="b-captcha_item" title="<?=$arColor['NAME']?>"><span style="background-color: #<?=$arColor['COLOR']?>" code="<?=strtolower($arColor['COLOR'])?>"><?=$arColor['NAME']?></span></div>	
							<? endforeach ?>
							<input type="hidden" id="captcha" name="captcha" value="" />
						</div>
						<div class="b-captcha-text">
							<div class="b-captcha-text_corner"></div>
							<label for="i-message-form-field-<?=$arProperties['ID']?>"><?=$arProperties['NAME']?></label>
						</div>
					<? elseif($arProperties['PROPERTY_TYPE'] == 'GRAHIC_CAPTCHA' && $arParams['USE_CAPTCHA'] == 'GRAHIC_CAPTCHA'): ?>
						<div class="b-message-form_field b-captcha b-grahic-captcha">
							<? foreach($arProperties['CAPTCHA_COLORS_USE'] as $key => $arColor): ?>
								<div class="b-captcha_item" title="<?=$arColor['NAME']?>"><span class="<?=strtolower($arColor['COLOR'])?>" code="<?=strtolower($arColor['COLOR'])?>"><?=$arColor['NAME']?></span></div>	
							<? endforeach ?>
							<input type="hidden" id="captcha" name="captcha" value="" />
						</div>
						<div class="b-captcha-text">
							<div class="b-captcha-text_corner"></div>
							<label for="i-message-form-field-<?=$arProperties['ID']?>"><?=$arProperties['NAME']?></label>
						</div>
					<? endif ?>
					
					<? if($arProperties['HINT']): ?>
						<div class="b-message-form_item-hint">
							&mdash; <?=$arProperties['~HINT']?>
						</div>
					<? endif; ?>

					<? if($arProperties['ERROR']): ?>
						<div class="b-message-form_item-error">
							<?=$arProperties['ERROR']?>
						</div>
					<? endif; ?>

				</div>
			<? endforeach ?>

			<div class="b-message-form_submit">
				<input class="g-button" type="submit" value="<?=$arParams['TEXT_BUTTON']?>" />
			</div>

		</form>
	</div>

<? endif ?>