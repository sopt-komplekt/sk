<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arComponentDescription = array(
   "NAME" => GetMessage("MA_CATALOG_FAVORITE_LIST_NAME"),
   "DESCRIPTION" => GetMessage("MA_CATALOG_FAVORITE_LIST_DESCRIPTION"),
   "SORT" => 10,
   "PATH" => array(
      "ID" => "Media Army",
      "CHILD" => array(
         "ID" => "ma_catalog",
         "NAME" => GetMessage("MA_CATALOG"),
         "SORT" => 30,
      ),
   ),
   "CACHE_PATH" => "N"
);
?>