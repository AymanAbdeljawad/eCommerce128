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
    /*
     * Manager page  Get Usre From Data Bases  جلب الاعضاء من قاعده البيانات
     *
   */
    if ($do == "manage") {   //manger redirect

        $query = "";
        $regStat = "";
        if (isset($_GET["page"]) && $_GET["page"] == "panding") {
            $query = "AND RegStatus = 0";
        } elseif ((isset($_GET["page"]) && $_GET["page"] == "userAvation")) {
            $query = "AND RegStatus = 1";
            $regStat = 1;
        } else {
            $query = "";
            $regStat = "";
        }


        $sql = "SELECT * FROM usres WHERE GroupID != 1 $query";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        ?>

        <h2 class="text-center title-muber">Manage User</h2>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered text-center">
                    <tr class="bg-dark">
                        <th>#id</th>
                        <th>user Name</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Regestar Date</th>
                        <th><i class="fa fa-edit"></i>Edit</th>
                        <th><i class="fa fa-trash"></i>Delete</th>
                        <?php
                        if (!$regStat == 1) {
                            ?>
                            <th><i class="fa fa-trash"></i>Active</th>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                    foreach ($rows as $row) {
                        ?>
                        <tr>
                            <td><?= $row['UserID'] ?></td>
                            <td><?= $row['Username'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['Fullname'] ?></td>
                            <td><?= $row['RegusterDate'] ?></td>
                            <td><a href="?do=edite&id=<?= $row['UserID'] ?>&gid=0" class="btn btn-success"><i
                                        class="fa fa-edit"></i>Edit</a></td>
                            <td><a href="?do=delete&id=<?= $row['UserID'] ?>" class="btn btn-danger confirm"><i
                                        class="fa fa-trash"></i>Delete</a></td>
                            <?php
                            if ($row['RegStatus'] == 0) {
                                ?>
                                <td><a href="?do=activet&id=<?= $row['UserID'] ?>&gid=0" class="btn btn-info"><i
                                        class="fa fa-edit"></i>Active</a></td><?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <a class="btn btn-primary w-25 d-block m-auto pr-3 font-weight-bold" href="?do=add">
                <!--Go to add New User In Database  انشاء عضو جديد-->
                <i class="fa fa-plus"></i>Add New user
            </a>
        </div>
        <?php

        //======================           End Manager page  Get Usre From Data Bases   انتهاء جلب الاعضاء من قاعده البيانات   =====================================


        /*
         *
         * Start Edit page صفحه التعديل علي بيانات الاعضاء =>  go to Update
         *
         *
         */

    } elseif ($do == "edite") {
        $userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $gid = isset($_GET['gid']) ? $_GET['gid'] : 1;

        $sql = "SELECT UserID, Username, Password, 	Email, Fullname FROM usres 
            WHERE    UserID = ? 
            AND 	GroupID = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($userId, $gid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            ?>
            <h2 class="text-center title-muber">Edite User</h2>
            <div class="container edit">
                <form method="POST" action="muber.php?do=update&gid=<?= $gid ?>">
                    <input type="hidden" name="id" value="<?= $row['UserID'] ?>">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-1 col-form-label">username</label>
                        <div class="col-sm-10 my-form-group">
                            <input type="text" class="form-control" id="staticusername" name="username"
                                   value="<?= $row['Username'] ?>"
                                   placeholder="username"
                                   autocomplete="off"
                                   required="required"
                                   minlength="5"
                                   maxlength="20">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-1 col-form-label">Password</label>
                        <div class="col-sm-10 my-form-group">
                            <input type="password" class="form-control" id="inputPassword" name="password"
                                   placeholder="Password"
                                   autocomplete="new-password">
                            <input type="hidden" name="oldpassword" value="<?= $row['Password'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-1 col-form-label">email</label>
                        <div class="col-sm-10 my-form-group">
                            <input type="text" class="form-control" id="inputemail" name="email"
                                   value="<?= $row['Email'] ?>"
                                   placeholder="email"
                                   required="required"
                                   maxlength="40"
                                   minlength="10"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-1 col-form-label">fullname</label>
                        <div class="col-sm-10 my-form-group">
                            <input type="text" class="form-control" id="inputfullname" name="fullname"
                                   value="<?= $row['Fullname'] ?>"
                                   placeholder="fullname"
                                   required="required"
                                   minlength="5"
                                   maxlength="20"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-1">
                            <input type="submit" class="btn btn-primary btn-block" name="edite" value="Update">
                        </div>
                    </div>
                </form>
            </div>
            <?php
        } else {
            redirectHome("Not User In Database", "back", 3);
        }
    }

    //====================            End Edite Page انتهاء صفه اتعديل علي بيانات الاعضاء =>  go to Update

    /*
     *
     *
     * Update page   صفه التعديل علي العضو تاخذ البيانات من manage button edite
     *
     *
     * */
    elseif ($do == "update") { //update page
        ?>
        <h2 class="text-center title-muber">Update User</h2>
        <div class="container">
            <?php
            $gid = isset($_GET['gid']) ? $_GET['gid'] : 1;

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $userid = $_POST['id'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $fullname = $_POST['fullname'];
                $update = $_POST['edite'];
                $password = "";
                $password = empty($_POST['password']) ? $_POST['oldpassword'] : sha1($_POST['password']);

                $formErrors = array();
                if (strlen($username) > 20) {
                    $formErrors['usernameStrlen'] = "can not lanth > 20";
                    ?>
                    <div class="alert alert-primary" role="alert">
                        <?= $formErrors['usernameStrlen'] ?>
                    </div>
                    <?php
                }
                if (empty($username)) {
                    $formErrors['usernameEmpty'] = "can not empty usernameEmpty";
                    ?>
                    <div class="alert alert-primary" role="alert">
                        <?= $formErrors['usernameEmpty'] ?>
                    </div>
                    <?php
                }
                if (strlen($username) < 5) {
                    $formErrors['usernameStrlen'] = "can not lanth < 5";
                    ?>
                    <div class="alert alert-primary" role="alert">
                        <?= $formErrors['usernameStrlen'] ?>
                    </div>
                    <?php
                }
                if (empty($email)) {
                    $formErrors['emailEmpty'] = "can not empty emailEmpty";
                    ?>
                    <div class="alert alert-primary" role="alert">
                        <?= $formErrors['emailEmpty'] ?>
                    </div>
                    <?php
                }
                if (empty($fullname)) {
                    $formErrors['fullnameEmpty'] = "can not empty fullname";
                    ?>
                    <div class="alert alert-primary" role="alert">
                        <?= $formErrors['fullnameEmpty'] ?>
                    </div>
                    <?php
                }

                if (!empty($formErrors)) {
                    ?>
                    <a class="btn btn-primary" href="muber.php?do=edite&id=<?= $_SESSION['UserID'] ?>">back</a>
                    <?php
                }

                if (empty($formErrors)) {

                    $res = 0;
                    $sqlCheck = "SELECT * FROM usres WHERE Username = ? AND UserID != ?";
                    $stmtChack = $conn->prepare($sqlCheck);
                    $stmtChack->execute(array($username, $userid));
                    $resCheck = $stmtChack->rowCount();
                    if ($resCheck == 0) {
                        $sql = "UPDATE usres SET
                            Username = ?,
                            Password =?,
                            Email = ?,
                            Fullname = ?
                            WHERE    UserID = ?
                            AND 	GroupID = ? LIMIT 1";

                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array($username, $password, $email, $fullname, $userid, $gid));
                        $res = $stmt->rowCount();

                        if ($gid == 1) {
                            $_SESSION['username'] = $username;
                            $_SESSION['UserID'] = $userid;
                            redirectHome("Recourd Update <?= $res ?>", "index.php", 5);
                        }else{
                            redirectHome("Recourd Update <?= $res ?>", "?do=manage", 5);
                        }

                    }else{
                        redirectHome("not Recourd Update doublrcit username <?= $res ?>", "?do=manage", 5);
                    }
                }
            } else {
//                echo "you can not browes the page diractory";
                redirectHome("you can not browes the page diractory", "back", 5);
            }
            ?>
        </div>
        <?php
        /*
         *
         * Add page
         *
         *
         * */
    } elseif ($do == "add") {
        ?>
        <h2 class="text-center title-muber">Add New User</h2>
        <div class="container edit">
            <form method="POST" action="?do=insert">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-1 col-form-label">username</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="text" class="form-control" id="staticusername" name="username"
                               value=""
                               placeholder="username"
                               autocomplete="off"
                               required="required"
                               minlength="5"
                               maxlength="20">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-1 col-form-label">Password</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="password" class="password form-control" id="inputPassword" name="password"
                               required="required"
                               placeholder="Password"
                               autocomplete="new-password">
                        <i class="show-class fa fa-eye fa-1x"></i>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-1 col-form-label">email</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="text" class="form-control" id="inputemail" name="email"
                               value=""
                               placeholder="email"
                               required="required"
                               maxlength="40"
                               minlength="10"
                               autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-1 col-form-label">fullname</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="text" class="form-control" id="inputfullname" name="fullname"
                               value=""
                               placeholder="fullname"
                               required="required"
                               minlength="5"
                               maxlength="20"
                               autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">

                    <div class="col-sm-10 offset-1">
                        <input type="submit" class="btn  btn-primary btn-block" name="add" value="Add">
                    </div>
                </div>
            </form>
        </div>
        <?php

        /*
         *
         *
         * Insert user page
         *
         *
         *
         * */
    } elseif ($do == "insert") { //insert in database
        ?>
        <h2 class="text-center title-muber">Insert User</h2>
        <div class="container">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $fullname = $_POST['fullname'];
                $password = $_POST['password'];
                $update = $_POST['add'];
                $hashPassword = sha1($_POST['password']);

                $formErrors = array();
                if (strlen($username) > 20) {
                    $formErrors['usernameStrlen'] = "can not lanth > 20";
                    ?>
                    <div class="alert alert-primary" role="alert"><?= $formErrors['usernameStrlen'] ?></div><?php
                }
                if (empty($username)) {
                    $formErrors['usernameEmpty'] = "can not empty usernameEmpty";
                    ?>
                    <div class="alert alert-primary" role="alert"><?= $formErrors['usernameEmpty'] ?></div><?php
                }
                if (strlen($username) < 5) {
                    $formErrors['usernameStrlen'] = "can not lanth < 5";
                    ?>
                    <div class="alert alert-primary" role="alert"><?= $formErrors['usernameStrlen'] ?></div><?php
                }
                if (strlen($password) < 5) {
                    $formErrors['passwordEmpty'] = "can not empty password";
                    ?>
                    <div class="alert alert-primary" role="alert"><?= $formErrors['passwordEmpty'] ?></div><?php
                }
                if (empty($email)) {
                    $formErrors['emailEmpty'] = "can not empty emailEmpty";
                    ?>
                    <div class="alert alert-primary" role="alert"><?= $formErrors['emailEmpty'] ?></div><?php
                }
                if (empty($fullname)) {
                    $formErrors['fullnameEmpty'] = "can not empty fullname";
                    ?>
                    <div class="alert alert-primary" role="alert"><?= $formErrors['fullnameEmpty'] ?></div><?php
                }
                if (!empty($formErrors)) {
                    ?><a class="btn btn-primary" href="muber.php?do=edite&id=<?= $_SESSION['UserID'] ?>">back</a><?php
                }

                if (empty($formErrors)) {
//                $sqlCheck = "SELECT * FROM usres WHERE Username = ? AND Email = ?";
//                $stmtChack = $conn->prepare($sqlCheck);
//                $stmtChack->execute(array($username, $email));
//                $resChacks = $stmtChack->fetchAll();

//                    $resCheckItemDB = checkItemDBUsernameOrEmail("Username", "usres", array("Username", "Email"), array($username, $email));


                    $resCheckItemDBUsenName = checkItem("Username", "usres", "$username");
                    $resCheckItemDBEmail = checkItem("Email", "usres", "$email");


                    $resCheckItemDB = ($resCheckItemDBUsenName == 0 && $resCheckItemDBEmail == 0) ? 0 : 1;


                    if ($resCheckItemDB == 0) {
//                if ($stmtChack->rowCount() != 1) {


                        $sql = "INSERT INTO usres (Username, Password, Email, Fullname, RegStatus, RegusterDate)
                            VALUES (:username, :password, :email, :fullname, 1, now())";
                        $stmt = $conn->prepare($sql);
                        try {
                            $stmt->execute(array("username" => $username, "password" => $hashPassword, "email" => $email, "fullname" => $fullname));
                            $res = $stmt->rowCount();
                            ?>
                            <!--                        <div class="alert alert-info" role="alert">Recourd Insert one --><? //= $res ?><!--</div>--><?php
                            redirectHome("Recourd Insert one <?= $res ?>", "?do=manage", 5);
                        } catch (PDOException $ex) {
                            ?>
                            <div class="alert alert-info" role="alert">Duplicate entry <?= $username ?></div><?php
                            redirectHome("Duplicate entry <?= $username ?>", "back", 5);
                        }

                    } else {
//
                        ?><!--<div class="alert alert-info" role="alert">No Insert Recourd Insert try use</div>--><?php
                        redirectHome("Not Inserted Recourd Insert try use", "back", 5);
                    }
                }

            } else {
                ?>
                <div class="alert alert-info" role="alert">not can item insert try use</div><?php
                redirectHome("not can item insert try use", "back", 3);
            }
            ?>
        </div>
        <?php
        /*
         *
         *
         *
         * Delete Page
         *
         *
         *
         *
         * */
    } elseif ($do === "delete") { ?>
        <h2 class="text-center title-muber">Deleted User</h2>
        <div class="container">
            <?php
            $userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

            if (isset($_GET['id']) && $userId > 0) {
                $id = $_GET['id'];
//                $sql = "SELECT UserID FROM usres WHERE UserID = ?";
//                $stmt = $conn->prepare($sql);
//                $stmt->execute(array($id));
//                $res = $stmt->rowCount();


//                $res = checkItemDBUserId("UserID", "usres", "UserID", "$id");
                $res = checkItem("UserID", "usres", $id);

                if ($res > 0) {
                    $sql = "DELETE FROM usres WHERE UserID = ?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute(array($id));
                    redirectHome("Succsusful Delete Items", "muber.php", "5");
                } else {
                    ?>
                    <div class="alert alert-info" role="alert">not can id value try use</div><?php
                    redirectHome("ot can id value try use", "back", 5);
                }

            } else {
                ?>
                <div class="alert alert-info" role="alert">not can item delete try use</div><?php
                redirectHome("not can item delete try use", "?do=manage", 5);
            }
            ?>
        </div>
        <?php

    } /*
     *
     *
     * page panding
     *
     *
     *
    */


    elseif ($do === "activet") { ?>
        <h2 class="text-center title-muber">Actvating User</h2>
        <div class="container">
            <?php
            $userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

            if (isset($_GET['id']) && $userId > 0) {
                $id = $_GET['id'];

//                $res = checkItemDBUserId("UserID", "usres", "UserID", "$id");

                $res = checkItem("UserID", "usres", "$id");

                if ($res > 0) {
                    $sql = " UPDATE usres SET 	RegStatus = 1 WHERE UserID = ?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute(array($id));

                    redirectHome("One Recourd Acvtvited", "?page=userAvation", 5);
                } else {
//                    ?>
                    <div class="alert alert-info" role="alert">not can id value try use</div><?php
                    redirectHome("ot can id value try use", "back", 5);
                }

            } else {
//                ?>
                <div class="alert alert-info" role="alert">not can item Actvite try use</div><?php
                redirectHome("not can item actvited try use", "?do=manage", 5);
            }
            ?>
        </div>
        <?php


    } else  //chck url requst
    {

        redirectHome("else page not found", "index.php", 5);

    }

    include $tpl . "footer.php";
} else  //chack session username
{
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>
