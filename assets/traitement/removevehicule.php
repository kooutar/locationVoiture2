<?php
require_once '../classe/db.php';
require_once '../classe/vehicule.php';
 if($_SERVER['REQUEST_METHOD']=="POST"){
    
    $idvehicule=$_POST['idvehicule'];
   
    try{
     $databe= new Database();
     $db=$databe->connect();
     
     $vehicule= new vehicule($db);
    
     if($vehicule->supprimerVehicule($idvehicule)){
        header("location:../pages/admin.php");
        exit();
     }else{
        echo "hfhf";
     }
     
    }catch(PDOException $e){
        $e->getMessage();
    }
 }
?>