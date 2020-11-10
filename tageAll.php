<?php
session_start();
$pagetitle = "categories";
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['tag'])) {
    include "init.php";
    $tag = $_GET['tag'];
        ?>
        <div class="container">
            <h2 class='h1 font-weight-bold bg-my-c11 text-center mt-3 mb-3'> <?=isset($_GET['tag'])?$_GET['tag']:"catgorie"?> </h2>
            <div class="row">
                <?php
                
                
                $sql = "SELECT * FROM items WHERE Tages LIKE  '%$tag%' AND Approve=1";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $rowTages = $stmt->fetchAll();
                
                if($rowTages != 0){


                    foreach ($rowTages as $item) {
                        ?>
                        <div class="col-sm-6 col-md-3 mt-2">
                            <div class="border-dark border  text-center bg-light">
                                <img class="img-thumbnail w-100" src="admin/layout/images/uploads/<?=$item['Image']?>" alt="">
                                <div class="figure-caption">
                                    <h3><a href="showitem.php?id=<?=$item['Item_ID']?>"><?=$item['Name']?></a></h3>
                                    <p><?=$item['Description']?></p>
                                    <p><?=$item['Add_Date']?></p>
                                    <p class="h1 font-weight-bold text-info"><?=$item['Price']?>$</p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }else{
                    echo "not item tage";
                }
                

                ?>
            </div>
        </div>
        <?php

    include $tpl . "footer.php";
}


?>


