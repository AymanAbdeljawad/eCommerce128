<?php
ob_start();
session_start();
$pagetitle = "item";
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


        $sqlInnerJoin = "SELECT items.*, usres.Username as user_name, categories.Name as cat_name 
                                FROM items 
                                INNER JOIN usres, categories
                                WHERE items.User_ID =usres.UserID AND items.Cat_ID = categories.Cat_ID";

//        $sql = "SELECT * FROM items";
        $stmt = $conn->prepare($sqlInnerJoin);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        ?>
        <div class="container">
        <h2 class="text-center title-muber">Manage Items</h2>
        <a href="?do=add" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Add New Item</a>
        <div class="table-responsive">
            <table class="main-table table table-bordered text-center">
                <tr class="bg-dark">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Add_Date</th>
                    <th>Country_miade</th>
                    <th>Image</th>
                    <th>State</th>
                    <th>Rating</th>
                    <th>Tages</th>
                    <th>Cat_Name</th>
                    <th>User_Name</th>
                    <th colspan="3" class="control-th"><i class="fa fa-edit"></i>Controll</th>
                </tr>
                <?php
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><?= $row['Item_ID'] ?></td>
                        <td><?= $row['Name'] ?></td>
                        <td><?= $row['Description'] ?></td>
                        <td><?= $row['Price'] ?></td>
                        <td><?= $row['Add_Date'] ?></td>
                        <td><?= $row['Country_miade'] ?></td>
                        <td><img src="layout/images/uploads/<?= $row['Image'] ?>" width="54px" alt=""></td>
                        <td><?= $row['State'] ?></td>
                        <td><?= $row['Rating'] ?></td>
                        <td><?= $row['Tages'] ?></td>
                        <td><?= $row['cat_name'] ?></td>
                        <td><?= $row['user_name'] ?></td>
                        <td>
                            <a href="?do=edite&id=<?= $row['Item_ID'] ?>&" class="btn btn-success"><i
                                        class="fa fa-edit"></i>Edit</a>
                            <a href="?do=delete&id=<?= $row['Item_ID'] ?>" class="btn btn-danger confirm"><i
                                        class="fa fa-trash"></i>Delete</a>

                            <?php if ($row['Approve'] == 0) { ?>
                                <a href="?do=approve&id=<?= $row['Item_ID'] ?>" class="btn btn-info"><i
                                            class="fa fa-edit"></i>Approve</a>
                            <?php } ?>


                        </td>


                        <!--                        <td><a href="?do=edite&id=-->
                        <?//= $row['Item_ID'] ?><!--&" class="btn btn-success"><i-->
                        <!--                                        class="fa fa-edit"></i>Edit</a></td>-->
                        <!--                        <td><a href="?do=delete&id=-->
                        <?//= $row['Item_ID'] ?><!--" class="btn btn-danger confirm"><i-->
                        <!--                                        class="fa fa-trash"></i>Delete</a></td>-->
                        <!--                        --><?php
                        //                        if ($row['Approve']==0) {
                        //                            ?>
                        <!--                            <td>-->
                        <!--                                <a href="?do=approve&id=-->
                        <?//= $row['Item_ID'] ?><!--" class="btn btn-info">-->
                        <!--                                    <i class="fa fa-edit"></i>-->
                        <!--                                    Approve-->
                        <!--                                </a>-->
                        <!--                            </td>-->
                        <!--                            --><?php
                        //                        }
                        //                        ?>
                    </tr>
                    <?php
                }
                ?>
            </table>

        </div>


        <?php
    }
    /*=============  end page add Categories ==============*/
    /*=============================================================*/
    /*============= start page insert Categories ==============*/

    elseif ($do == "add") {
        ?>
        <h2 class="text-center title-muber">Item New Add Adminstration</h2>
        <div class="container edit">
            <form method="POST" action="?do=insert" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="staticnameitem" class="col-sm-1 col-form-label">Name</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="text" class="form-control" id="staticnameitem" name="nameitem"
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
                               required="required"
                               autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputprice" class="col-sm-1 col-form-label">Price</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="text" class="form-control" id="inputprice" name="price"
                               value=""
                               placeholder="Price"
                               maxlength="200"
                               required="required"
                               autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputCountry_miade" class="col-sm-1 col-form-label">Coun_miade</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="text" class="form-control" id="inputCountry_miade" name="country_miade"
                               value=""
                               placeholder="Country_miade"
                               maxlength="200"
                               required="required"
                               autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputImage" class="col-sm-1 col-form-label">Image</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="file" class="form-control" id="inputImage" name="image">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputImage" class="col-sm-1 col-form-label">State</label>
                    <div class="col-sm-10 my-form-group sel">
                        <select class="form-control" name="state">
                            <option value="0">.....</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Old</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputImage" class="col-sm-1 col-form-label">Rating</label>
                    <div class="col-sm-10 my-form-group">
                        <select class="form-control" name="rating">
                            <option value="0">.....</option>
                            <option value="1">1</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="4">5</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="inputImage" class="col-sm-1 col-form-label">Mumber</label>
                    <div class="col-sm-10 my-form-group">
                        <select class="form-control" name="mumber">
                            <option value="0">.....</option>
                            <?php
                            $stmt = $conn->prepare("SELECT UserID, Username FROM  usres");
                            $stmt->execute();
                            $rows = $stmt->fetchAll();
                            foreach ($rows as $row) {
                                ?>
                                <option value="<?= $row['UserID'] ?>"><?= $row['Username'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputImage" class="col-sm-1 col-form-label">Categrie</label>
                    <div class="col-sm-10 my-form-group">
                        <select class="form-control" name="categrie">
                            <option value="0">.....</option>
                            <?php
                            $stmt = $conn->prepare("SELECT Cat_ID, Name FROM  categories WHERE perant = 0");
                            $stmt->execute();
                            $rows = $stmt->fetchAll();
                            foreach ($rows as $row) {
                                ?>
                                <option value="<?= $row['Cat_ID'] ?>"><?= $row['Name'] ?></option><?php

                                $stmt2 = $conn->prepare("SELECT Name FROM categories WHERE perant = {$row['Cat_ID']}");
                                $stmt2->execute();
                                $rows2 = $stmt2->fetchAll();
                                foreach ($rows2 as $row2) {
                                    ?>
                                    <option value="<?= $row2['Cat_ID'] ?>">-----<?= $row2['Name'] ?></option><?php

                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="inputtages" class="col-sm-1 col-form-label">tages</label>
                    <div class="col-sm-10 my-form-group">
                        <input type="text" class="form-control" id="inputtages" name="tages"
                               value=""
                               placeholder="tages"
                               maxlength="200">
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-sm-10 offset-1">
                        <input type="submit" class="btn  btn-primary btn-block" name="add" value="Add-insert-Item">
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
        <h2 class="text-center title-muber">Insert Item</h2>
        <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])) {
            $nameitem = $_POST['nameitem'];
            $descraption = $_POST['descraption'];
            $price = $_POST['price'];
            $country_miade = $_POST['country_miade'];
            $image = $_FILES['image'];
            $state = $_POST['state'];
            $rating = $_POST['rating'];
            $mumber_ID = $_POST['mumber'];
            $categrie_ID = $_POST['categrie'];
            $tages = $_POST['tages'];
            $add = $_POST['add'];

            /*================================*/
            /* save path image   */
            /*================================*/


            if (isset($_POST['add'])) {
                $file_name = $_FILES['image']['name'];
                $file_type = $_FILES['image']['type'];
                $file_size = $_FILES['image']['size'];
                $file_tem_loc = $_FILES['image']['tmp_name'];
                $file_store = "layout/images/uploads/" . $file_name;
                move_uploaded_file($file_tem_loc, $file_store);
            }


            /*================================*/
            /* save path image   */
            /*================================*/

            $formErrors = array();
            if (strlen($nameitem) > 30) {
                $formErrors['nameitemStrlen'] = "can not lanth > 20";
                ?>
                <div class="alert alert-primary" role="alert"><?= $formErrors['nameitemStrlen'] ?></div><?php
            }
            if (empty($nameitem)) {
                $formErrors['nameitemEmpty'] = "can not empty nnameitemEmpty";
                ?>
                <div class="alert alert-primary" role="alert"><?= $formErrors['nameitemEmpty'] ?></div><?php
            }
            if (strlen($nameitem) < 1) {
                $formErrors['nameitemStrlen'] = "can not lanth < 5";
                ?>
                <div class="alert alert-primary" role="alert"><?= $formErrors['nameitemStrlen'] ?></div><?php
            }

            if (empty($formErrors)) {
                $resCheckItemDBUsenName = checkItem("Name", "items", "$nameitem");
                if ($resCheckItemDBUsenName == 0) {
                    $sql = "INSERT INTO items (	Name, Description, Price, Add_Date, Country_miade, Image, 	State, Rating, Cat_ID, User_ID, Tages)
                                        VALUES(:name, :description, :price, now(), :country_miade, :image, :state, :rating, :cat_ID, :user_ID, :tages)";
                    $stmt = $conn->prepare($sql);
                    try {
                        $stmt->execute(array(

                            "name" => $nameitem,
                            "description" => $descraption,
                            "price" => $price,
                            "country_miade" => $country_miade,
                            "image" => $image['name'],
                            "state" => $state,
                            "rating" => $rating,
                            "cat_ID" => $categrie_ID,
                            "user_ID" => $mumber_ID,
                            "tages" => $tages

                        ));

                        $res = $stmt->rowCount();
                        ?>
                        </div>
                        <?php
                        redirectHome("Recourd Insert one <?= $res ?>", "?do=manage", 2);
                    } catch (PDOException $ex) {
                        redirectHome("Duplicate entry <?= $nameitem ?>", "back", 2);
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
    /*=============  end page add Categories ==============*/
    /*=============================================================*/
    /*============= start page insert Categories ==============*/
    elseif ($do == "edite") {

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $checkID = checkItem("Item_ID", " items", "$id");
            if ($checkID > 0) {

                $sqlInnerJoin = "SELECT items.*, usres.Username as user_name, categories.Name as cat_name 
                                FROM items 
                                INNER JOIN usres, categories
                                WHERE items.User_ID = usres.UserID AND items.Cat_ID = categories.Cat_ID AND items.Item_ID = $id";
                $stmt = $conn->prepare($sqlInnerJoin);
                $stmt->execute();
                $row = $stmt->fetch();
                ?>
                <h2 class="text-center title-muber">Item New Add Adminstration</h2>
                <div class="container edit">
                    <form method="POST" action="?do=update">
                        <input type="hidden" name="id" value="<?= $row['Item_ID'] ?>">
                        <div class="form-group row">
                            <label for="staticnameitem" class="col-sm-1 col-form-label">Name</label>
                            <div class="col-sm-10 my-form-group">
                                <input type="text" class="form-control" id="staticnameitem" name="nameitem"
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
                                       required="required"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputprice" class="col-sm-1 col-form-label">Price</label>
                            <div class="col-sm-10 my-form-group">
                                <input type="text" class="form-control" id="inputprice" name="price"
                                       value="<?= $row['Price'] ?>"
                                       placeholder="Price"
                                       maxlength="200"
                                       required="required"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputCountry_miade" class="col-sm-1 col-form-label">Coun_miade</label>
                            <div class="col-sm-10 my-form-group">
                                <input type="text" class="form-control" id="inputCountry_miade" name="country_miade"
                                       value="<?= $row['Country_miade'] ?>"
                                       placeholder="Country_miade"
                                       maxlength="200"
                                       required="required"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputImage" class="col-sm-1 col-form-label">Image</label>
                            <div class="col-sm-10 my-form-group">
                                <input type="file" class="form-control" id="inputImage" name="image"
                                       value="<?= $row['Image'] ?>"
                                       placeholder="Country_miade"
                                       maxlength="200"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputImage" class="col-sm-1 col-form-label">State</label>
                            <div class="col-sm-10 my-form-group sel">
                                <select class="form-control" name="state">
                                    <option value="0"><?= $row['State'] ?></option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Old</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputImage" class="col-sm-1 col-form-label">Rating</label>
                            <div class="col-sm-10 my-form-group">
                                <select class="form-control" name="rating">
                                    <option value="0"><?= $row['Rating'] ?></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="inputImage" class="col-sm-1 col-form-label">Mumber</label>
                            <div class="col-sm-10 my-form-group">
                                <select class="form-control" name="mumber" required>
                                    <option value="<?= $row['User_ID'] ?>" selected><?= $row['user_name'] ?></option>
                                    <?php
                                    $stmt2 = $conn->prepare("SELECT UserID, Username FROM  usres");
                                    $stmt2->execute();
                                    $rows2 = $stmt2->fetchAll();
                                    foreach ($rows2 as $row2) {
                                        ?>
                                        <option value="<?= $row2['UserID'] ?>"><?= $row2['Username'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputImage" class="col-sm-1 col-form-label">Categrie</label>
                            <div class="col-sm-10 my-form-group">
                                <select class="form-control" name="categrie" required>
                                    <option value="<?= $row['Cat_ID'] ?>" selected><?= $row['cat_name'] ?></option>
                                    <?php
                                    $stmt3 = $conn->prepare("SELECT Cat_ID, Name FROM  categories");
                                    $stmt3->execute();
                                    $rows3 = $stmt3->fetchAll();
                                    foreach ($rows3 as $row3) {
                                        ?>
                                        <option value="<?= $row3['Cat_ID'] ?>"><?= $row3['Name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="inputtages" class="col-sm-1 col-form-label">tages</label>
                            <div class="col-sm-10 my-form-group">
                                <input type="text" class="form-control" id="inputtages" name="tages"
                                       value="<?= $row['Tages'] ?>"
                                       placeholder="tages"
                                       maxlength="200">
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-10 offset-1">
                                <input type="submit" class="btn  btn-primary btn-block" name="edite"
                                       value="Add-update-Item">
                            </div>
                        </div>
                    </form>
                </div>


                <?php
                $sql = "SELECT *, usres.Username as username, items.Name as itemname FROM comments
                INNER JOIN usres, items
                WHERE  	comments.User_ID = usres.UserID AND comments.Item_ID = items.Item_ID AND comments.Item_ID = ?";

                $stmt = $conn->prepare($sql);
                $stmt->execute(array($id));
                $rows = $stmt->fetchAll();

                if (!empty($rows)) {
                    ?>

                    <h2 class="text-center title-muber">Manage <?= $row['Name'] ?> Comments </h2>
                    <div class="container">
                        <div class="table-responsive">
                            <table class="main-table table table-bordered text-center">
                                <tr class="bg-dark">
                                    <th>Comment</th>
                                    <th>Com_Date</th>
                                    <th>User</th>
                                    <th><i class="fa fa-edit"></i>Control</th>
                                </tr>
                                <?php
                                foreach ($rows as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row['Comment'] ?></td>
                                        <td><?= $row['Com_Date'] ?></td>
                                        <td><?= $row['username'] ?></td>
                                        <td><a href="comment.php?do=edite&id=<?= $row['Com_ID'] ?>"
                                               class="btn btn-success"><i
                                                        class="fa fa-edit"></i>Edit</a>
                                            <a href="comment.php?do=delete&id=<?= $row['Com_ID'] ?>"
                                               class="btn btn-danger confirm"><i
                                                        class="fa fa-trash"></i>Delete</a>
                                            <?php
                                            if ($row['Status'] == 0) {
                                            ?>
                                            <a href="comment.php?do=aprrove&id=<?= $row['Com_ID'] ?>"
                                               class="btn btn-info"><i
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
                }
            } else {
                redirectHome("not id ualue", "?do=manage", "2");
            }

        } else {
            redirectHome("not request _GET  ualue", "?do=manage", "2");

        }


    }

    /*=============  end page add Categories ==============*/
    /*=============================================================*/
    /*============= start page insert Categories ==============*/
    elseif ($do == "update") {
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edite']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $resCheckItem = checkItem("Item_ID", "items", "$id");
            if ($resCheckItem == 1) {

                $nameitem = $_POST['nameitem'];
                $descraption = $_POST['descraption'];
                $price = $_POST['price'];
                $country_miade = $_POST['country_miade'];
                $image = $_POST['image'];
                $state = $_POST['state'];
                $rating = $_POST['rating'];
                $categrie_ID = $_POST['categrie'];
                $mumber_ID = $_POST['mumber'];
                $tages = $_POST['tages'];
                $edite = $_POST['edite'];


                $sql = "UPDATE items SET     Name = ?, Description=?, Price=?,
                                             Add_Date=now(), Country_miade=?, Image=?,
                                             State=?, Rating=?, Cat_ID=?, User_ID=?, Tages=?
                                             WHERE  Item_ID=? LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute(array(
                    $nameitem, $descraption, $price,
                    $country_miade,
                    $image, $state, $rating, $categrie_ID,
                    $mumber_ID, $tages, $id
                ));
                echo $stmt->rowCount();

            }
        }
    }
    /*=============  end page add Categories ==============*/
    /*=============================================================*/
    /*============= start page insert Categories ==============*/
    elseif ($do === "delete") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $resCheckItem = checkItem("Item_ID", "items", "$id");
            if ($resCheckItem > 0) {
                $sql = "DELETE FROM items WHERE Item_ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute(array($id));
                $res = $stmt->rowCount();
                redirectHome("sucsuss delet row $id", "?do=manage", "2");
            } else {
                redirectHome("not id in database  $id", "?do=manage", "2");

            }
        } else {
            redirectHome("Error id not su $id", "?do=manage", "2");
        }
    }

    /*=============  end page add Categories ==============*/
    /*=============================================================*/
    /*============= start page insert Categories ==============*/
    elseif ($do === "approve") {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $resCheckItem = checkItem("Item_ID", "items", "$id");
            if ($resCheckItem > 0) {
                $sql = "UPDATE items SEt Approve = 1  WHERE Item_ID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute(array($id));
                $res = $stmt->rowCount();
                redirectHome("sucsuss approv row $id", "?do=manage", "2");
            } else {
                redirectHome("not id in database  $id", "?do=manage", "2");

            }
        } else {
            redirectHome("Error id not su $id", "?do=manage", "2");
        }
    }

    /*=============  end page add Categories ==============*/
    /*=============================================================*/
    /*============= start page insert Categories ==============*/
    else {
        echo "else are";
    }
    include $tpl . "footer.php";
} /*=============================================================*/
else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>
