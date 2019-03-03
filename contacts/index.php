<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?><div>
</div>
<div>
 <img alt="sopt_location_map_pin_address-512.png" src="/upload/medialibrary/e02/e029d741d5d8d568cf85fdd8f1905d63.png" title="sopt_location_map_pin_address-512.png" width="30" height="50">&nbsp; <b>Адрес:</b> 140073, Московская обл., г.Люберцы, р/п Томилино, мкр. Птицефабрика, строение лит. 2Ж, офис&nbsp;3 <br>
</div>
<div>
	<hr>
</div>
<div>
	 &nbsp;&nbsp;<img alt="sopt phone.png" src="/upload/medialibrary/226/2263d5b9534fe132aa8a3571f575f1e7.png" title="sopt phone.png" width="40" height="34"> <b>Тел.:</b> (495) 744-34-98 <br>
</div>
<div>
	<br>
</div>
<div>
 <img alt="sopt email.png" src="/upload/medialibrary/cfc/cfcc0e625fd28cff35e727f71f62d8d0.png" title="sopt email.png" width="40" height="39"> <b>E-mail:</b> <a href="mailto:info@sopt-komplekt.ru">info@sopt-komplekt.ru</a><br>
</div>
<div>
 <br>
</div>
 <?$APPLICATION->IncludeComponent(
	"bitrix:map.yandex.view",
	"",
	Array(
		"API_KEY" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CONTROLS" => array("ZOOM","SMALLZOOM","TYPECONTROL","SCALELINE"),
		"INIT_MAP_TYPE" => "MAP",
		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:55.65011451519121;s:10:\"yandex_lon\";d:37.92870668373104;s:12:\"yandex_scale\";i:17;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:37.928886560336;s:3:\"LAT\";d:55.650311877199;s:4:\"TEXT\";s:34:\"ООО \"СОПТ-КОМПЛЕКТ\"\";}}}",
		"MAP_HEIGHT" => "400",
		"MAP_ID" => "",
		"MAP_WIDTH" => "1024",
		"OPTIONS" => array("ENABLE_SCROLL_ZOOM","ENABLE_DBLCLICK_ZOOM","ENABLE_RIGHT_MAGNIFIER","ENABLE_DRAGGING")
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>