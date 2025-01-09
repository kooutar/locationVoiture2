<?php
class article{
    private $idarticle;
    private PDO $db;
    private $titre;
    private $contenu;
    private $path_image;
    function __construct($db)
    {
        $this->db=$db;
    }
    function ajouterArticle($titre,$contenu,$path_image,$iduser,$idtheme){
      $stmt=$this->db->prepare("Insert INTO Article(titre,contenu,path_image,iduser,idtheme) 
                              values(:titre,:contenu,:path_image,:iduser,:idtheme) ");
      $this->titre=$titre;
      $this->contenu=$contenu;
      $this->path_image=$path_image;
        $stmt->execute([
             'titre'=>$titre,
             'contenu'=>$contenu,
             'path_image'=>$path_image,
             'iduser'=>$iduser,
             'idtheme'=>$idtheme
        ]);

        $this->idarticle=$this->db->lastInsertId();
    }
    function getTotalArticles() {
        $stmt = $this->db->prepare("SELECT COUNT(*) as totalArticles FROM allArticle");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? $result['totalArticles'] : 0;
      }

      function Pagination($page,$idtheme) {
        $parPage = 4;
        $premier = ($page * $parPage) - $parPage;
        $stmt = $this->db->prepare("select * from Article
                                      where idtheme=:idtheme 
                                      LIMIT :premier, :parPage");
       
        $stmt->bindParam(':premier', $premier, PDO::PARAM_INT);
        $stmt->bindParam(':parPage', $parPage, PDO::PARAM_INT);
        $stmt->bindParam(':idtheme',$idtheme);
        $stmt->execute();
        return $stmt->fetchAll();
      }

      function getTagArticle($idarticle){
        $stmt=$this->db->prepare("SELECT tag");
      }
      function getIDArticle(){return $this->idarticle;}
    function modifterArticle(){

    }
    function supprimmerArticle(){
        
    }
}