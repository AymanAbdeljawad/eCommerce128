<?php
session_start();
$pagetitle = "Add New item";
include "init.php";
if (isset($_SESSION['user'])) {
    if (isset($_SERVER['REQUEST_METHOD']) == "POST" && isset($_POST['add']) == "Add-insert-Item") {
        $nameitem = filter_var($_POST['nameitem'], FILTER_SANITIZE_STRING);
        $descraption = filter_var($_POST['descraption'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);
        $country_miade = filter_var($_POST['country_miade'], FILTER_SANITIZE_STRING);
        $image = $_FILES['image'];
        $state = filter_var($_POST['state'], FILTER_SANITIZE_NUMBER_INT);
        $tages = filter_var($_POST['tages'], FILTER_SANITIZE_STRING);
        $rating = filter_var($_POST['rating'], FILTER_SANITIZE_NUMBER_INT);
        $categrie_id = filter_var($_POST['categrie'], FILTER_SANITIZE_NUMBER_INT);


        /*================================*/
        /* save path image   */
        /*================================*/


        if (isset($_POST['add']) && isset($_FILES['image'])) {
            $file_name = $_FILES['image']['name'];
            $file_type = $_FILES['image']['type'];
            $file_size = $_FILES['image']['size'];
            $file_tem_loc = $_FILES['image']['tmp_name'];

            $imageRandName = rand(0, 10000000)."_".$file_name;

            $file_store = "layout/images/uploads/" . $imageRandName;
            move_uploaded_file($file_tem_loc, $file_store);
        }


        /*================================*/
        /* save path image   */
        /*================================*/


        $formErrors = array();
        if (empty($nameitem)) {
            $formErrors['usernameError'] = "numeItem empty";
        }
        if (strlen($nameitem) > 10) {
            $formErrors['usernameError'] = "numeItem strlen > 10";
        }
        if (strlen($nameitem) < 3) {
            $formErrors['usernameError'] = "numeItem strlen < 3";
        }
        if ($nameitem == "") {
            $formErrors['usernameError'] = "numeItem null";
        }


        $resCheckItem = checkItem("Name", "items", "$nameitem");
        if ($resCheckItem == 0 && empty($formErrors)) {
            $sqlIns = "INSERT INTO items
            (Name, Description, Price, Add_Date, Country_miade, Image, State, Rating, Cat_ID, User_ID, Tages)
            VALUES (:name, :description, :price, now(), :country_miade, :image, :state, :rating, :cat_ID, :user_ID, :tages)";


            $stmtIns = $conn->prepare($sqlIns);
            $stmtIns->execute(array(
                "name" => $nameitem,
                "description" => $descraption,
                "price" => $price,
                "country_miade" => $country_miade,
                "image" => $imageRandName,
                "state" => $state,
                "rating" => $rating,
                "cat_ID" => $categrie_id,
                "user_ID" => $_SESSION['User_ID'],
                "tages" => $tages,
            ));
            $resIns = $stmtIns->rowCount();
            if($resIns == 1){
                redirectHome("ins item new","back", "2");
            }else{
                redirectHome("not ins item new","back", "2");
            }
        }

    }


    ?>
    <div class="information">
        <div class="container">
            <h2 class="h1 text-center"><?= $pagetitle ?></h2>
            <div class="info-user">
                <div class="card" style="width: 100%">
                    <div class="card-body">
                        <div class="bg-primary p-2 rounded">
                            <span class="card-title font-weight-bold"><?= $pagetitle ?></span>
                        </div>
                        <!--                        <p class="card-title font-weight-bold">test</p>-->
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="text-center title-muber"><?= $pagetitle ?></h2>
                                <div class="container edit_com">


                                    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>"
                                          enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="staticnameitem" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-8 my-form-group">
                                                <input type="text" class="form-control live-name" id="staticnameitem"
                                                       name="nameitem"
                                                       value=""
                                                       placeholder="Name Categre"
                                                       autocomplete="off"
                                                       required="required"
                                                       maxlength="20">
                                                <?= empty($formErrors['usernameError']) ? "" : "<div class='alert alert-secondary p-0 mt-1 mb-0' role='alert'>" . $formErrors['usernameError'] . "</div>" ?>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="inputdescraption"
                                                   class="col-sm-2 col-form-label">Descraption</label>
                                            <div class="col-sm-8 my-form-group">
                                                <input type="text" class="form-control live-desc" id="inputdescraption"
                                                       name="descraption"
                                                       value=""
                                                       placeholder="Descraption"
                                                       maxlength="200"
                                                       required="required"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputprice" class="col-sm-2 col-form-label ">Price</label>
                                            <div class="col-sm-8 my-form-group">
                                                <input type="text" class="form-control Price" id="inputprice"
                                                       name="price"
                                                       value=""
                                                       placeholder="Price"
                                                       maxlength="200"
                                                       required="required"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputCountry_miade"
                                                   class="col-sm-2 col-form-label">Coun_miade</label>
                                            <div class="col-sm-8 my-form-group">
                                                <input type="text" class="form-control" id="inputCountry_miade"
                                                       name="country_miade"
                                                       value=""
                                                       placeholder="Country_miade"
                                                       maxlength="200"
                                                       required="required"
                                                       autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputImage" class="col-sm-2 col-form-label">Image</label>
                                            <div class="col-sm-8 my-form-group">
                                                <input type="file" class="form-control" id="inputImage" name="image">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputImage" class="col-sm-2 col-form-label">State</label>
                                            <div class="col-sm-8 my-form-group sel">
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
                                            <label for="inputImage" class="col-sm-2 col-form-label">Rating</label>
                                            <div class="col-sm-8 my-form-group">
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
                                            <label for="inputImage" class="col-sm-2 col-form-label">Categrie</label>
                                            <div class="col-sm-8 my-form-group">
                                                <select class="form-control" name="categrie">
                                                    <option value="0">.....</option>
                                                    <?php
                                                    $stmt = $conn->prepare("SELECT Cat_ID, Name FROM  categories WHERE perant = 0");
                                                    $stmt->execute();
                                                    $rows = $stmt->fetchAll();
                                                    foreach ($rows as $row) {
                                                        ?>
                                                        <option value="<?= $row['Cat_ID'] ?>"><?= $row['Name'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label for="statictages" class="col-sm-2 col-form-label">Tages</label>
                                            <div class="col-sm-8 my-form-group">
                                                <input type="text" class="form-control " id="statictages"
                                                       name="tages"
                                                       value=""
                                                       placeholder="tages"
                                                       maxlength="250">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <div class="col-sm-8 offset-2">
                                                <input type="submit" class="btn  btn-primary btn-block" name="add"
                                                       value="Add-insert-Item">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <div class="col-md-4 mt-4">
                                <div>
                                    <div class="border-dark border text-center bg-light mb-2 live-preview">
                                        <img class="img-thumbnail w-100 mb-1"
                                             src="admin/layout/images/uploads/IMG-20190325-WA0003.jpg">
                                        <div class="figure-caption">
                                            <h3>Name</h3>
                                            <p>Description</p>
                                            <span class="h1 font-weight-bold text-info">Price$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
} else {
    header("Location: login.php");
    exit();
}
include $tpl . "footer.php";
?>
