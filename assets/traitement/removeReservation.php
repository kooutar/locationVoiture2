<?php 

require_once '../classe/reservation.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $iduser=$_POST['iduser'];
    $idvehicule =$_POST['idvehicule'];

    try {
    $database= new Database();
    $db=$database->connect();
    $reservation =new reservation($db);
    $reservation->daleteReservation($iduser,$idvehicule);
    if($reservation){echo "delete with succes";}
    else echo "fatal";
    header('location: ../pages/myreservation.php');
    exit();
    } catch (PDOException $th) {
        $th->getMessage();
    }
   
}