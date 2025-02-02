<?php
session_start();
require_once '../classe/db.php';
require_once '../classe/article.php';
require_once '../classe/tag.php';
try {

    $database = new Database();
    $db = $database->connect();
    $tag = new tag($db);
    $article = new article($db);
} catch (PDOException $e) {
    $e->getMessage();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
        $tags = explode(',', $tagString);
        $result=[];
        // var_dump($tags);
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
        foreach ($tags as $tagFor) {
            //  echo $tagFor;
            if ($tag->tagNameExist(strtolower($tagFor)) == false) {
                  
                $result = $tag->ajoutTag($tagFor);
                if ($result) {
                    // echo "ajout avec succes";
                    $idlastInsertTag = $db->lastInsertId();
                    if ($idlastInsertTag) {
                        $article->ajouterArticle($titre, $description, $finalPath, $iduser, $idtheme);
                        // header('location: ../pages/articles.php');
                        // exit();
                    } else {
                        echo "Erreur : ID du tag invalide.";
                    }
                } else {
                    echo "err lors de insertion";
                }
            } else {
                $idTag=$tag->getIDbyNamTag($tagFor);
                $article->ajouterArticle($titre, $description, $finalPath, $iduser, $idtheme);
                // header('location: ../pages/acticles.php');
                // exit();
            }
            // $tag = trim($tag); // Supprime les espaces inutiles
            // if (!empty($tag)) {
            //     $stmt->execute(['tag_name' => $tag]);
            // }
        }
        
    }
}
