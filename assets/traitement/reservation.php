<?php
require_once '../classe/db.php';
require_once '../classe/reservation.php';
try{
  $database =new Database();
  $db=$database->connect();
}catch(PDOException $e){$e->getMessage();}
if($_SERVER['REQUEST_METHOD']=="POST"){
    $id_user=$_POST['iduser'];
    $idvehicule=$_POST['idvehicule'];
    $dateResrvation=$_POST['dateResrvation'];
    $dateRendre=$_POST['dateRendre'];
    $resrvation =new reservation($db);
    $bool=$resrvation->ajouterResrvation($id_user,$idvehicule,$dateResrvation,$dateRendre);
    if($bool){
        echo "resrve";
        header("location: ../pages/cars.php");
        exit;
    }else echo "err resrvation";
}
