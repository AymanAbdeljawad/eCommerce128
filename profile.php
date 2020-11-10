<?php
session_start();
$pagetitle = "Profile";
include "init.php";
if(isset($_SESSION['user'])){

    $getUser = $conn->prepare("SELECT * FROM usres WHERE Username = ?");
    $getUser->execute(array($_SESSION['user']));
    $rowGetUser = $getUser->fetch();


?>
<div class="information">
    <div class="container">
        <h2 class="h1 text-center mt-2">My Information</h2>
        <div class="info-user mt-2">
            <div class="card" style="width: 100%">
<!--                <img class="img-thumbnail" width="25%" src="download.jpg" alt="Card image cap">-->
                <div class="card-body">
                   <div class="bg-primary p-2 rounded">
                        <span class="card-title font-weight-bold">Name : </span><span class="font-weight-bold"> <?=$rowGetUser['Username']?></span>
                   </div>
                    <p class="card-title font-weight-bold">
                       <i class="fa fa-female"></i> Email : <span class="font-weight-bold"> <?=$rowGetUser['Email']?></span></p>
                    <p class="card-title font-weight-bold">
                        <i class="fa fa-user"></i>Full Name : <span class="font-weight-bold"> <?=$rowGetUser['Fullname']?></span></p>
                    <p class="card-title font-weight-bold">
                        Reguster Date : <span class="font-weight-bold"> <?=$rowGetUser['RegusterDate']?></span></p>
                    <p class="card-title font-weight-bold">
                        <i class="fa fa-lock"></i>Favourite Category : <span class="font-weight-bold"> ffffffffffffffff</span></p>
                    <p class="card-text">Some quick example of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>

        <div class="info-user mt-2" id="MyADS">
            <div class="card" style="width: 100%">
                <!--                <img class="img-thumbnail" width="25%" src="download.jpg" alt="Card image cap">-->
                <div class="card-body">
                    <div class="bg-primary p-2 rounded">
                        <span class="card-title font-weight-bold">
                        Name : </span><span class="font-weight-bold"> Ads </span>
                    </div>
                    <div class="row">
                        <?php
                        foreach (getItems("User_ID",$rowGetUser['UserID']) as $item) {
                            ?>
                            <div class="col-sm-6 col-md-3">
                                <div class="border-dark border text-center overflow-auto position-relative bg-light mb-2">

                                    <?php

                                    if($item['Approve'] == 0){
                                        ?>
                                        <div class="witing-approve overflow-hidden"><a href="#">witing approve</a></div>
                                        <?php
                                    }

                                    ?>

<!--                                    <div class="witing-approve">witing approve</div>-->
                                    <img class="img-thumbnail w-100 mb-1" src="layout/images/uploads/<?=$item['Image']?>" alt="">
                                    <div class="figure-caption ">
                                        <h3><a href="showitem.php?id=<?=$item['Item_ID']?>"><?=$item['Name']?></a></h3>
                                        <p><?=$item['Description']?></p>
                                        <p><?=$item['Add_Date']?></p>
                                        <p class="h1 font-weight-bold text-info"><?=$item['Price']?>$</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="alert alert-secondary" role="alert">
                        <a href="newaddcom.php">New Add Comment</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="info-user mt-2">
            <div class="card" style="width: 100%">
                <!--                <img class="img-thumbnail" width="25%" src="download.jpg" alt="Card image cap">-->
                <div class="card-body">
                    <div class="bg-primary p-2 rounded">
                        <span class="card-title font-weight-bold">
                        Name : </span><span class="font-weight-bold"> comments </span>
                    </div>
                    <?php

                    $stmt = $conn->prepare("SELECT Comment FROM comments WHERE User_ID = ? AND Status != 0");
                    $stmt->execute(array($rowGetUser['UserID']));
                    $rowComs = $stmt->fetchAll();
                    if(! empty($rowComs)){
                        $connter = 0;
                        foreach ($rowComs as $rowCom ){
                            $connter++;
                            ?>
                            <p class="card-title font-weight-bold">Comment <?=$connter?> : <span class="font-weight-bold"> <?=$rowCom['Comment']?> </span></p>



                            <?php
                        }
                    }else{
                        echo "<p class='p-2 text-dark font-weight-bold'>not comments</p>";
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>



<?php
}else{
    header("Location: login.php");
    exit();
}
include $tpl . "footer.php";
?>
