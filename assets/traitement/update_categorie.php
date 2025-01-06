<?php 
require_once '../classe/db.php';
require_once '../classe/categorie.php';
if($_SERVER['REQUEST_METHOD']=="POST"){
      $idCategorie=$_POST['idcategorie'];
      $nomCategorie=$_POST['nomCategorie'];
      $descriptioncategorie=$_POST['descriptioncategorie'];
      try{
        $database=new Database();
        $db=$database->connect();
        $categorie=new categorie($db);
        $categorie->updateCategorie($idCategorie,$nomCategorie, $descriptioncategorie);
        header("location:../pages/admin.php");
        exit();
      }catch(PDOException $e)
      {
        $e->getMessage();
      }
}


?>