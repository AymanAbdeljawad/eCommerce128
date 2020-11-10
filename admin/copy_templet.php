<?php
ob_start();
session_start();
$pagetitle = "mubere";
/*
 * ========================================================
 *  manage or users mumber page
 *  you can add | edite | delete mumber from hear
 * ========================================================
*/

if (isset($_SESSION['username'])) {
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";
    $id = isset($_GET['id']) ? $_GET['id'] : "0";





    if ($do == "manage") {
        echo "manage";
    } elseif ($do == "add") {
        echo "add";
    } elseif ($do == "insert") {
        echo "insert";
    } elseif ($do == "edite") {
        echo "edite";
    } elseif ($do == "update") {
        echo "update";
    } elseif ($do === "delete") {
        echo "delete";
    } elseif ($do === "activet") {
        echo "activet";
    } else {
        echo "else are";
    }
    include $tpl . "footer.php";
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>
