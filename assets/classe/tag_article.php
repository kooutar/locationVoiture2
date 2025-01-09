<?php
class tag_article{
    private PDO $db;
    function __construct($db)
    {
        $this->db=$db;
    }

    function ajouterTag_article($idArticle,$idTag)
    {
        $stmt2=$this->db->prepare("insert tag_article(idtag,id_article) Values(:idtag,:id_article)");
        $stmt2->execute([
            'idtag'=>$idTag,
            'id_article'=>$idArticle]);
    }

    function afficheTag_article($idarticle){
        $stmt=$this->db->prepare("select t.tag
                            from tag t
                            inner join tag_article a_t
                            on a_t.idtag= t.id 
                            where a_t.id_article =:idarticle");
        if($stmt->execute(['idarticle'=>$idarticle])){
           return $stmt->fetchAll();
        }else{
            return [];
        }

        
        
    }

    

}