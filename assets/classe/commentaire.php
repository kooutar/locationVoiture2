<?php 
  class commentaire{
    private $idcommentaire;
    private $commentaire;
    private PDO $db;
     function __construct($db)
     {
       $this->db=$db; 
     }

     function ajoutCommentaire($commentaire,$iduser,$idarticle){
       $stmt= $this->db->prepare("insert into commentaire(commentaire,clientId,articleId)
                                  value(:commentaire,:iduser,:idarticle) ");
        
         $stmt->execute(['commentaire'=>$commentaire,
                                'iduser'=>$iduser,
                                 'idarticle'=>$idarticle]);
        $this->commentaire=$commentaire;
        $this->idcommentaire=$this->db->lastInsertId();
     }
      function getALLcommentaire(){
        $stmt=$this->db->prepare("SELECT * from commentaire");
        if($stmt->execute()){
            return $stmt->fetchAll();
        }else return [];
      }
      
     function __get($name)
     {
        return $this->$name;
     }

  }
?>