<?php
header('Content-Type: application/json');
require_once '../classe/tag.php';
require_once '../classe/db.php';

try {
    
    $database = new Database();
    $db = $database->connect();
    $tag = new tag($db);
    
    $tags = $tag->getAlltag();
    if ($tags) {
        echo json_encode($tags);
    } else {
        echo json_encode(['error' => 'Aucun tag trouvé']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion à la base de données', 'message' => $e->getMessage()]);
}
?>