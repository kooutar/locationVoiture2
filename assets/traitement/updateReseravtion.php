<?php 

require_once '../classe/reservation.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $iduser=$_POST['iduser'];
    $idvehicule =$_POST['idvehicule'];
    $dateReservation=$_POST['dateRservation'] ;
    $dateRendre=$_POST['dateRendre'];
    try {
    $database= new Database();
    $db=$database->connect();
    $reservation =new reservation($db);
    $reservation->updateRservation($iduser,$idvehicule,$dateReservation,$dateRendre);
    header('location: ../pages/myreservation.php');
    exit();
    } catch (PDOException $th) {
        $th->getMessage();
    }
   
}