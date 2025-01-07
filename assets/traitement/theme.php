<?php 
require_once '../classe/db.php';
require_once '../classe/theme.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $themeName=htmlspecialchars(trim($_POST['theme']));
    if(!empty($themeName)){
        try {
            $database= new Database();
            $db= $database->connect();
            $theme = new theme($db);
            $theme->ajouterTheme($themeName);
        } catch (PDOException $e) {
           $e->getMessage();
        }
       
    }

}