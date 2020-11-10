<?php
ob_start();
session_start();
$pagetitle = "comment";
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

        $sql = "SELECT *, usres.Username as username, items.Name as itemname FROM comments
                INNER JOIN usres, items
                 WHERE  	comments.User_ID = usres.UserID AND comments.Item_ID = items.Item_ID";


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        ?>

        <h2 class="text-center title-muber">Manage Comments </h2>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered text-center">
                    <tr class="bg-dark">
                        <th>#id</th>
                        <th>Comment</th>
                        <th>Com_Date</th>
                        <th>Item</th>
                        <th>User</th>
                        <th><i class="fa fa-edit"></i>Control</th>
                    </tr>
                    <?php
                    foreach ($rows as $row) {
                        ?>
                        <tr>
                            <td><?= $row['Com_ID'] ?></td>
                            <td class="w-25"><?= $row['Comment'] ?></td>
                            <td><?= $row['Com_Date'] ?></td>
                            <td><?= $row['itemname'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><a href="?do=edite&id=<?= $row['Com_ID'] ?>" class="btn btn-success"><i
                                            class="fa fa-edit"></i>Edit</a>
                                <a href="?do=delete&id=<?= $row['Com_ID'] ?>" class="btn btn-danger confirm"><i
                                            class="fa fa-trash"></i>Delete</a>
                                <?php
                                if ($row['Status'] == 0) {
                                ?>
                                <a href="?do=aprrove&id=<?= $row['Com_ID'] ?>" class="btn btn-info"><i
                                            class="fa fa-edit"></i>Approve</a>
                            </td><?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
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
        $sql = "SELECT * FROM comments WHERE Com_ID = $userId";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($userId));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            ?>
            <h2 class="text-center title-muber">Edite Comment</h2>
            <div class="container edit">
                <form method="POST" action="?do=update">
                    <input type="hidden" name="id" value="<?= $row['Com_ID'] ?>">
                    <div class="form-group row">
                        <label for="staticcomment" class="col-sm-1 col-form-label">Comment</label>
                        <div class="col-sm-10 my-form-group">
                            <input type="text" class="form-control" id="staticcomment" name="comment"
                                   value="<?= $row['Comment'] ?>"
                                   placeholder="Comment"
                                   autocomplete="off"
                                   required="required"
                                   minlength="5"
                                   maxlength="20">
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
            $userid = "";
            if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {
                $userid = $_POST['id'];
                $comment = $_POST['comment'];
                $resCheckItem = checkItem("Com_ID", "comments", "$userid");
                if ($resCheckItem > 0) {
                    $userid = $_POST['id'];
                    $sql = "UPDATE comments SET
                            Comment = ?
                            WHERE  Com_ID = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute(array($comment, $userid));
                    $res = $stmt->rowCount();

                    if ($res == 1) {
                        redirectHome("Recourd Update sucs", "?do=manage", 5);
                    } else {
                        redirectHome("No Recourd Update ", "?do=edite&id=$userid", 5);

                    }

                } else {
                    redirectHome("No Recourd Update ", "?do=edite&id=$userid", 5);

                }
            } else {
                redirectHome("you can not browes the page diractory", "back", 5);
            }
            ?>
        </div>
        <?php
    } /*
         *
         * Add page
         *
         *
         * */
    elseif ($do === "delete") { ?>
        <h2 class="text-center title-muber">Deleted Comment</h2>
        <div class="container">
            <?php
            $userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            if (isset($_GET['id']) && $userId > 0) {
                $id = $_GET['id'];
                $res = checkItem("Com_ID", "comments", $id);

                if ($res > 0) {
                    $sql = "DELETE FROM comments WHERE Com_ID = ?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute(array($id));
                    redirectHome("Succsusful Delete Items", "back", "2");
                } else {
                    ?>
                    <div class="alert alert-info" role="alert">not can id value try use</div><?php
                    redirectHome("ot can id value try use", "back", 2);
                }

            } else {
                ?>
                <div class="alert alert-info" role="alert">not can item delete try use</div><?php
                redirectHome("not can item delete try use", "?do=manage", 2);
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


    elseif ($do === "aprrove") { ?>
        <h2 class="text-center title-muber">Actvating Comment</h2>
        <div class="container">
            <?php
            $userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

            if (isset($_GET['id']) && $userId > 0) {
                $id = $_GET['id'];
                $res = checkItem("Com_ID", "comments", "$id");

                if ($res > 0) {
                    $sql = " UPDATE comments SET 	Status = 1 WHERE Com_ID = ?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute(array($id));
                    redirectHome("One Recourd Approve", "?comment.php", 2);
                } else {
//                    ?>
                    <div class="alert alert-info" role="alert">not can id value try use</div><?php
                    redirectHome("Not can id value try use", "back", 5);
                }

            } else {
//                ?>
                <div class="alert alert-info" role="alert">not can item Actvite try use</div><?php
                redirectHome("not can item Approve try use", "?do=manage", 5);
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
