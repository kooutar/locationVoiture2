<?php
// add_favorite.php
session_start();
require_once '../classe/db.php';
require_once '../classe/favorie.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $article_id = $data['article_id'];
    $user_id = $_SESSION['id_user'];

    $database = new Database();
    $db = $database->connect();
    $favorie= new favorie($db);
$favorie->ajoutFavorie($article_id,$user_id);
    if($favorie->estFavori($article_id,$user_id)){
        echo json_encode(['success' => true, 'isFavorite' => false]);
    }else{
        echo json_encode(['success' => true, 'isFavorite' => true]);
        
    }
    
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
