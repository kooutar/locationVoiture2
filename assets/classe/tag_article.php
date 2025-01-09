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

    

}