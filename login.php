<?php
session_start();
$pagetitle = "login";
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include "init.php";
$Test = "";
$asd = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['login']) && $_POST['login'] == "Log-in") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashPassword = sha1($password);
        $login = $_POST['login'];

        $sql = "SELECT 	UserID, Username, Password FROM usres
            WHERE    Username = ?
            AND     Password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($username, $hashPassword));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            $_SESSION['user'] = $username;
            $_SESSION['User_ID'] = $row['UserID'];
            redirectHome("تم تسجيل الدخول", "index.php", 2);
            exit();
        } else {
            redirectHome("لم يتم التسجيل", "back", "2");
        }
    } elseif (isset($_POST['signinc']) && $_POST['signinc'] == "Sign-in") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $avatar = $_FILES['avatar']['name'];
        $password = $_POST['password'];
        $password_agin = $_POST['password-again'];
        $shaPass = "";


        /*================================*/
        /* save path image   */
        /*================================*/


        if (isset($_POST['signinc']) && isset($_FILES['avatar'])) {
            $file_name = $_FILES['avatar']['name'];
            $file_type = $_FILES['avatar']['type'];
            $file_size = $_FILES['avatar']['size'];
            $file_tem_loc = $_FILES['avatar']['tmp_name'];
            $imageRandName = rand(0, 10000000)."_".$file_name;
            $file_store = "layout/images/uploads/" . $imageRandName;
            move_uploaded_file($file_tem_loc, $file_store);

        }


        /*================================*/
        /* save path image   */
        /*================================*/






        $formErrors = array();

        if (isset($_POST['username'])) {
            $filterUser = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            if (strlen($filterUser) < 4) {
                $formErrors[0] = "lanthe username < 4";

            }
        }

        if (isset($_POST['email'])) {
            $filterEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            if (filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true) {
                $formErrors[2] = "Email Not Valid";

            }
        }


        if ($password != $password_agin || empty($password) ||empty($password_agin)) {
            $formErrors[1] = "password error";
//            redirectHome("password error", "back", "4");
//            exit();
        } else {
            $shaPass = sha1($password);
        }

        $resChackItem1 = checkItem("Username", "usres", "$username");
        $resChackItem2 = checkItem("Email", "usres", "$email");
        if ($resChackItem1 != 0 && $resChackItem2 != 0) {
            $asd = $username . "username and email" . $email;
        } elseif ($resChackItem1 != 0) {
            $asd = $username . " username";
        } elseif ($resChackItem2 != 0) {
            $asd = $email . " Email";
        }


        if ($resChackItem1 == 0 && $resChackItem2 == 0 && empty($formErrors)) {
            $sql = "INSERT INTO usres (Username, Password, Email, Fullname, Avatar)
                                VALUES (:username, :password, :email, :fullname, :avatar)";
            $stmt = $conn->prepare($sql);
            try {
                $stmt->execute(array("username" => $username, "password" => $shaPass,
                    "email" => $email, "fullname" => $username, "avatar"=>$imageRandName));
                $res = $stmt->rowCount();
                $lastInsID = $conn->lastInsertId();
                if ($res == 1) {
//                    $_SESSION['user'] = $username;
//                    $_SESSION['User_ID'] = $lastInsID;
//                    redirectHome("تم التسجيل بنجاح", "login.php", 2);
                }
            } catch (PDOException $ex) {
                /*                redirectHome("Duplicate entry <?= $username ?>", "back", 2);*/
            }
        } else {

            if($resChackItem1 != 0 || $resChackItem2 != 0){
                echo "ffffffffcccccccccc";
                $formErrors[3] = "هذا الاسم موجود مسبقا";
            }

//            redirectHome("Duplicate entry $asd", "back", 2);
        }
    }
}
//else {
?>

<div class="main_div">
    <div class="container login-page">
        <h2 class="text-center font-weight-bold mt-5 bg-my-c9">
            <span class="log-in selected h1" data-class="log-in">Login</span> | <span class="h1 sign-up"
                                                                                      data-class="sign-up">Signup</span>
        </h2>
        <form class="login log-in mt-0" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="input-login">
                <input class="form-control mb-2" required="required" type="text" name="username" placeholder="name"
                       autocomplete="off">
            </div>
            <div class="input-login">
                <input class="form-control mb-2" required="required" type="password" name="password"
                       placeholder="password" autocomplete="new-password">
            </div>
            <input class="btn btn-primary btn-block mb-2" type="submit" name="login" value="Log-in">
        </form>







        <form class="login sign-up mt-0" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <div class="input-login">
                <input class="form-control mb-2" required="required" type="text" name="username" placeholder="name"
                       autocomplete="off">
                <p>
                    <?php
                    echo empty($formErrors[0]) ? "" : "<div class='alert alert-secondary p-0' role='alert'> $formErrors[0]</div>";
                    echo empty($formErrors[3]) ? "" : "<div class='alert alert-secondary p-0' role='alert'> $formErrors[3]</div>";
                    ?>
                </p>
            </div>
            <div class="input-login">
                <input class="form-control mb-2" required="required" type="text" name="email" placeholder="Email"
                       autocomplete="off">
                <?php
                echo empty($formErrors[2]) ? "" : "<div class='alert alert-secondary p-0' role='alert'> $formErrors[2]</div>";
                ?>
            </div>
            <div class="input-login">
                <input class="form-control mb-2" required="required" type="password" name="password"
                       placeholder="password"
                       autocomplete="new-password">
                <?php
                echo empty($formErrors[1]) ? "" : "<div class='alert alert-secondary p-0' role='alert'> $formErrors[1]</div>";
                ?>
            </div>
            <div class="input-login">
                <input class="form-control mb-2" required="required" type="password" name="password-again"
                       placeholder="password again"
                       autocomplete="new-password">
            </div>




            <div class="input-login">
                <input class="form-control mb-2" required="required" type="file" name="avatar">
            </div>



            <input class="btn btn-success btn-block mb-2" type="submit" name="signinc" value="Sign-in">
        </form>

    </div>
</div>


<div class="text-center div_error">
    <?php
    if (!empty($formErrors)) {
        foreach ($formErrors as $formError) {
            echo $formError;
        }
    }
    ?>
</div>
<?php
include $tpl . "footer.php";
?>
