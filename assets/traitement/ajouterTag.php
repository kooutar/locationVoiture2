<?php

session_start();
require_once '../classe/db.php';
require_once '../classe/article.php';
require_once '../classe/tag.php';
require_once '../classe/tag_article.php';
try {

    $database = new Database();
    $db = $database->connect();
    $tag = new tag($db);
    $article = new article($db);
} catch (PDOException $e) {
    $e->getMessage();
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $titre = htmlspecialchars(trim($_POST['titre']));
    $description = htmlspecialchars(trim($_POST['description']));
    // $idtag=htmlspecialchars(trim($_POST['tag']));
    $idtheme = htmlspecialchars(trim(intval($_POST['idtheme'])));
    $iduser = htmlspecialchars(trim($_POST['iduser']));
    $tagName = $_POST['tagName'] ; 
    $tagsArray = json_decode($tagName, true); // true pour obtenir un tableau associatif


    $tags = array_column($tagsArray, 'value');


    $tagString= implode(", ", $tags); // Résultat : kaoutar, laajil

    $finalPath = null;
   
    if (!empty($titre) && !empty($titre) && (!empty($tagName)) && isset($_FILES['media']['name']) && !empty($_FILES['media']['name'])) {
   
        $dir = '../uplods/';
        $path = basename($_FILES['media']['name']);
        $finalPath = $dir . uniqid() . "_" . $path;
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'svg'];
        $extension = pathinfo($finalPath, PATHINFO_EXTENSION);
        if (in_array(strtolower($extension), $allowedExtensions)) {
            if (move_uploaded_file($_FILES['media']['tmp_name'], $finalPath)) {
                // echo "bien";
            } else {
                // echo "err";
            }
        } else {
            echo "Extension non autorisée pour le fichier : " . $_FILES['media']['name'];
        }
        $article->ajouterArticle($titre, $description, $finalPath, $iduser, $idtheme);
        $idarticle=$db->lastInsertId();

        $tags = explode(',', $tagString);
        $allTagArticle=array();
        foreach ($tags as $tagFor) {
            array_push( $allTagArticle,$tagFor);
        }
       $tag_article = new tag_article($db);
        foreach($allTagArticle as $tagArray){
            $tag->ajoutTag($tagArray);
            $idtag=$db->lastInsertId();
            $tag_article->ajouterTag_article($idarticle,$idtag);
        }

    }
}