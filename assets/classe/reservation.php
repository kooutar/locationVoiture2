<?php
 
require_once '../classe/db.php';
 class reservation{
    private PDO $db;
    function __construct($db)
    {
        $this->db=$db;
    }
    function ajouterResrvation($id_user,$id_vehicule,$date_debut,$date_fin) :bool{
     $stmt=$this->db->prepare("CALL AjouterReservation(:iduser,:id_vehicule,:datedebut,:datefin)");
    $result= $stmt->execute([
           'iduser'=> $id_user,
            'id_vehicule'=>$id_vehicule,
            'datedebut'=>$date_debut,
            'datefin'=>$date_fin
     ]);
     if($result) return true;
     else false;

    }

    function showAllreservation($id_user,$id_vehicule){
       $stmt= $this->db->prepare("SELECT * from reservation where iduser=:iduser and idVehicule=:idVehicule");
       $resrvations=$stmt->execute(['iduser'=>$id_user,
                                     'idVehicule'=>$id_vehicule]);
       if($resrvations)
        return $stmt->fetch();
       else return [];

    }
    function showALLreservationCleint($id_user){
       $stmt = $this->db->prepare("SELECT r.idVehicule, r.date_debut ,r.date_fin , r.status, v.path_image ,v.nom 
       FROM reservation r
       inner join vehicule v
       on r.idVehicule=v.idVehicule
        WHERE iduser=:iduser ");
       $resrvations =$stmt->execute(['iduser'=>$id_user]);
       if($resrvations){
         return $stmt->fetchALL();
       }else{
         return [];
       }
    }

    function updateRservation($iduser,$id_vehicule,$datedebut,$datefin){
      $stmt=$this->db->prepare("update reservation 
                                 set date_debut=:date_debut ,date_fin=:date_fin
                                 where iduser=:iduser and idVehicule=:idVehicule");

      
       
        $stmt->bindParam(':date_debut', $datedebut);
        $stmt->bindParam(':date_fin', $datefin);
        $stmt->bindParam(':iduser', $iduser);
        $stmt->bindParam(':idVehicule', $id_vehicule);

       
        $stmt->execute();
      
      
    }

    function daleteReservation($iduser,$id_vehicule){
      $stmt=$this->db->prepare("delete from reservation 
      where iduser=:iduser and idVehicule=:idVehicule");
      $stmt->bindParam(':iduser', $iduser);
      $stmt->bindParam(':idVehicule', $id_vehicule);
      $stmt->execute();
    }
    function affichageReservationAdmin() {
      $stmt = $this->db->prepare("SELECT 
          u.nom AS nom_client, 
          v.nom AS nom_vehicule, 
          r.iduser,
          r.idVehicule,
          r.date_debut, 
          r.date_fin, 
          r.status
      FROM 
          reservation r
      JOIN 
          utilisateur u ON r.iduser = u.iduser
      JOIN 
          vehicule v ON r.idVehicule = v.idVehicule");
      
      if ($stmt->execute()) {
          return $stmt->fetchAll();  
      } else {
          return [];  
      }
  }
  
 }

?>