<?php
session_start(); //start the session
session_unset(); //session unset
session_destroy(); //sesion destroy

header("Location: index.php");
exit();
?>