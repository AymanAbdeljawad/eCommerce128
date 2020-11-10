<?php


/*=========================== front end function =====================*/


//redirect function

function redirectHome($showMasseg, $urlRedirect = null, $timeRedirect = 3)
{?>
    <div class="alert alert-info" role="alert"><?= $showMasseg ?></div>
    <div class="alert alert-info" role="alert">you will be you directory to hom page aftar
        sacond <?= $timeRedirect ?></div>
    <?php
    if ($urlRedirect == null) {
        $urlRedirect = "index.php";
    }elseif ($urlRedirect == "back") {
        if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== "") {
            $urlRedirect = $_SERVER["HTTP_REFERER"];
        } else {
            $urlRedirect = "index.php";
        }
    } else {
        $urlRedirect = $urlRedirect;
    }
    header("refresh:$timeRedirect; url=$urlRedirect");
    exit();
}















function getCats($where = "null"){
    global $conn;
    $satmentCat = $conn->prepare("SELECT * FROM categories $where ORDER BY Cat_ID ASC");
    $satmentCat->execute();
    $categories = $satmentCat->fetchAll();
    return $categories;
}


function getItems($where, $value, $approve = null){
    global $conn;
    if($approve == null){
        $qury = "AND Approve =  1 OR Approve = 0 ";
    }else{
        $qury = "AND Approve = 0";
    }
    $sqlItem = "SELECT * FROM items WHERE $where = ? $qury ORDER BY Name DESC ";
    $stmtItem = $conn->prepare($sqlItem);
    $stmtItem->execute(array($value));
    $rowsitems = $stmtItem->fetchAll();

    return $rowsitems;
}


function chackUserGegStat($user)
{
    global $conn;
    $sql = "SELECT 	 Username, RegStatus FROM usres
            WHERE    Username = ?
            AND     RegStatus = 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($user));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    return $count;
}


/*=========================== front end function =====================*/


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




//function check username or Email item database  checkItemDBUsernameOrEmail


function checkItem($select, $fromTable, $valueItemCheck)
{
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





/*
 *
 * function get count row in database using UserID
 *
 *
 */
function getCountRowUsUserID($selectCount = "UserID", $fromTable = "usres")
{
    global $conn;
    $sql = "SELECT COUNT($selectCount)  FROM $fromTable";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchColumn();
    return $res;
}



function getLatest($select, $fromtable, $coOrBy, $descOrAsc, $limit)
{
    global $conn;
    $sql = "SELECT $select FROM $fromtable   ORDER BY $coOrBy $descOrAsc LIMIT $limit ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $resAll = $stmt->fetchAll();
    return $resAll;

}

?>