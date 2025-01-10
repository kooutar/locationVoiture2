<?php
class favorie{
    private $idfavorie;
    private $dateAjout;
    private PDO $db;
    function __construct($db)
    {
         $this->db=$db;
    }
     
    function ajoutFavorie($articleId,$iduser){
         $stmt=$this->db->prepare("INSERT INTO Favorie(iduser,articleId)
                                   Value(:iduser,:articleId)");
        $stmt->execute(['iduser'=>$iduser,
                        'articleId'=>$articleId]);
        $this->idfavorie=$this->db->lastInsertId();
    }

    function estFavori($article_id,$user_id){
        $stmt=$this->db->prepare("SELECT id FROM Favorie WHERE articleId = ? AND iduser = ?");
        $stmt->execute([$article_id, $user_id]);
        if ($stmt->rowCount() > 0) {
            return true;
        }else{
            return false;
        }
    }
    
    function removeFavorie($idarticle,$user_id){
      $stmt=$this->db->prepare("delete from Favorie where articleId = ? AND iduser = ? ");
      $stmt->execute([$idarticle, $user_id]);
    }

}

