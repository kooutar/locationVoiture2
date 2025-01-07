<?php
class tag{
    private PDO $db;
    function __construct($db)
    {
        $this->db=$db;
    }
    function ajoutTag($name){
        $stmt=$this->db->prepare("INSERT  into tag(tag) value (:tagname) ");
       return $stmt->execute(['tagname'=>$name]);
    }
    function tagNameExist($tagName): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tag WHERE tag = :tagname");
        $stmt->execute(['tagname' => $tagName]);
        $count = $stmt->fetchColumn(); // Récupère le nombre de lignes correspondant au tag
    
        return $count > 0; // Retourne true si une ou plusieurs lignes existent
    }
    
    function getAlltag(){
        $stmt=$this->db->prepare("SELECT * from tag");
       $result= $stmt->execute();
       if($result)
        return $stmt->fetchAll();
       else 
         return [];

    }


}