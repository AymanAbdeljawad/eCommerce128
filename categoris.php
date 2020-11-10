<?php
session_start();
$pagetitle = "categories";
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['cat_id'])) {
    include "init.php";
    $getID = isset($_GET['cat_id']) && is_numeric($_GET['cat_id'])?intval($_GET['cat_id']):0;
    $chackItm = checkItem("Cat_ID","categories",$getID);
    if($getID != 0 && $chackItm == 1){
        ?>
        <div class="container">
            <h2 class='h1 font-weight-bold bg-my-c11 text-center mt-3 mb-3'> <?=$_GET['cat_name']?> </h2>
            <div class="row">
                <?php
                foreach (getItems("Cat_ID",$getID) as $item) {
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
                ?>
            </div>
        </div>
        <?php
    }else{

        echo "not id valide";
    }

}
include $tpl . "footer.php";


//   $sql ="SELECT * FROM items INNER JOIN categories WHERE items.Cat_ID = categories.Cat_ID";
//   $stmt = $conn->prepare($sql);
//   $stmt->execute();
//   $rows = $stmt->fetchAll();
//
//   print_r($rows);

?>


