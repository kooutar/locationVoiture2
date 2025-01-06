<?php
class categorie{
   private int $id ;
   private String $name;
   private String $description;
   private PDO $db;
   public function __construct(PDO $db) {
    $this->db = $db;
}
   function ajouterCategorie($name) {
       $stmt=$this->db->prepare("INSERT INTO categorie(nom) Values(:name)");
     return $stmt->execute([':name'=>$name]);  
   }
   function afficheCategorie(){
      $stmt=$this->db->prepare("SELECT * FROM categorie;");
      $stmt->execute();
      if($stmt)
      {
        return $stmt->fetchAll();
      }else{
        return [];
      }
   }
   function removeCategorie(){

   }
   function updateCategorie($idcategorie, $nameCategorie, $description) {
    $stmt = $this->db->prepare("UPDATE categorie SET nom = :name, description = :description WHERE idCategorie = :idCategorie;");
    $stmt->execute([
        'name' => $nameCategorie,
        'description' => $description,
        'idCategorie' => $idcategorie
    ]);
}
 function supprimercategorie($idcategorie){
  $stmt = $this->db->prepare("DELETE FROM categorie WHERE idcategorie = :idcategorie");
  return $stmt->execute(['idcategorie' => $idcategorie]);
 }
}