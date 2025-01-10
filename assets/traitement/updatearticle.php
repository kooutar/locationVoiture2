<?php
require_once '../classe/db.php';
require_once '../classe/article.php';
if(isset($_POST['Accepter'])){
    $iduser=$_POST['iduser'];
    $idarticle=$_POST['idarticle'];
    $status=$_POST['status'];
    try {
        $database = new Database();
        $db = $database->connect();
        $article=new article($db);
        $article->updateReservation($status,$idarticle);
        header('location: ../pages/admin.php');
        exit();
    } catch (PDOException $e) {
       
    }
}

if(isset($_POST['Refuser'])){
    $iduser=$_POST['iduser'];
    $idarticle=$_POST['idarticle'];
    $status=$_POST['status'];
    try {
        $database = new Database();
        $db = $database->connect();
        $article=new article($db);
        $article->updateReservation($status,$idarticle);
        header('location: ../pages/admin.php');
        exit();
    } catch (PDOException $e) {
       
    }
}