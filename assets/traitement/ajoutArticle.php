<?php
session_start();
require_once '../classe/db.php';
require_once '../classe/article.php';
require_once '../classe/tag.php';
try{

    $database = new Database();
    $db = $database->connect();
    $tag = new tag($db);
    $article = new article($db);
} catch(PDOException $e){
    $e->getMessage();
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    $titre=htmlspecialchars(trim($_POST['titre']));
    $description=htmlspecialchars(trim($_POST['description']));
    $tagName=htmlspecialchars(trim($_POST['tag']));
    if(!empty($titre)&& !empty($titre) && !empty($tagName)){
        if($tag->tagNameExist(strtolower($tagName))==false){
            $result= $tag->ajoutTag($tagName);
            if($result){echo "ajouter";}
            else "non ajoute";
        }else echo "deja exist";
        

        
    }
}
