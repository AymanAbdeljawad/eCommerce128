<?php
session_start();
$noNavBar = "";
$pagetitle = "login";
if(isset($_SESSION['username'])){
    header('Location: dashboard.php');
}
include "init.php";

?>
<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashPassword = sha1($password);
    $login = $_POST['login'];

    $sql = "SELECT 	UserID, Username, Password FROM usres
            WHERE    Username = ?
            AND     Password = ?
            AND 	GroupID = 1 LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($username, $hashPassword));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){
        $_SESSION['username'] = $username;
        $_SESSION['UserID'] = $row['UserID'];
//        header('Location: dashboard.php');
//        exit();

        redirectHome("تم تسجيل الدخول", "dashboard.php", 2);



    }


}

?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <p class="text-center font-weight-bold h2 text-info mb-3">Admin Login</p>
    <input class="form-control mb-3 " type="text" name="username" placeholder="username" autocomplete="off">
    <input class="form-control mb-3" type="password" name="password" placeholder="password" autocomplete="new-password">
    <input class="btn btn-block badge-primary mb-3" type="submit" name="login" value="login">
</form>


<?php include $tpl . "footer.php"; ?>
