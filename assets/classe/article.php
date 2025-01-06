<?php
class article{
    private PDO $db;
    function __construct($db)
    {
        $this->db=$db;
    }
    function ajouterArticle($titre,$contenu,$path_image,$iduser,$idtag){
      $stmt=$this->db->prepare("Insert INTO Article(titre,contenu,path_image,iduser,idtag) 
                              values(:titre,:contenu,:path_image,:iduser,:idtag) ");
        $stmt->execute([
             'titre'=>$titre,
             'contenu'=>$contenu,
             'path_image'=>$path_image,
             'iduser'=>$iduser,
             'idtag'=>$idtag
        ]);
    }
    function modifterArticle(){

    }
    function supprimmerArticle(){
        
    }
}