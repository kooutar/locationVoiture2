<?php 
class vehicule{
    private PDO $db;
  function __construct(PDO $db)
  {
    $this->db=$db;
  }
  function ajouterVehicule($nom,$prix,$path_image,$lieu,$idCategorie):bool{
    $stmt=$this->db->prepare("INSERT INTO vehicule(nom,prix,path_image,lieu,idCategorie) values(:nom,:prix,:path_image,:lieu,:idCategorie);");
    $bool=$stmt->execute([':nom'=>$nom,
                    ':prix'=>$prix,
                    ':path_image'=>$path_image,
                    ':lieu'=>$lieu,
                ':idCategorie'=>$idCategorie]);
    if($bool){return true;}
    else{return false;}
  }
  function afficheVehicule($idCategorie = null){
     $stmt=$this->db->prepare("SELECT v.* ,c.nom as categorie FROM  vehicule v inner join categorie c on c.idCategorie =v.idCategorie");
    $bool= $stmt->execute();
    if($bool){return $stmt->fetchAll();}
    else{ return [];}
  }
  function getvehiculeNotReserved(){
     $stmt=$this->db->prepare("SELECT v.*
                                FROM vehicule v
                                LEFT JOIN reservation r ON v.idVehicule = r.idVehicule
                                WHERE r.idVehicule IS NULL;  ");
    $result =$stmt->execute();
    if($result){
      return $stmt->fetchAll();
    }else{
      return [];
    }
  }
  function getVehiculeWithId($id){
    $stmt=$this->db->prepare("SELECT v.* ,c.nom as categorie FROM  vehicule v inner join categorie c on c.idCategorie =v.idCategorie WHERE idVehicule=:idVehicule");
   $result= $stmt->execute([':idVehicule'=>$id]);
    if($result) return $stmt->fetch();
    else return [];
  }
  function getVehiculeByCategorie($idCategorie){
    $stmt=$this->db->prepare("SELECT v.* ,c.nom as categorie FROM  vehicule v inner join categorie c on c.idCategorie =v.idCategorie WHERE v.idCategorie=:idCategorie");
    $result= $stmt->execute([':idCategorie'=>$idCategorie]);
     if($result) return $stmt->fetchAll();
     else return [];
  }
  function supprimerVehicule($idvehicule): bool {
    
    $stmt = $this->db->prepare("DELETE FROM vehicule WHERE idVehicule = :idVehicule");
    return $stmt->execute(['idVehicule' => $idvehicule]);
}

function getVehiculeByName($name) {

  $stmt = $this->db->prepare("SELECT * FROM vehicule WHERE nom LIKE :name");
  

  $likedata = "%" . $name . "%";

  $stmt->bindParam(":name", $likedata, PDO::PARAM_STR);
 
  $stmt->execute();
  
  
  return $stmt->fetchAll();
}


function updateVehicule($idVehicule, $name, $price, $lieu, $disponsible, $idCategorie) {
  $stmt = $this->db->prepare("
      UPDATE vehicule
      SET nom = :nom, 
          prix = :prix, 
          lieu = :lieu, 
          disponsible = :disponsible, 
          idCategorie = :idCategorie
      WHERE idVehicule = :idVehicule
  ");
  $bool = $stmt->execute([
      "nom" => $name,
      "prix" => $price,
      "lieu" => $lieu,
      "disponsible" => $disponsible,
      "idCategorie" => $idCategorie,
      "idVehicule" => $idVehicule
  ]);

  if ($bool) {
      echo "Mise à jour réussie.";
      return true;
  } else {
      echo "Échec de la mise à jour.";
      return false;
  }
}
// ********************************
function getTotalVehicules() {
  $stmt = $this->db->prepare("SELECT COUNT(*) as totalVehicule FROM vehicule");
  $stmt->execute();
  $result = $stmt->fetch();
  return $result ? $result['totalVehicule'] : 0;
}
function Pagination($page) {
  $parPage = 3;
  // $totalVehicules = $this->getTotalVehicules();
  $premier = ($page * $parPage) - $parPage;
  $stmt = $this->db->prepare("SELECT v.* ,c.nom as categorie FROM  vehicule v inner join categorie c on c.idCategorie =v.idCategorie LIMIT :premier, :parPage");
 
  $stmt->bindParam(':premier', $premier, PDO::PARAM_INT);
  $stmt->bindParam(':parPage', $parPage, PDO::PARAM_INT);
  $stmt->execute();
  
 
  return $stmt->fetchAll();
}

}



?>