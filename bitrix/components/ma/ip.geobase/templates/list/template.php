<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<? if (count($arResult["LOCATION_ITEMS"]) > 0) : ?>

<div class="b-location">

    <div class="b-location-holder">

    <? if ($arResult['FAVORITE_ITEMS']): ?>

        <div class="b-location-section">
            <h2>
                Выберите свой город
            </h2>
            <div class="b-location-favorite">
                <ul>
                    <? //dump($arResult["FAVORITE_ITEMS"]);?>
                    <? foreach ($arResult["FAVORITE_ITEMS"] as $id => $arElement): ?>
                        <li class="b-location-favorite-item<? if($arElement['CURRENT'] === 'Y'): ?> current<? endif; ?> ">
                            <a href="<?=$arElement['URL']?>">
                                <?=$arElement["CITY"]?>
                            </a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="b-location-section">
            <h3>
                Или укажите в поле
            </h3>
        
    <? else: ?>

    	<div class="b-location-section">
            <h2>
                Укажите ваш город
            </h2>

    <? endif; ?>

        	<div class="b-location-search">
        		<input type="text" name="q" id="i-location-search" value="" placeholder="Поиск города..." maxLength="50" autocomplete="off">
        	</div>
            
        	<div class="b-location-list">
        		<ul>
        			<? foreach ($arResult["LOCATION_ITEMS"] as $id => $arElement): ?>
        				<li class="b-location-list-item">
        					<a class="g-half-link" href="<?=$arElement['URL']?>">
        						<?=$arElement["CITY"]?>
        					</a>
        				</li>
        			<? endforeach; ?>
        		</ul>
        	</div>

        </div>

    </div>
    
</div>

<script>
    $(document).ready(function(){

        $('#i-location-search').on('keyup', function(eventObject){
            dataSearch($(this).val());
        });

        function dataSearch(wsearch)
        {
            if(wsearch.length > 1){
                $.extend($.expr[":"], {"containsNC": function(elem, i, match, array) { 
                        return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0; 
                    } 
                }); 
                $('.b-location-list').addClass('searched');
                $('.b-location-list-item').removeClass('visible');
                $('.b-location-list-item:containsNC('+wsearch+')').addClass('visible');
            }
            else {
                $('.b-location-list').removeClass('searched');
                $('.b-location-list-item').removeClass('visible');
            }
        }

    });
</script>

<? endif; ?>