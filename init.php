<?php
//Routes

ini_set("display_errors", "on");
error_reporting(E_ALL);
include "admin/connect.php";
$fun = "includes/functions/";
$tpl = 'includes/templets/';  //templet Directory
$css = "layout/css/"; //css directory
$font = "layout/fonts/"; //font directory
$js = "layout/js/"; //font dirictory
$lang = "includes/languges/"; //dirictory languages


include $fun . "functions.php";
include $lang . 'en.php';
include $tpl . "header.php";



?>