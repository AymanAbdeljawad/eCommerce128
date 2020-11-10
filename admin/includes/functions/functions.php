<?php

//function spcjal title pages
function getTitle()
{
    global $pagetitle;
    if (isset($pagetitle)) {
        return $pagetitle;
    } else {
        $pagetitle = "defualttitle";
    }
    return $pagetitle;
}


//redirect function

function redirectHome($showMasseg, $urlRedirect = null, $timeRedirect = 3)
{
    ?>
    <div class="alert alert-info" role="alert"><?= $showMasseg ?></div>
    <div class="alert alert-info" role="alert">you will be you directory to hom page aftar
        sacond <?= $timeRedirect ?></div>
    <?php

    if ($urlRedirect == null) {
        $urlRedirect = "index.php";
    } elseif ($urlRedirect == "back") {
       if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"]!==""){
           $urlRedirect = $_SERVER["HTTP_REFERER"];
       }else{
           $urlRedirect = "index.php";
       }
    } else {
        $urlRedirect = $urlRedirect;
    }


    header("refresh:$timeRedirect; url=$urlRedirect");
    exit();
}

//function check username or Email item database  checkItemDBUsernameOrEmail







function checkItem($select, $fromTable, $valueItemCheck){
    global $conn;
    $sqlStat = "SELECT $select FROM $fromTable WHERE $select = ? ";
    $satment = $conn->prepare($sqlStat);
    $satment->execute(array($valueItemCheck));
    $resf = $satment->rowCount();
    if ($resf > 0) {
        return $resf;
    } else {
        return 0;
    }

}












//====================function checkItemDBUsernameOrEmail($select, $fromTable, $itemWhereCheck = array(), $valueItemCheck = array()){
//    global $conn;
//    $sqlStat = "SELECT $select FROM $fromTable WHERE $itemWhereCheck[0] = ? OR $itemWhereCheck[1] = ?";
//    $satment = $conn->prepare($sqlStat);
//    $satment->execute(array($valueItemCheck[0], $valueItemCheck[1]));
//    $resf = $satment->rowCount();
//    if ($resf > 0) {
//        return 1;
//    } else {
//        return 0;
//    }
//
//}

//==================function check user ID item database
//function checkItemDBUserId($select, $fromTable, $itemWhereCheck, $valueItemCheck){
//    global $conn;
//    $sqlStat = "SELECT $select FROM $fromTable WHERE $itemWhereCheck = ? ";
//
//    $satment = $conn->prepare($sqlStat);
//    $satment->execute(array($valueItemCheck));
//    $resf = $satment->rowCount();
//    if ($resf > 0) {
//        return 1;
//    } else {
//        return 0;
//    }
//}


/*
 *
 * function get count row in database using UserID
 *
 *
 */
function getCountRowUsUserID($selectCount = "UserID", $fromTable ="usres" ){
    global $conn;
    $sql = "SELECT COUNT($selectCount)  FROM $fromTable";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchColumn();
    return $res;
}


//function getCountRowpindingUsRegStatus($selectCount = "UserID", $fromTable ="usres",$RegStatus =0 ){
//    global $conn;
//    $sql = "SELECT COUNT($selectCount)  FROM $fromTable WHERE RegStatus = $RegStatus ";
//    $stmt = $conn->prepare($sql);
//    $stmt->execute();
//    $res = $stmt->fetchColumn();
//    return $res;
//}




/*
 *
 * function get latest
 *
 */

function getLatest($select, $fromtable, $coOrBy, $descOrAsc, $limit ){
    global $conn;
    $sql = "SELECT $select FROM $fromtable   ORDER BY $coOrBy $descOrAsc LIMIT $limit ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resAll = $stmt->fetchAll();
    return $resAll;

}

?>