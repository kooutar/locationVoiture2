<?php
require_once '../classe/db.php';
require_once '../classe/categorie.php';
 if($_SERVER['REQUEST_METHOD']=="POST"){
    
    $idcategorie=$_POST['idCategorie'];
   
    try{
     $databe= new Database();
     $db=$databe->connect();
     
     $categorie= new categorie($db);
    
     if($categorie->supprimercategorie($idcategorie)){
        echo "hfhf";
        header("location:../pages/admin.php?status=success");
        exit();
     }else{
      header("location:../pages/admin.php?status=error");
      exit(); 
     }
     
    }catch(PDOException $e){
        $e->getMessage();
    }
 }
?>