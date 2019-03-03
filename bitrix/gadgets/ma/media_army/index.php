<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$bxProductConfig = array();
if(file_exists($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/.config.php"))
	include($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/.config.php");

if(isset($bxProductConfig["admin"]["index"]))
	$sProduct = $bxProductConfig["admin"]["index"];
else
	$sProduct = GetMessage("GD_INFO_product").' «'.GetMessage("GD_INFO_product_name_".COption::GetOptionString("main", "vendor", "1c_bitrix")).'#VERSION#».';
$sVer = ($GLOBALS['USER']->CanDoOperation('view_other_settings')? " ".SM_VERSION : "");
$sProduct = str_replace("#VERSION#", $sVer, $sProduct);

$hostingTypes = Array(
	"SHARED" => "Виртуальный хостинг",
	"CLOUD_SHARED" => "Облачный хостинг",
	"VDS" => "VDS",
	"CLOUD_VDS" => "Облачный VDS",
	"DEDICATED" => "Выделенный сервер",
	"COLOCATION" => "Colocation"
)

?>
<style type="text/css">
	.bx-gadgets-info {
		padding: 15px;
		font: 13px/1.4 "Helvetica Neue", Helvetica, Arial, sans-serif;
	}
	.b-ma-info {
		overflow: hidden;
		padding-top: 5px;
	}
		.b-ma-logo {
			margin-bottom: 10px;
		}
		.b-ma-test {
			margin-top: 10px;
		}
		.b-ma-test .b-ma-button {
		    display: inline-block;
		    margin: 0;
		    padding: 8px 14px 7px;
		    background: #FFF;
		    color: #f04949 !important;
		    font: normal 18px/1, sans-serif;
		    text-decoration: none !important;
		    border: 1px solid #f04949;
		    border-radius: 3px;
		    outline: none;
		    cursor: pointer;
		    transition: background-color 0.2s, color 0.2s;
		}
		.b-ma-test .b-ma-button:hover {
		    background: #f04949;
		    color: #fff !important;
		}
	.b-ma-services {
		float: right;
		width: 50%;
		margin-left: 20px;
		padding-top: 5px;
	}
		.b-ma-services_item {
			margin: 0 0 10px;
			overflow: hidden;
		}
			.b-ma-services_pic {
				float: left;
				width: 40px;
				margin: 5px 10px 0 0;
				text-align: center;
			}
			.b-ma-services_pic img {
				max-width: 100%;
			}
			.b-ma-services_title {
				padding-top: 5px;
				margin-bottom: 3px;
				overflow: hidden;
			}
				.b-ma-services_title, .b-ma-services_title a {
					color: #000 !important;
					font-size: 16px !important;
					font-weight: bold;
					text-transform: uppercase;	
					font-family: "PT Sans", Arial, sans-serif;
					text-decoration: none;
				}
			.b-ma-services_text {
				overflow: hidden;
				line-height: 1.0;
			}
	.b-ma-hosting {

	}
		.b-ma-hosting_title {
			margin-bottom: 10px;
			font-size: 15px;
		}
		.b-ma-hosting_item {
			margin-top: 5px;
		}
	.b-ma-border {
		clear: both;
		height: 1px;
		margin: 15px 0; 
		background-color: #e2ebed;
	}
	.b-ma-disc-space-full {
		height: 3px;
		margin: 7px 0 0;
		background-color: #14b625;
	}
		.b-ma-disc-space-busy {
			height: 100%;
			background-color: #ed4b4e;
		}
</style>
<div class="bx-gadgets-info">
	<?
	echo '<pre>';
	// print_r($arGadgetParams);
	// print_r($_SERVER);
	echo '</pre>';
	?>
	<div class="b-ma-services">
		<div class="b-ma-services_item">
			<div class="b-ma-services_pic">
				<a href="http://media-army.ru/services/promotion/seo/" target="_blank"><img src="/bitrix/gadgets/ma/media_army/img/ma-seo_ico.png" alt="" width="40"></a>
			</div>
			<div class="b-ma-services_title">
				<a href="http://media-army.ru/services/promotion/seo/" target="_blank">Продвижение</a>
			</div>
			<div class="b-ma-services_text">Cайт на первом месте в поиске</div>
		</div>
		<div class="b-ma-services_item">
			<div class="b-ma-services_pic">
				<a href="http://media-army.ru/services/promotion/direct/" target="_blank"><img src="/bitrix/gadgets/ma/media_army/img/ma-direct_ico.png" alt="" width="40"></a>
			</div>
			<div class="b-ma-services_title">
				<a href="http://media-army.ru/services/promotion/direct/" target="_blank">Реклама</a>
			</div>
			<div class="b-ma-services_text">Доступно и точно в цель</div>
		</div>
		<div class="b-ma-services_item">
			<div class="b-ma-services_pic">
				<a href="http://media-army.ru/services/progress/support-site/" target="_blank"><img src="/bitrix/gadgets/ma/media_army/img/ma-support_ico.png" alt="" width="38"></a>
			</div>
			<div class="b-ma-services_title">
				<a href="http://media-army.ru/services/progress/support-site/" target="_blank">Техподдержка</a>
			</div>
			<div class="b-ma-services_text">Cайт всегда под присмотром</div>
		</div>
	</div>
	<div class="b-ma-info">
		<div class="b-ma-logo">
			<img src="/bitrix/gadgets/ma/media_army/img/ma_logo.png" alt="Media Army" style="width: 140px;" />
		</div>
		<div><?=GetMessage('GD_MA_TITLE_CREATED')?>: <a href="http://media-army.ru" target="_blank">media-army.ru</a></div>
		<!-- <div><?=GetMessage('GD_MA_TITLE_EMAIL')?>: <a href="http://media-army.ru/support/" target="_blank">media-army.ru/support/</a></div> -->
		<div class="b-ma-test">
			<?=GetMessage('GD_MA_TEXT')?>
		</div>
		<div class="b-ma-test">
			<a class="b-ma-button" href="http://media-army.ru/feedback/" target="_blank">Оставить заявку</a>
		</div>
	</div>
	<div class="b-ma-border"></div>

	<div class="b-ma-hosting">
		<? if (!empty($arGadgetParams['HOSTING'])): ?>
				<div class="b-ma-hosting_title">
					<b>Информация о хостинге</b>
				</div>
				<div class="b-ma-hosting_item">
					Сайт размещен на хостинге:
					<? if (!empty($arGadgetParams['HOSTING_URL'])): ?>
						<a href="<? echo $arGadgetParams['HOSTING_URL']?>" target="_blank">
							<? echo $arGadgetParams['HOSTING']?>
						</a>
						<? else: ?>
							<? echo $arGadgetParams['HOSTING']?>
						<? endif; ?>

					<? if (!empty($arGadgetParams['HOSTING_TYPE'])): ?>
						(<? echo $hostingTypes[$arGadgetParams['HOSTING_TYPE']]?>)
					<? endif; ?>
				</div>
			<? if (!empty($arGadgetParams['TARIFF'])): ?>
				<div class="b-ma-hosting_item">
					Тарифный план: <? echo $arGadgetParams['TARIFF']?>
						<? if (!empty($arGadgetParams['TARIFF_SETTINGS'])): ?>
							(<? echo $arGadgetParams['TARIFF_SETTINGS']?>)
						<? endif; ?>
				</div>
			<? endif; ?>
		<? endif; ?>
		<div class="b-ma-hosting_item">
			<?
			if(($arGadgetParams["HOSTING_TYPE"] == "SHARED" || $arGadgetParams["HOSTING_TYPE"] == "CLOUD_SHARED") && $arGadgetParams["DISK_SPACE"]){
				$dt = $arGadgetParams["DISK_SPACE"]*1024;

				$f = '../../';
				$io = popen('/usr/bin/du -sk ' . $f, 'r');
				$size = fgets ($io, 4096);
				$size = substr ( $size, 0, strpos ( $size, "\t" ) );
				pclose ($io);

				if ($size > 0) {
					$size = round($size/(1024), 2);
				}
				$df = round(($dt - $size)/1024,2);
				$dt = $dt/1024;
				$db = $dt - $df;
			} else {
				$dt = disk_total_space('/');
				$df = disk_free_space("/");
				$db = ($dt - $df)/(1024*1024*1024);
				$df = round($df/(1024*1024*1024), 2);
				$dt = round($dt/(1024*1024*1024), 2);
			}
			?>
			<div class="b-ma-disc-space-text">
				<?=GetMessage("GD_INFO_HOSTING_DISK_SPACE");?>: <?=GetMessage("GD_INFO_HOSTING_DISK_SPACE_FREE");?> <?=$df?> <?=GetMessage("GD_INFO_GB");?> <?=GetMessage("GD_INFO_ON");?> <?=$dt?> <?=GetMessage("GD_INFO_GB");?>
			</div>
			<div class="b-ma-disc-space-full">
				<div class="b-ma-disc-space-busy" style="width: <?=$db/$dt*100?>%;"></div>
			</div>				
		</div>
	</div>
	<div class="b-ma-border"></div>



	<div class="bx-gadgets-text">
		<?=$sProduct ?><br>
		<?$last_updated = COption::GetOptionString("main", "update_system_update", "-");?>
		<?=str_replace("#VALUE#", $last_updated, GetMessage("GD_INFO_LASTUPDATE"));?>
		<!--
		<?if(IsModuleInstalled("perfmon") && $GLOBALS["APPLICATION"]->GetGroupRight("perfmon") != "D"):
			$mark_value = (double)COption::GetOptionString("perfmon", "mark_php_page_rate", "");
			if($mark_value < 5)
				$mark_value = GetMessage("GD_PERFMON_NO_RESULT");
			?><?=str_replace("#VALUE#", $mark_value, GetMessage("GD_INFO_PERFMON"));?><br><?
		endif;?>
		<?
		if ($GLOBALS["USER"]->CanDoOperation('view_all_users')):
			$user_count = CUser::GetCount();
			?><?=str_replace("#VALUE#", $user_count, GetMessage("GD_INFO_USERS"));?><br><?
		endif;
		?>
		-->
	</div>
</div>