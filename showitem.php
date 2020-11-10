<?php
ob_start();
session_start();
$pagetitle = "Show Item";
include "init.php";
if (isset($_GET['id'])) {

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    $resCheckItem = checkItem("Item_ID", "items", "$id");
    if ($resCheckItem == 1) {
        $sqlItem = "SELECT items.*, categories.Name as Cat_Name, categories.Cat_ID as Cat_IDD, usres.Username as Use_Name
                    FROM items INNER  JOIN categories, usres 
                    WHERE  items.Item_ID =$id AND items.Cat_ID = categories.Cat_ID  AND items.User_ID = usres.UserID";


        $stmtItem = $conn->prepare($sqlItem);
        $stmtItem->execute();
        $resItemRow = $stmtItem->fetch();

        if($resItemRow['Approve'] == 1){
            ?>
            <div class="container">
                <h2 class="text-center title-muber"><?= $resItemRow['Name'] ?></h2>
                <div class="row border pt-2">
                    <div class="col-md-3 border pt-2 ml-1 mb-1">
                        <div>
                            <img src="layout/images/uploads/<?= $resItemRow['Image'] ?>" alt=""
                                 class="w-100 mb-1 img-thumbnail">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p class=""><span class="p-0 text-success ">Ctegries Name : </span><?= $resItemRow['Cat_Name'] ?>
                        </p>
                        <p class=""><span class="text-success ">usres Name : </span><?= $resItemRow['Use_Name'] ?></p>
                        <ul class="litest list-unstyled list-item-show">
                            <li class="">Name : <?= $resItemRow['Name'] ?></li>
                            <li class=""><?= $resItemRow['Description'] ?></li>
                            <li class=""><?= $resItemRow['Add_Date'] ?></li>
                            <li class=""><?= $resItemRow['Price'] ?>$</li>
                            <li class="">Ctegries : <a href="categoris.php?cat_id=<?= $resItemRow['Cat_IDD'] ?>"
                                                       class="p-0 text-success "><?= $resItemRow['Cat_Name'] ?></a></li>
                            <li class="">Ctegries : <a href="" class="p-0 text-success "><?= $resItemRow['Use_Name'] ?></a>
                            </li>
                            <li class=""><?= $resItemRow['Item_ID'] ?></li>
                            <li class=""><?= $resItemRow['Country_miade'] ?></li>
                            <li class="">tages :


                                <?php

                                    $alltages = explode(",",$resItemRow['Tages']);
                                    foreach ($alltages as $alltage){
                                        ?>
                                        <a href="tageAll.php?tag=<?=$alltage?>" class="btn btn-primary"><?= $alltage ?></a>
                                        <?php
                                    }

                                ?>





                            </li>
                        </ul>
                    </div>
                </div>


                <?php

                if (isset($_SESSION['user'])) {
                    ?>
                    <hr>
                    <div class="row">
                        <div class="offset-3">
                            <h3>Add your Comment</h3>
                            <form action="<?= $_SERVER['PHP_SELF'] ?>?id=<?= $id ?>" method="post">
                                <textarea class="form-control" name="comment_text" cols="100" rows="4"></textarea>
                                <input type="submit" class="btn btn-success mt-2" name="new_comment" value="save comment">
                            </form>
                            <?php

                            if (isset($_SERVER['REQUEST_METHOD']) == "POST" && isset($_POST['new_comment']) == "save comment") {

                                $comment_text = filter_var($_POST['comment_text'], FILTER_SANITIZE_STRING);
                                $formErrors = array();
                                if (empty($comment_text)) {
                                    $formErrors['commError'] = "comment text empty";
                                }
                                if (strlen($comment_text) > 100) {
                                    $formErrors['commError'] = "comment text > 100";
                                }
                                if (strlen($comment_text) < 10) {
                                    $formErrors['commError'] = "comment text < 10 ";
                                }


                                if (empty($formErrors)) {
                                    $sqlInsCom = "INSERT INTO comments(Comment, Com_Date, Item_ID, User_ID) 
                                            VALUES (:comment, now(), :item_id, :user_id)";
                                    $stmsInsCom = $conn->prepare($sqlInsCom);
                                    $stmsInsCom->execute(array(
                                        "comment" => $comment_text,
                                        "item_id" => $resItemRow['Item_ID'],
                                        "user_id" => $_SESSION['User_ID']
                                    ));
                                    $resInsCom = $stmsInsCom->rowCount();
                                    if ($resInsCom == 1) {
                                        redirectHome("suc insert comment ", "back", "5");
                                    } else {
                                        redirectHome("not insert comment ", "back", "5");
                                    }
                                } else {

                                    echo "<div class='alert alert-secondary' role='alert'>" . $formErrors['commError'] . "</div>";


                                }


                            }

                            ?>
                        </div>
                    </div>
                    <hr>
                    <?php
                } else {
                    echo "<hr> <div class='row'><div class='offset-3'>";
                    echo "<a href='login.php' class='btn btn-primary mt-2 mb-2'> login in register </a>";
                    echo "</div></div><hr>";
                }

                $sqlSeCom = "SELECT comments.*, usres.Username FROM comments INNER JOIN usres
                                WHERE comments.User_ID = usres.UserID AND comments.Item_ID = ? AND comments.Status = 1";
                $stmtSeCom = $conn->prepare($sqlSeCom);
                $stmtSeCom->execute(array($resItemRow['Item_ID']));
                $rowsSleComs = $stmtSeCom->fetchAll();

                foreach ($rowsSleComs as $rowsSleCom) {
                    ?>

                    <div class="row  border mb-2">
                        <div class="col-md-3 mt-2">
                            <div class="alert alert-primary " role="alert">
                                <img src="download.jpg" class="img-thumbnail rounded-circle w-25" alt="">
                                <?=$rowsSleCom['Username']?> :
                            </div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <div class="alert alert-primary" role="alert">
                                <?=$rowsSleCom['Comment']?>
                            </div>
                        </div>
                    </div>


                    <?php
                }
                ?>
            </div>

            <?php
        }else{
            redirectHome("not item approve","back",4);
        }

        ?>
        </div>
        </div>
        <?php
    } else {
        redirectHome("no Item ID", "back", "2");
    }
}
include $tpl . "footer.php";
ob_end_flush();
?>
