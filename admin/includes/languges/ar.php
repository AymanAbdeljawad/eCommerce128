<?php

function lang($phrase)
{
    static $lang = array(
        "masseg" => "مرحبا",
        "admin" => "المدرين",
        "HOME_ADMIN" => "مدير",
        "Catacties" => "الاقسام",
        "Comment" => "التعليقات",
        "Edite_Profile" => "الملف الشخصي",
        "Stinge" => "الاعدادات",
        "LogOut" => "خروج",
    );
    return $lang[$phrase];
}


//
//$lang = array(
//    'ayman' => 'gawad'
//);
//echo $lang['ayman'];
?>