<div class="bg-dark ">
    <nav class="container navbar navbar-expand-lg  navbar-dark bg-dark">
        <a class="navbar-brand" href="dashboard.php"><?= lang("HOME_ADMIN")?></a>
        <button class="navbar-toggler" type="button"
                data-toggle="collapse" data-target="#app-nav"
                aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="app-nav" >

                <ul class="navbar-nav mr-auto ">
                    <li class="nav-item  "><a class="nav-link" href="categoris.php"><?= lang("Categoris")?></a></li>
                    <li class="nav-item  "><a class="nav-link" href="items.php"><?= lang("Items")?></a></li>
                    <li class="nav-item  "><a class="nav-link" href="muber.php"><?= lang("Members")?></a></li>
                    <li class="nav-item  "><a class="nav-link" href="comment.php"><?= lang("Comment")?></a></li>
                    <li class="nav-item  "><a class="nav-link" href="#"><?= lang("Statices")?></a></li>
                    <li class="nav-item  "><a class="nav-link" href="#"><?= lang("Logs")?></a></li>
                </ul>
                <ul  class="navbar-nav navbar-light ">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#"
                           id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                           <?php
                            if(isset($_SESSION['username'])){
                                echo $_SESSION['username'];
                            }else{
                                echo "login";
                            }
                           ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="../index.php">viset shop</a>
                            <a class="dropdown-item" href="muber.php?do=edite&id=<?=$_SESSION['UserID']?>"><?=lang("Edite_Profile")?></a>
                            <a class="dropdown-item" href="#"><?=lang("Stinge")?></a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><?=lang("LogOut")?></a>
                        </div>
                    </li>
                </ul>
        </div>
    </nav>
</div>
