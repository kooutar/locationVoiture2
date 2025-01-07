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
    $tagName = $_POST['tagName'] ; // Texte saisi par l'utilisateur
    $tagId = $_POST['tagId'] ; // ID du tag sélectionné

    $finalPath = null;
    var_dump($_FILES['media']['name']);
    if (!empty($titre) && !empty($titre) && (!empty($tagName)|| !empty( $tagId )) && isset($_FILES['media']['name']) && !empty($_FILES['media']['name'])) {
        $dir = '../uplods/';
        $path = basename($_FILES['media']['name']);
        $finalPath = $dir . uniqid() . "_" . $path;
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'svg'];
        $extension = pathinfo($finalPath, PATHINFO_EXTENSION);
        if (in_array(strtolower($extension), $allowedExtensions)) {
            if (move_uploaded_file($_FILES['media']['tmp_name'], $finalPath)) {
                echo "bien";
            } else {
                echo "err";
            }
        } else {
            echo "Extension non autorisée pour le fichier : " . $_FILES['media']['name'];
        }
        echo "i'm here";
        if ($tag->tagNameExist(strtolower($tagName)) == false) {
           
            $result = $tag->ajoutTag($tagName);
            if ($result) {
                echo "ajout avec succes";
                $idlastInsertTag = $db->lastInsertId();
                if ($idlastInsertTag) {
                    $article->ajouterArticle($titre, $description, $finalPath, $iduser, $idlastInsertTag, $idtheme);
                } else {
                    echo "Erreur : ID du tag invalide.";
                }
            } else {
                echo "err lors de insertion";
            }
        } else {
            $article->ajouterArticle($titre, $description, $finalPath, $iduser, $tagId, $idtheme);
        }
    }
}
