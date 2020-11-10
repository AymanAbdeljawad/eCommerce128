


<?php

if(isset($_POST['submit'])){
    $file_name = $_FILES['filed']['name'];
    $file_type = $_FILES['filed']['type'];
    $file_size = $_FILES['filed']['size'];
    $file_tem_loc = $_FILES['filed']['tmp_name'];
    $file_store = "C:/xampp/htdocs/uploads/".$file_name;

    move_uploaded_file($file_tem_loc,$file_store);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="#" method="post" enctype="multipart/form-data">
    <input type="file" name="filed">
    <input type="submit" value="save" name="submit">
</form>
</body>
</html>