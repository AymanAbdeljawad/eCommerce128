<?php

$do = isset($_GET['do']) ? $_GET['do'] : "Manage";

if ($do == "Manage") {
    echo "welcome to are catagure pge manage";
    echo "<a href='?do=Add'>Add New Catogre</a>";
} elseif ($do == "Add") {
    echo "welcome to are catagure pge add";

} else {
    echo "else page";
}

?>