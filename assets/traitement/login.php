<?php
require_once '../classe/db.php';
require_once '../classe/client.php';

if($_SERVER['REQUEST_METHOD']=="POST"){
    $email=$_POST['email'];
    $password=$_POST['password'];
    try {
        $database = new Database();
        $db = $database->connect();
        $client = new Client($db);
    
    $client->login($email, $password);
               
           
        
    
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
   
