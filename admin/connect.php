<?php
$dsn = "mysql:host=localhost;dbname=shop";
$user = "root";
$password = "";
$option = array(
  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
);
try {
    $conn = new PDO($dsn,$user,$password,$option);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch (PDOException $ex){
    echo "filed to not connect ".$ex->getMessage();
}

?>