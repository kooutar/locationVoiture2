<?php
  require_once '../classe/db.php';
  require_once '../classe/categorie.php';
if($_SERVER['REQUEST_METHOD']="POST"){
    $nom=$_POST['nomCategorie'];
   
   try{
    $database = new Database();
    $db = $database->connect();
   
    $categorie=new categorie($db);
 
    if($categorie->ajouterCategorie($nom)){
        echo "ajout avec succes";
        header('location:../pages/admin.php');
        exit();
    } else{
        echo "fatal";
    }

   }catch(PDOException $e){

   }
}
