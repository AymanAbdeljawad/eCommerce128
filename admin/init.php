<?php

//Routes
include "connect.php";
$fun = "includes/functions/";
$tpl = 'includes/templets/';  //templet Directory
$css = "layout/css/"; //css directory
$font = "layout/fonts/"; //font directory
$js = "layout/js/"; //font dirictory
$lang = "includes/languges/"; //dirictory languages


include $fun . "functions.php";
include $lang . 'en.php';
include $tpl . "header.php";

//incloud navbar all pages on no navbar page varable

if (!isset($noNavBar)) {
    include $tpl . "navbar.php";
}

?>