<?php 
session_start();
require_once '../classe/commentaire.php';
require_once '../classe/db.php';
try {

    $database = new Database();
    $db = $database->connect();
   
} catch (PDOException $e) {
    $e->getMessage();
}
 if($_SERVER['REQUEST_METHOD']=='POST'){
    $idArticle=intval($_POST['article_id']);
    $commentaire=$_POST['comment'];
    $iduser=$_SESSION['id_user'];
    $comment=new commentaire($db);
    $comment->ajoutCommentaire($commentaire,$iduser, $idArticle);
    header('location: ../pages/articles.php');
    exit();

 }

?>