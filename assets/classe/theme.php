<?php

require_once '../classe/db.php';
class theme{
    private PDO $db;
    function __construct($db)
    {
        $this->db=$db;
    }
    function ajouterTheme($theme){
        $stmt=$this->db->prepare("INSERT INTO theme(theme) VALUES(:theme) ");
        $stmt->execute(['theme'=>$theme]);
    }
    function getALLTheme(){
        $stmt=$this->db->prepare("SELECT * FROM theme ");
       if($stmt->execute()){
                return $stmt->fetchAll();
       }else return [];
    }
}