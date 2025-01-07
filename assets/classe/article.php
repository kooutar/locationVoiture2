<?php
class article{
    private PDO $db;
    function __construct($db)
    {
        $this->db=$db;
    }
    function ajouterArticle($titre,$contenu,$path_image,$iduser,$idtag,$idtheme){
      $stmt=$this->db->prepare("Insert INTO Article(titre,contenu,path_image,iduser,idtheme) 
                              values(:titre,:contenu,:path_image,:iduser,:idtheme) ");
        $stmt->execute([
             'titre'=>$titre,
             'contenu'=>$contenu,
             'path_image'=>$path_image,
             'iduser'=>$iduser,
             'idtheme'=>$idtheme
        ]);

        $lastIdtagInserted=$this->db->lastInsertId();
        $stmt2=$this->db->prepare("insert tag_article(idtag,id_article) Values(:idtag,:id_article)");
        $stmt2->execute([
            'idtag'=>$idtag,
            'id_article'=>$lastIdtagInserted]);
    }
    function modifterArticle(){

    }
    function supprimmerArticle(){
        
    }
}