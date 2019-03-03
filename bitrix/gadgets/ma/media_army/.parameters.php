<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arParameters = Array(
	"PARAMETERS"=> Array(),
	"USER_PARAMETERS" => Array (
		"HOSTING"=> Array (
			"NAME" => GetMessage("GD_MEDIA_ARMY_HOSTING"),
			"TYPE" => "STRING",
			"DEFAULT" => ""
		),
		"HOSTING_URL"=> Array (
			"NAME" => GetMessage("GD_MEDIA_ARMY_HOSTING_URL"),
			"TYPE" => "STRING",
			"DEFAULT" => ""
		),
		"HOSTING_TYPE"=> Array (
			"NAME" => GetMessage("GD_MEDIA_ARMY_HOSTING_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => Array(
				"SHARED" => GetMessage("GD_MEDIA_ARMY_HOSTING_TYPE_SHARED"),
				"CLOUD_SHARED" => GetMessage("GD_MEDIA_ARMY_HOSTING_TYPE_CLOUD_SHARED"),
				"VDS" => GetMessage("GD_MEDIA_ARMY_HOSTING_TYPE_VDS"),
				"CLOUD_VDS" => GetMessage("GD_MEDIA_ARMY_HOSTING_TYPE_CLOUD_VDS"),
				"DEDICATED" => GetMessage("GD_MEDIA_ARMY_HOSTING_TYPE_DEDICATED"),
				"COLOCATION" => GetMessage("GD_MEDIA_ARMY_HOSTING_TYPE_COLOCATION")
			)
		),
		"TARIFF"=> Array (
			"NAME" => GetMessage("GD_MEDIA_ARMY_TARIFF"),
			"TYPE" => "STRING",
			"DEFAULT" => ""
		),
		"TARIFF_SETTINGS"=> Array (
			"NAME" => GetMessage("GD_MEDIA_ARMY_TARIFF_SETTINGS"),
			"TYPE" => "STRING",
			"DEFAULT" => ""
		)
	)
);

if($arAllCurrentValues["HOSTING_TYPE"]["VALUE"] == "SHARED" || $arAllCurrentValues["HOSTING_TYPE"]["VALUE"] == "CLOUD_SHARED" ) {
	$arParameters["USER_PARAMETERS"]["DISK_SPACE"] = array(
		"NAME" => GetMessage("GD_MEDIA_ARMY_DISK_SPACE"),
		"TYPE" => "STRING",
		"DEFAULT" => "",

	);
}

?>
