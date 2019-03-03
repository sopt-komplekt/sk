<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arComponentDescription = array(
   "NAME" => GetMessage("MA_CATALOG_FAVORITE_RESULT_NAME"),
   "DESCRIPTION" => GetMessage("MA_CATALOG_FAVORITE_RESULT_DESCR"),
   "SORT" => 10,
   "PATH" => array(
      "ID" => "Media Army",
      "CHILD" => array(
         "ID" => "ma_catalog",
         "NAME" => GetMessage("T_IBLOCK_DESC_CATALOG"),
         "SORT" => 30,
      ),
   ),
   "CACHE_PATH" => "N"
);
?>