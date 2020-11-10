<?php

function lang($phrase)
{
    static $lang = array(
        "masseg" => "welcome",
        "admin" => "adminstration",
        //navbar phrase Linkes
        "HOME_ADMIN" => "Admin",
        "Categoris" => "Categoris",
        "Edite_Profile" => "Edite_Profile",
        "Stinge" => "Stinge",
        "LogOut" => "LogOut",
        "Items" => "Items",
        "Members" => "Members",
        "Statices" => "Statices",
        "Comment" => "Comment",
        "Logs" => "Logs",
    );
    return $lang[$phrase];
}


//
//$lang = array(
//    'ayman' => 'gawad'
//);
//echo $lang['ayman'];
?>