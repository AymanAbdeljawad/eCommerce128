<?php
ob_start();
session_start();
$pagetitle = "Categories";
/*
 * ========================================================
 *  Categories page
 *  you can add | edite | delete mumber from hear
 * ========================================================
*/

/*==================================== Stert  page  Categories ==================================*/
if (isset($_SESSION['username'])) {
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";
    $id = isset($_GET['id']) ? $_GET['id'] : "0";

    /*============= start manage page Categories ==============*/

    $sort = "ASC";

    if ($do == "manage") {

        if (isset($_GET['sort']) && $_GET['sort'] == "ASC") {
            $sort = "ASC";
        } else {
            $sort = "DESC";
        }


        $sql = "SELECT * FROM categories WHERE perant = 0 ORDER BY Ordring $sort";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        ?>

        <div class="container">

            <h2 class="text-center mt-0 title-muber">Manage Categries</h2>
            <a href="?do=add" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Add New Categore</a>
            <div class="row mt-4">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title pt-2 pb-2 h5 " style="background-color: #b3d7ff">
                                <span>Catagere</span>
                                <a class="fa-pull-right text-dark  <?= $sort == "ASC" ? "active" : ""; ?>"
                                   href="?sort=ASC">Asc</a>
                                <span class="fa-pull-right"> | </span>
                                <a class="fa-pull-right text-dark  <?= $sort == "DESC" ? "active" : ""; ?>"
                                   href="?sort=DESC">Desc</a>
                                <span class="fa-pull-right font-weight-bold mr-2">Ordring</span>
                            </div>
                            <div class="row">
                                <?php
                                foreach ($rows as $row) {
                                    ?>

                                    <div class="col-md-12  col-lg-6  ">
                                        <div class=" mb-3">
                                            <h5 class="card-title bg-info p-2 text-center">
                                                Catagere <?= $row['Name'] ?></h5>
                                            <div class="mb-2 ed-del">
                                            <span class="d-block mb-1">
                                                <i class="font-weight-bold">Descriptin</i> <?= $row['Description'] ?>
                                            </span>
                                                <?= $row['Visibiity'] == "0" ? "<a class='btn btn-danger' href= ''>hidden</a>" : ""; ?>
                                                <?= $row['Allow_Commect'] == "0" ? "<a class='btn btn-success' href= ''>Commect-disaply</a>" : ""; ?>
                                                <?= $row['Allow_Ads'] == "0" ? "<a class='btn btn-primary' href= ''>Ads-disaply</a>" : ""; ?>


                                                <a href="?do=edite&id=<?= $row['Cat_ID'] ?>"
                                                   class="fa-pull-right ml-1 btn btn-success cat-hid-edit"><i
                                                            class="fa fa-edit"></i>Edit</a>
                                                <a href="?do=delete&id=<?= $row['Cat_ID'] ?>"
                                                   class="fa-pull-right btn btn-danger cat-hid-dele confirm"><i
                                                            class="fa fa-trash"></i>Delete</a>
                                            </div>
                                        </div>


                                        <?php

                                        $stmtPer = $conn->prepare("SELECT * FROM categories WHERE perant = ?;");
                                        $stmtPer->execute(array($row['Cat_ID']));
                                        $resPreRows = $stmtPer->fetchAll();
                                        foreach ($resPreRows as $resPreRow) {
                                            ?>
                                            <a href="?do=delete&id=<?= $resPreRow['Cat_ID'] ?>" class="btn  confirm"><i
                                                        class="fa fa-trash"></i></a>
                                            <a href="?do=edite&id=<?= $resPreRow['Cat_ID'] ?>"><i
                                                        class="fa fa-edit"></i><?= $resPreRow['Name'] ?></a>
                                            <?php
                                        }

                                        ?>


                                    </div>

                                    <?php

                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php

    } /*=============  start page add Categories ==============*/
    elseif ($do == "add") {
        ?>
        <h2 class="text-center title-muber">Categrios Add Adminstration</h2>
        <div class="container edit">
            <form method="POST" action="?do=insert">
                <div class="form-group row">
                    <label for="staticnamecategre" class="col-sm-1 col-form-label">Name</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="text" class="form-control" id="staticnamecategre" name="namecategre"
                               value=""
                               placeholder="Name Categre"
                               autocomplete="off"
                               required="required"
                               maxlength="20">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputdescraption" class="col-sm-1 col-form-label">Descraption</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="text" class="form-control" id="inputdescraption" name="descraption"
                               value=""
                               placeholder="Descraption"
                               maxlength="200"
                               autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputordring" class="col-sm-1 col-form-label">Ordring</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="text" class="form-control" id="inputordring" name="ordring"
                               value=""
                               placeholder="Ordring number categries"
                               maxlength="20"
                               autocomplete="off">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="inputordring" class="col-sm-1 col-form-label">peraint ?</label>
                    <div class="col-sm-10 my-form-group">
                        <select name="perant" id="" class="form-control">
                            <option value="0">None</option>
                            <?php
                            $stmtSel = $conn->query("SELECT * FROM categories WHERE perant = 0");
                            $stmtSel->execute();
                            $resRows = $stmtSel->fetchAll();
                            foreach ($resRows as $resRow) {
                                ?>
                                <option value="<?= $resRow['Cat_ID'] ?>"><?= $resRow['Name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-1 col-form-label font-weight-bold">Visible</label>
                    <div class="col-sm-10 my-form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label mr-2 mt-2 font-weight-bold" for="vis-yas">Yas0</label>
                            <input class="form-check-input mr-4 mt-2" type="radio" id="vis-yas" checked
                                   name="visable"
                                   value="0">
                            <label class="form-check-label mr-2 mt-2 font-weight-bold" for="vis-no">No1</label>
                            <input class="form-check-input mt-2" type="radio" id="vis-no"
                                   name="visable"
                                   value="1">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-1 col-form-label font-weight-bold">Commect</label>
                    <div class="col-sm-10 my-form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label mr-2 mt-2 font-weight-bold" for="com-yas">Yas0</label>
                            <input class="form-check-input mr-4 mt-2" type="radio" id="com-yas" checked
                                   name="commect"
                                   value="0">
                            <label class="form-check-label mr-2 mt-2 font-weight-bold" for="com-no">No1</label>
                            <input class="form-check-input mt-2" type="radio" id="com-no"
                                   name="commect"
                                   value="1">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputordring" class="col-sm-1 col-form-label font-weight-bold">Ads</label>
                    <div class="col-sm-10 my-form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label mr-2 mt-2 font-weight-bold" for="ads-yas">Yas0</label>
                            <input class="form-check-input mr-4 mt-2" type="radio" id="ads-yas" checked
                                   name="ads"
                                   value="0">
                            <label class="form-check-label mr-2 mt-2 font-weight-bold" for="ads-no">No1</label>
                            <input class="form-check-input mt-2" type="radio" id="ads-no"
                                   name="ads"
                                   value="1">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-1">
                        <input type="submit" class="btn  btn-primary btn-block" name="add" value="Add-insert">
                    </div>
                </div>
            </form>
        </div>
        <?php
    }
    /*=============  end page add Categories ==============*/
    /*=============================================================*/
    /*============= start page insert Categories ==============*/
    elseif ($do == "insert") {
        ?>
        <h2 class="text-center title-muber">Insert User</h2>
        <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {
            $namecategre = $_POST['namecategre'];
            $descraption = $_POST['descraption'];
            $ordring = $_POST['ordring'];
            $visable = $_POST['visable'];
            $commect = $_POST['commect'];
            $perant = $_POST['perant'];
            $ads = $_POST['ads'];


            $formErrors = array();
            if (strlen($namecategre) > 30) {
                $formErrors['namecategreStrlen'] = "can not lanth > 20";
                ?>
                <div class="alert alert-primary" role="alert"><?= $formErrors['namecategreStrlen'] ?></div><?php
            }
            if (empty($namecategre)) {
                $formErrors['namecategreEmpty'] = "can not empty namecategreEmpty";
                ?>
                <div class="alert alert-primary" role="alert"><?= $formErrors['usernameEmpty'] ?></div><?php
            }
            if (strlen($namecategre) < 1) {
                $formErrors['namecategreStrlen'] = "can not lanth < 5";
                ?>
                <div class="alert alert-primary" role="alert"><?= $formErrors['namecategreStrlen'] ?></div><?php
            }

            if (empty($formErrors)) {
                $resCheckItemDBUsenName = checkItem("Name", "categories", "$namecategre");
                if ($resCheckItemDBUsenName == 0) {
                    $sql = "INSERT INTO categories 
                                    (Name, Description, perant,  Ordring, Visibiity, Allow_Commect, Allow_Ads)
                            VALUES (:name, :description,:perant, :ordring, :visibiity, :allow_Commect, :allow_Ads)";
                    $stmt = $conn->prepare($sql);
                    try {
                        $stmt->execute(array(

                            "name" => $namecategre,
                            "description" => $descraption,
                            "ordring" => $ordring,
                            "perant" => $perant,
                            "visibiity" => $visable,
                            "allow_Commect" => $commect,
                            "allow_Ads" => $ads
                        ));

                        $res = $stmt->rowCount();
                        ?>
                        </div>
                        <?php
                        redirectHome("Recourd Insert one <?= $res ?>", "?do=manage", 2);
                    } catch (PDOException $ex) {
                        redirectHome("Duplicate entry <?= $namecategre ?>", "back", 2);
                    }

                } else {

                    redirectHome("Not Inserted Recourd Insert try use", "back", 2);
                }
            }

        } else {
            redirectHome("not can item insert try use", "back", 2);
        }
        ?>
        </div>
        <?php
    }
    /*============= end page insert Categories ==============*/
    /*=============================================================*/
    /*============= start page edite Categories ==============*/
    elseif ($do == "edite") {

        $userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

        $sql = "SELECT * FROM categories 
            WHERE    Cat_ID = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($userId));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            ?>
            <h2 class="text-center title-muber">Categrios Edite </h2>
            <div class="container edit">
                <form method="POST" action="?do=update&id=<?= $row['Cat_ID'] ?>">
                    <div class="form-group row">
                        <label for="staticnamecategre" class="col-sm-1 col-form-label">Name</label>
                        <div class="col-sm-10 my-form-group">
                            <input type="text" class="form-control" id="staticnamecategre" name="namecategre"
                                   value="<?= $row['Name'] ?>"
                                   placeholder="Name Categre"
                                   autocomplete="off"
                                   required="required"
                                   maxlength="20">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputdescraption" class="col-sm-1 col-form-label">Descraption</label>
                        <div class="col-sm-10 my-form-group">
                            <input type="text" class="form-control" id="inputdescraption" name="descraption"
                                   value="<?= $row['Description'] ?>"
                                   placeholder="Descraption"
                                   maxlength="200"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputordring" class="col-sm-1 col-form-label">Ordring</label>
                        <div class="col-sm-10 my-form-group">
                            <input type="text" class="form-control" id="inputordring" name="ordring"
                                   value="<?= $row['Ordring'] ?>"
                                   placeholder="Ordring number categries"
                                   maxlength="20"
                                   autocomplete="off">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="inputordring" class="col-sm-1 col-form-label">peraint ?</label>
                        <div class="col-sm-10 my-form-group">
                            <select name="perant" id="" class="form-control">
                                <option value="0">None</option>
                                <?php
                                $stmtSel = $conn->query("SELECT * FROM categories WHERE perant = 0");
                                $stmtSel->execute();
                                $resRows = $stmtSel->fetchAll();

                                $p = $row['perant'];
                                foreach ($resRows as $d) {
                                    if ($d['Cat_ID'] == $p) {
                                        ?>
                                        <option value="<?= $d['Cat_ID'] ?>" selected><?= $d['Name'] ?></option>
                                        <?php
                                    }
                                }

                                ?>
                                <?php
                                foreach ($resRows as $resRow) {
                                    ?>
                                    <option value="<?= $resRow['Cat_ID'] ?>"><?= $resRow['Name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label font-weight-bold">Visible</label>
                        <div class="col-sm-10 my-form-group">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label mr-2 mt-2 font-weight-bold" for="vis-yas">Yas0</label>
                                <input class="form-check-input mr-4 mt-2" type="radio" id="vis-yas"
                                    <?= $row['Visibiity'] == 0 ? "checked" : "" ?>
                                       name="visable"
                                       value="0">
                                <label class="form-check-label mr-2 mt-2 font-weight-bold" for="vis-no">No1</label>
                                <input class="form-check-input mt-2" type="radio" id="vis-no"
                                    <?= $row['Visibiity'] == 1 ? "checked" : "" ?>
                                       name="visable"
                                       value="1">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1 col-form-label font-weight-bold">Commect</label>
                        <div class="col-sm-10 my-form-group">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label mr-2 mt-2 font-weight-bold" for="com-yas">Yas0</label>
                                <input class="form-check-input mr-4 mt-2" type="radio" id="com-yas"
                                    <?= $row['Allow_Commect'] == 0 ? "checked" : "" ?>
                                       name="commect"
                                       value="0">
                                <label class="form-check-label mr-2 mt-2 font-weight-bold" for="com-no">No1</label>
                                <input class="form-check-input mt-2" type="radio" id="com-no"
                                    <?= $row['Allow_Commect'] == 1 ? "checked" : "" ?>
                                       name="commect"
                                       value="1">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputordring" class="col-sm-1 col-form-label font-weight-bold">Ads</label>
                        <div class="col-sm-10 my-form-group">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label mr-2 mt-2 font-weight-bold" for="ads-yas">Yas0</label>
                                <input class="form-check-input mr-4 mt-2" type="radio" id="ads-yas"
                                    <?= $row['Allow_Ads'] == 0 ? "checked" : "" ?>
                                       name="ads"
                                       value="0">
                                <label class="form-check-label mr-2 mt-2 font-weight-bold" for="ads-no">No1</label>
                                <input class="form-check-input mt-2" type="radio" id="ads-no"
                                    <?= $row['Allow_Ads'] == 1 ? "checked" : "" ?>
                                       name="ads"
                                       value="1">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-1">
                            <input type="submit" class="btn  btn-primary btn-block" name="add" value="Update">
                        </div>
                    </div>
                </form>
            </div>
            <?php
        } else {
            echo "ssssssssssssssssss";
        }
    }
    /*============= end page edite Categories ==============*/
    /*=============================================================*/
    /*============= start page update Categories ==============*/
    elseif ($do == "update") {
        ?>
        <h2 class="text-center title-muber">Update Caregries</h2>
        <div class="container">
            <?php
            $id = isset($_GET['id']) ? $_GET['id'] : 0;

            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                $namecategre = $_POST['namecategre'];
                $descraption = $_POST['descraption'];
                $ordring = $_POST['ordring'];
                $visable = $_POST['visable'];
                $commect = $_POST['commect'];
                $perant = $_POST['perant'];
                $ads = $_POST['ads'];
                $update = $_POST['add'];


                $formErrors = array();
                if (strlen($namecategre) > 20) {
                    $formErrors['namecategreStrlen'] = "can not lanth > 20";
                    ?>
                    <div class="alert alert-primary" role="alert">
                        <?= $formErrors['namecategreStrlen'] ?>
                    </div>
                    <?php
                }
                if (empty($namecategre)) {
                    $formErrors['namecategreEmpty'] = "can not empty usernameEmpty";
                    ?>
                    <div class="alert alert-primary" role="alert">
                        <?= $formErrors['namecategreEmpty'] ?>
                    </div>
                    <?php
                }
                if (strlen($namecategre) < 2) {
                    $formErrors['namecategreStrlen'] = "can not lanth < 5";
                    ?>
                    <div class="alert alert-primary" role="alert">
                        <?= $formErrors['namecategreStrlen'] ?>
                    </div>
                    <?php
                }

                if (!empty($formErrors)) {
                    ?>
                    <a class="btn btn-primary" href="muber.php?do=edite&id=<?= $_SESSION['UserID'] ?>">back</a>
                    <?php
                }

                if (empty($formErrors)) {

                    $sql = "UPDATE categories SET
                            Name = ?,
                            Description =?,
                            Ordring =?,
                            perant =?,
                            Visibiity =?,
                            Allow_Commect =?,
                            Allow_Ads =?
                            WHERE   Cat_ID = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute(array($namecategre, $descraption, $ordring, $perant, $visable, $commect, $ads, $id));
                    $res = $stmt->rowCount();
                    if ($res == 1) {
                        redirectHome("Recourd Update <?= $res ?>", "?do=manage", 2);
                    }
                }
            } else {
                redirectHome("you can not browes the page diractory", "back", 2);
            }
            ?>
        </div>
        <?php
    }
    /*============= end  page update  Categories ==============*/
    /*=============================================================*/
    /*============= start page delete Categories ==============*/
    elseif ($do === "delete") {
        ?>
        <h2 class="text-center title-muber">Deleted Caategrie</h2>
        <div class="container">
            <?php
            $userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

            if (isset($_GET['id']) && $userId > 0) {
                $id = $_GET['id'];
                $res = checkItem("Cat_ID", "categories", $id);
                if ($res > 0) {
                    $sql = "DELETE FROM categories WHERE Cat_ID = ?";
                    $stmt = $conn->prepare($sql);
                    $res = $stmt->execute(array($id));
                    redirectHome("Succsusful Delete Items", "?do=manage", "2");
                } else {

                    redirectHome("not can id value try use", "back", 2);
                }

            } else {
                redirectHome("not can item delete try use", "?do=manage", 2);
            }
            ?>
        </div>
        <?php
    }
    /*============= end page delete Categories ==============*/
    /*=============================================================*/
    /*============= end manage page Categories ==============*/
    else {
        echo "else are";
    }
    include $tpl . "footer.php";
} /*==================================== end  page  Categories ==================================*/
else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>

