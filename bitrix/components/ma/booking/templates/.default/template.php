<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<? if($arResult['GRID']['COLS_HEADERS'] && $arResult['GRID']['ROWS_HEADERS']): ?>

	<div class="b-booking-detail_table" id="table">

		<?if($arResult['GRID']['HEADER']):?>
		    <div class="b-booking-detail_table_header">
		        <a class="" href="<?=$arResult['PAGENAVIGATION']['BACK_LINK']?>">Назад</a>
		        <span><?=$arResult['GRID']['HEADER']?></span>
		         <a class="" href="<?=$arResult['PAGENAVIGATION']['FWD_LINK']?>">Вперед</a>
		    </div>
		<?endif;?>
		
		<div class="b-booking-detail_table_main">

			<table>
				<thead>
					<th>Время</th>
					<?foreach($arResult['GRID']['COLS_HEADERS'] as $col):?>
						<th data-date="<?=$col['DATE_FULL']?>">
							<label>
								<input
									type="checkbox"
									data-id="<?foreach($col['IDS'] as $id){echo($id).';';}?>"
									id="<?=mktime(0,0,0,$col['MONTH'],$col['DAY'],$col['YEAR'])?>"
									<?
										$i = 0;
										foreach ($col['IDS'] as $key => $id) {
											if(in_array($id,$_SESSION['BOOKING'])) {
												$i++;
											}
											if($col['TOTAL_IDS'] == $i) {
												echo('checked="checked"');
											}
										}
									?>
								>
								<span>
									<?=$col['DAY_OF_WEEK_ABBR']?>, <?=$col['DAY']?>
								</span>
							</label>
						</th>
					<?endforeach;?>
				</thead>
				<tbody>
					<?
						$colsindep = array();
						$j = 0;
					?>
					<?foreach($arResult['GRID']['ROWS_HEADERS'] as $r => $row):?>
						<tr>
							<td class="row-header"><?=$row['NAME']?></td>
							<?$i = 0;?>
							<?foreach($arResult['GRID']['COLS_HEADERS'] as $c => $cell):?>
								<?
									$id = mktime($row['HOURS'],$row['MINUTES'],0,$cell['MONTH'],$cell['DAY'],$cell['YEAR']);
									$fulltime = rdate('d.m.Y H:i:s',$id);
									$class = '';
									$rowspan = false;
									foreach ($arResult['ITEMS'] as $key => $arItem) {
										foreach ($arItem['TIMES'] as $v => $time) {
											if ($fulltime == $time[0]) {
												$class = 'booking';
												$rowspan = count($time);
											}
										}
									}
									if(in_array($id, $arResult['GRID']['EXEC'])) {
										continue;
									}
								?>
								<td
									data-date="<?=$cell['DATE_FULL']?>"
									data-time="<?=$row['NAME']?>"
									id=<?=$id?>
									class="<?=$class?><?if(in_array($id,$_SESSION['BOOKING'])):?> selected<?endif;?>"
									<?if($rowspan):?>
										rowspan="<?=$rowspan?>"
									<?endif;?>
								>
									<?if(!empty($class)):?>
										<?= $arParams['TEXT_BOOKING'] ? $arParams['TEXT_BOOKING'] : GetMessage('TEXT_BOOKING')?>
									<?elseif(in_array($id,$_SESSION['BOOKING'])):?>
										<?=$arParams['TEXT_SELECTED'] ? $arParams['TEXT_SELECTED'] : GetMessage('BOOKING_SELECTED')?>
									<?endif;?>
									<? $class = ''; ?>
								</td>
								<?$i++;?>
							<?endforeach;?>
							<?$j++;?>
						</tr>
					<?endforeach;?>
				</tbody>
			</table>

		</div>

		<div class="b-booking-detail_table_bottom">
        	<!-- <a href="/booking/form/?FIELD_130=Конференц-зал строение №1" class="g-button g-ajax-data">Забронировать выбранные дату и время</a> -->
        	<a href="/booking/form/" class="g-button g-ajax-data">Забронировать выбранные дату и время</a>
    	</div>

	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			//var linkedElement = '<?//=$arResult['LINKED_ELEMENT']?>',
			//	mainHref = $('.b-booking-detail_table_bottom a').attr('href');
			<?/*if(isset($arResult['FIRST_LINK']) && !empty($arResult['FIRST_LINK'])):?>
				var firstPropValueText = '<?=$arResult['FIRST_LINK']['TEXT']?>';
				var firstPropValueString = '<?=$arResult['FIRST_LINK']['STRING']?>';
				console.log(firstPropValueText);
				console.log(firstPropValueString);
				if(mainHref.indexOf('?') + 1) {
					var linkHref = mainHref+'&FIELD_130='+linkedElement+'&FIELD_<?=$arParams['TEXT_ELEMENT_PROPERTY']?>='+firstPropValueText+'&FIELD_<?=$arParams['STRING_ELEMENT_PROPERTY']?>='+firstPropValueString;
				} else {
					var linkHref = mainHref+'?FIELD_130='+linkedElement+'&FIELD_<?=$arParams['TEXT_ELEMENT_PROPERTY']?>='+firstPropValueText+'&FIELD_<?=$arParams['STRING_ELEMENT_PROPERTY']?>='+firstPropValueString;
				}
				$('.b-booking-detail_table_bottom a').attr('href',linkHref);
			<?endif;*/?>

			function settimestamp(elem){
				var id = elem.attr('id'),
					href = window.location.href;
				if(href.indexOf('?') + 1) {
					href = href+'&add='+id;
				} else {
					href = href+'?add='+id;
				};
				$.ajax({
					type: 'POST',
					url: href,
					cache: false,
					success: function(data, el, responce){
/*						var result = $.parseJSON(data),
							propValueText = result.text,
							propValueString = result.string;
						if(mainHref.indexOf('?') + 1) {
							var linkhref = mainHref+'&FIELD_130='+linkedElement+'&FIELD_<?//=$arParams['TEXT_ELEMENT_PROPERTY']?>='+propValueText+'&FIELD_<?//=$arParams['STRING_ELEMENT_PROPERTY']?>='+propValueString;
						} else {
							var linkHref = mainHref+'?FIELD_130='+linkedElement+'&FIELD_<?//=$arParams['TEXT_ELEMENT_PROPERTY']?>='+propValueText+'&FIELD_<?//=$arParams['STRING_ELEMENT_PROPERTY']?>='+propValueString;
						}
						$('.b-booking-detail_table_bottom a').attr('href',linkHref);
						$('.b-booking-detail_table_bottom a').removeAttr('disabled');*/
					},
					error: function(){
						$('#'+id).removeClass('selected')
					}
				});
			};

			function removetimestamp(elem){
				var id = elem.attr('id'),
					href = window.location.href;
				if(href.indexOf('?') + 1) {
					href = href+'&del='+id;
				} else {
					href = href+'?del='+id;
				};
				$.ajax({
					type: 'POST',
					url: href,
					cache: false,
					success: function(data, el, responce){
/*						var result = $.parseJSON(data),
							propValueText = result.text,
							propValueString = result.string;
						if(mainHref.indexOf('?') + 1) {
							var linkhref = mainHref+'&FIELD_130='+linkedElement+'&FIELD_<?//=$arParams['TEXT_ELEMENT_PROPERTY']?>='+propValueText+'&FIELD_<?//=$arParams['STRING_ELEMENT_PROPERTY']?>='+propValueString;
						} else {
							var linkHref = mainHref+'?FIELD_130='+linkedElement+'&FIELD_<?//=$arParams['TEXT_ELEMENT_PROPERTY']?>='+propValueText+'&FIELD_<?//=$arParams['STRING_ELEMENT_PROPERTY']?>='+propValueString;
						}
						$('.b-booking-detail_table_bottom a').attr('href',linkHref);
						$('.b-booking-detail_table_bottom a').removeAttr('disabled');*/
					},
					error: function(){
						$('#'+id).addClass('selected')
					}
				});
			};

			function settimestampcol(ids,id){
				var elements = JSON.stringify(ids.split(';')),
					href = window.location.href;
				if(href.indexOf('?') + 1) {
					href = href+'&addarray='+elements;
				} else {
					href = href+'?addarray='+elements;
				};
				$.ajax({
					type: 'POST',
					url: href,
					cache: false,
					success: function(data, el, responce){},
					error: function(){
						var selector = $('#'+id).parents('th').data('date'),
							selectedCells = $('#table td[data-date="'+selector+'"]');
						selectedCells.removeClass('selected');
						selectedCells.text('');
					}
				});
			}

			function removetimestampcol(ids,id){
				var elements = JSON.stringify(ids.split(';')),
					href = window.location.href;
				if(href.indexOf('?') + 1) {
					href = href+'&delarray='+elements;
				} else {
					href = href+'?delarray='+elements;
				};
				$.ajax({
					type: 'POST',
					url: href,
					cache: false,
					success: function(data, el, responce){},
					error: function(){
						var selector = $('#'+id).parents('th').data('date'),
							selectedCells = $('#table td[data-date="'+selector+'"]');
						selectedCells.addClass('selected');
						selectedCells.text('');
					}
				});
			}

			$('#table td:not(.booking)').hover(
				function(){
					if(!$(this).hasClass('selected') && !$(this).hasClass('row-header')) {
						$(this).text('<?=$arParams['TEXT_HOVER'] ? $arParams['TEXT_HOVER'] : GetMessage('BOOKING_SELECT')?>');
					}
				},function(){
					if(!$(this).hasClass('selected') && !$(this).hasClass('row-header')) {
						$(this).text('');
					}
				}
			);

			$('#table').on('click','td:not(.row-header):not(.booking)',function(){
				if($(this).hasClass('selected')) {
					$(this).removeClass('selected');
					$(this).text('');
					removetimestamp($(this));
				} else {
					$(this).addClass('selected');
					$(this).text('<?=$arParams['TEXT_SELECTED'] ? $arParams['TEXT_SELECTED'] : GetMessage('BOOKING_SELECTED')?>');
					settimestamp($(this));
				}
			});

			$('#table input[type=checkbox]').on('change',function(){
				var selector = $(this).parents('th').data('date');
				var selectedCells = $('#table td[data-date="'+selector+'"]:not(.booking)');
				if($(this).attr('checked') == 'checked') {
					selectedCells.addClass('selected');
					selectedCells.text('<?=$arParams['TEXT_SELECTED'] ? $arParams['TEXT_SELECTED'] : GetMessage('BOOKING_SELECTED')?>');
					var ids = $(this).data('id'),
						id = $(this).attr('id');
					settimestampcol(ids,id);
				} else {
					selectedCells.removeClass('selected');
					selectedCells.text('');
					var ids = $(this).data('id'),
						id = $(this).attr('id');
					removetimestampcol(ids,id);
				}
			});

		});
	</script>

<? endif ?>