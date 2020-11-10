<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= $css ?>bootstrap.css">
    <link rel="stylesheet" href="<?= $css ?>jquery-ui.css"/>
    <link rel="stylesheet" href="<?= $css ?>jquery.selectBoxIt.css"/>
    <link rel="stylesheet" href="<?= $font ?>css/all.css">
    <link rel="stylesheet" href="<?= $css ?>style.css">
    <title><?= getTitle() ?></title>
</head>
<body>
<div class="container">
    <div class="upper-bar bg-light">
        <?php
        if (isset($_SESSION['user'])) {
            ?>


            <div class="dropdown">
                <img src="download (2).jpg" width="30px" class="rounded-circle" alt="">
                <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                      <?=$_SESSION['user']?>
                </button>
                <div class="dropdown-menu bg-primary" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="profile.php">My Profile</a>
                    <a class="dropdown-item" href="profile.php#MyADS">My ADS</a>
                    <a class="dropdown-item" href="newaddcom.php">New Add Item</a>
                    <a class="dropdown-item" href="logout.php">logout</a>
                </div>
            </div>

<!--            <span class=" font-weight-bold p-2">Welcom --><?//=$_SESSION['user']?><!--</span>-->
<!--            <a class="" href="profile.php">My Profile</a> |-->
<!--            <a class="" href="newaddcom.php">New Add Item</a> |-->
<!--            <a class="" href="logout.php">logout</a>-->
            <?php
        } else {
            ?>
            <a class="" href="login.php"><span class="fa-pull-right mr-5 font-weight-bold p-2">Login/SignUp</span></a>
            <?php
        }
        ?>
    </div>
    <div class="clearfix"></div>

</div>
<div class="bg-dark ">
    <nav class="container navbar navbar-expand-lg  navbar-dark bg-dark">
       <div>
           <a class="navbar-brand" href="index.php">Hom Page</a>
           <button class="navbar-toggler" type="button"
                   data-toggle="collapse" data-target="#app-nav"
                   aria-controls="navbarSupportedContent"
                   aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>

       </div>
        <div class="collapse navbar-collapse " id="app-nav">
            <ul class="nav  navbar-nav ml-auto">
                <?php
                foreach (getCats("WHERE perant = 0") as $cat) {
                    ?>
                    <li class="nav-item   "><a class="nav-link"
                                              href="categoris.php?cat_id=<?= $cat['Cat_ID']?>&cat_name=<?=$cat['Name']?>">
                            <?= $cat['Name'] ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </nav>
</div>


