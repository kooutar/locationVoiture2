<?php
require_once '../classe/db.php';
require_once '../classe/vehicule.php';

  if($_SERVER['REQUEST_METHOD']=='POST'){
    $idvehicule=$_POST['idvehicule'];
     $name=$_POST['name'];
     $price=$_POST['price'];
     $category=$_POST['category'];
     $lieu=$_POST['lieu'];
     $despo=$_POST['despo'];
    //  var_dump($_POST);

     try{
      
        $databe= new Database();
        $db=$databe->connect();
        
        $vehicule= new vehicule($db);
  
         $bool=$vehicule->updateVehicule($idvehicule,$name,$price,$lieu,$despo,$category);
        //  var_dump($bool);

        if($bool){
            echo "update succes";
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