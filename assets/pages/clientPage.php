<?php
session_start();
if(!isset($_SESSION['id_user']) || $_SESSION['idrole']!="client"){
    header("location: login.php");
    exit();
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
   <h1>hello</h1> 
</body>
</html>
