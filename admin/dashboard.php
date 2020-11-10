<?php
ob_start();
session_start();
if (isset($_SESSION['username'])) {
    $pagetitle = "dashboard";
    include "init.php";
    $theLatestsUsers = getLatest("*", "usres", "UserID", "DESC", "4");
    $theLatestsItems = getLatest("*", "items", "Item_ID", "DESC", "4");

    $sqlCom = "SELECT * , usres.Username FROM comments INNER JOIN usres WHERE comments.User_ID = usres.UserID ORDER BY Com_ID ASC LIMIT 4";
    $stmtCom = $conn->prepare($sqlCom);
    $stmtCom->execute();
    $theLatestsComments = $stmtCom->fetchAll();

    /* start page dashboard */
    ?>
    <div class="container home-dashboard">
        <h2 class="dashboardTitle text-center h1">DashBoard</h2>
        <div class="row">
            <div class="col-md-3 mb-2">
                <div class="stst st-muberes">
                    <i class="fa fa-users fa-1x"></i>
                    <div>
                        Total muberes
                        <span>
                            <?php $res = getCountRowUsUserID() ?>
                            <a href="muber.php?do=manage&page=userAvation"><?= $res ?></a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="stst st-panding">
                    <i class="fa fa-user-plus fa-1x"></i>
                    <div>
                        Panding muberes
                        <span>
                            <a href="muber.php?do=manage&page=panding"><?= checkItem("RegStatus", "usres", "0") ?></a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="stst st-item">
                    <i class="fa fa-pen-nib fa-1x"></i>
                    <div>
                        Total Items
                        <span>
                        <?php
                        $countItem = getCountRowUsUserID("Item_ID", "items");
                        ?>
                        <a href="items.php?do=manage"><?= $countItem ?></a>
                    </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="stst st-comment">
                    <i class="fa fa-comment fa-1x"></i>
                    <div>
                        Total Comments
                        <span>
                             <?php
                             $countItem = getCountRowUsUserID("Com_ID", "comments");
                             ?>
                           <a href="comment.php?do=manage"><?= $countItem ?></a>
                       </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container litest mt-4">
        <div class="row">
            <div class="col-sm-6 mb-2">
                <div class="card mb-4">
                    <div class="bg-primary mb-2">
                        <span class="card-title btn-primary d-inline-block  p-2"><i class="fa fa-user mr-3"></i>Last User Reguster <?= count($theLatestsUsers) ?> .</span>
                        <span class="fa-pull-right mr-5 mt-2 h3 toggle-info"><i class="fa fa-plus"></i></span>
                    </div>
                    <div class="card-body p-0">
                        <ul class="litest pr-5 ">
                            <?php foreach ($theLatestsUsers as $theLatestsUser) { ?>
                                <li class="list-group-item pt-0 pb-0  overflow-hidden "><span
                                        class="d-inline-block  p-2" latest-span
                                "><?= $theLatestsUser['Username']; ?></span>
                                <a href="muber.php?do=edite&id=<?= $theLatestsUser['UserID'] ?>&gid=<?= $theLatestsUser['GroupID'] ?>>"
                                   class="btn btn-success fa-pull-right mt-1"><i class="fa fa-edit"></i>Edit</a>
                                <?php if ($theLatestsUser['RegStatus'] == 0) { ?>
                                <a href="muber.php?do=activet&id=<?= $theLatestsUser['UserID'] ?>&gid=<?= $theLatestsUser['GroupID'] ?>"
                                   class="btn btn-info fa-pull-right mt-1 mr-2"><i class="fa fa-edit"></i>Active
                                    </a><?php
                                } ?>
                                </li><?php } ?>
                        </ul>
                        <div class="text-center"><a href="#" class="btn btn-primary ml-2">Go somewhere</a></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-2">
                <div class="card mb-4">
                    <div class="bg-primary mb-2">
                        <span class="card-title btn-primary d-inline-block  p-2"><i class="fa fa-user mr-3"></i>Last Item Reguster <?= count($theLatestsItems) ?> .</span>
                        <span class="fa-pull-right mr-5 mt-2 h3 toggle-info"><i class="fa fa-plus"></i></span>
                    </div>
                    <div class="card-body p-0">
                        <ul class="litest pr-5 ">
                            <?php foreach ($theLatestsItems as $theLatestsItem) { ?>
                                <li class="list-group-item pt-0 pb-0  overflow-hidden ">
                                <span class="d-inline-block  p-2" latest-span"><?= $theLatestsItem['Name']; ?></span>
                                <a href="items.php?do=edite&id=<?= $theLatestsItem['Item_ID'] ?>"
                                   class="btn btn-success ml-1  mt-1 fa-pull-right mt-0"><i class="fa fa-edit"></i>Edit</a>
                                <a href="items.php?do=delete&id=<?= $theLatestsItem['Item_ID'] ?>"
                                   class="btn btn-danger  mt-1 fa-pull-right mt-0 confirm"><i class="fa fa-trash"></i>Delete</a>
                                <?php if ($theLatestsItem['Approve'] == 0) { ?>
                                    <a href="items.php?do=approve&id=<?= $theLatestsItem['Item_ID'] ?>"
                                       class="btn btn-light   mt-1 fa-pull-right mt-0 mr-2">
                                        <i class="fa fa-check-circle"></i>Approve</a>
                                    <?php
                                }
                                ?></li><?php
                            }
                            ?>
                        </ul>
                        <div class="text-center"><a href="items.php?do=add" class="btn btn-primary ml-2"><i
                                        class="fa fa-plus-circle"></i>Add new Item</a></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-2">
                <div class="card mb-4">
                    <div class="bg-primary mb-2">
                        <span class="card-title btn-primary d-inline-block  p-2"><i class="fa fa-user mr-3"></i>Last Comments  <?= count($theLatestsComments) ?> .</span>
                        <span class="fa-pull-right mr-5 mt-2 h3 toggle-info"><i class="fa fa-plus"></i></span>
                    </div>
                    <div class="card-body p-0">
                        <ul class="litest pr-5 ">
                            <?php foreach ($theLatestsComments as $theLatestsComment) {?>
                                <li class="list-group-item pt-0 pb-0  overflow-hidden ">
                                <span class="d-inline-block font-weight-bold  p-2" latest-span">
                                <a href="muber.php?do=edite&id=<?= $theLatestsComment['UserID'] ?>&gid=0"><?= $theLatestsComment['Username']; ?></a>
                                </span>
                                <a href="comment.php?do=edite&id=<?= $theLatestsComment['Com_ID'] ?>"
                                   class="btn btn-success mt-1 ml-1 fa-pull-right mt-0"><i class="fa fa-edit"></i>Edit</a>
                                <a href="comment.php?do=delete&id=<?= $theLatestsComment['Com_ID'] ?>"
                                   class="btn btn-danger mt-1 fa-pull-right mt-0 confirm"><i class="fa fa-trash"></i>Delete</a>
                                <?php if ($theLatestsComment['Status'] == 0) { ?>
                                <a href="comment.php?do=aprrove&id=<?= $theLatestsComment['Com_ID'] ?>"
                                   class="btn btn-info fa-pull-right  mt-1 mr-2"><i class="fa fa-check-circle"></i>Approve</a><?php
                                } ?>
                                <p class="bg-light p-2"><?= $theLatestsComment['Comment']; ?></p>
                                </li><?php
                            }
                            ?>
                        </ul>
                        <div class="text-center"><a href="items.php?do=add" class="btn btn-primary ml-2"><i class="fa fa-plus-circle"></i>Add new Item</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    /* end page dashboard */
    include $tpl . "footer.php";
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>