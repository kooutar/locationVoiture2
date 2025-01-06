<?php
 require_once '../classe/db.php';
 require_once '../classe/avis.php';
 try {
    $database = new Database();
    $db = $database->connect();
} catch (PDOException $e) {
    $e->getMessage();
}
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $note=$_POST['radio'];
    $commentaire=$_POST['commentaire'];
    $idvehicule=$_POST['idvehicule'];
    $iduser=$_POST['iduser'];
    try {
        $database = new Database();
        $db = $database->connect();
        $avis= new avis($db);
        $avis->ajoutAvis($commentaire,$note, $iduser,$idvehicule);
        header('location:../pages/cars.php');
        exit();
    } catch (PDOException $e) {
        $e->getMessage();
    }
   
  }
?>