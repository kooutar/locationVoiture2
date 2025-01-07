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
    function getTotalArticles() {
        $stmt = $this->db->prepare("SELECT COUNT(*) as totalArticles FROM Article");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['totalArticles'] : 0;
      }

      function Pagination($page) {
        $parPage = 8;
        // $totalVehicules = $this->getTotalVehicules();
        $premier = ($page * $parPage) - $parPage;
        $stmt = $this->db->prepare("SELECT * from  Article LIMIT :premier, :parPage");
       
        $stmt->bindParam(':premier', $premier, PDO::PARAM_INT);
        $stmt->bindParam(':parPage', $parPage, PDO::PARAM_INT);
        $stmt->execute();
        
       
        return $stmt->fetchAll();
      }
    function modifterArticle(){

    }
    function supprimmerArticle(){
        
    }
}