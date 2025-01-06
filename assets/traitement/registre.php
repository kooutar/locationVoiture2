<?php
require_once '../classe/db.php';
require_once '../classe/client.php';
if($_SERVER['REQUEST_METHOD']=="POST"){
    $nom=$_POST['Nom'];
    $email=$_POST['email'];
    $tel=$_POST['tel'];
    $password=$_POST['password'];
    $dateNaissance=$_POST['dateNaissance'];
    $gender=$_POST['gender'];
    try {
    $database = new Database();
    $db = $database->connect();
    
    $client = new Client($db);
    

    $client->register([
        'nom' => $nom,
        'email' => $email,
        'telephone'=>$tel,
        'date_Naissance'=>$dateNaissance,
        'gender'=>$gender,
        'password' => $password
    ]);
    header("location: ../pages/login.php");
    exit();
  
   
} catch (Exception $e) {
    echo $e->getMessage();
}
}