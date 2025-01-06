<?php
header('Content-Type: application/json'); // Déplacez en haut du fichier

require_once 'vehicule.php';
require_once 'db.php';

try {
    $database = new Database();
    $db = $database->connect();

    $vehicule = new vehicule($db);

    if (isset($_GET['namevehicule']) && !empty(trim($_GET['namevehicule']))) {
        $vehiculeName = $_GET['namevehicule'];
    
        $car = $vehicule->getVehiculeByName($vehiculeName); // Recherche par nom
    } else {
        // Si aucune recherche n'est effectuée, renvoyez tous les véhicules
        $car = $vehicule->afficheVehicule(); 
    }
    
    echo json_encode($car);
    
    // } else {
    //     echo json_encode([]); // Renvoie un tableau vide si aucun paramètre n'est défini
    // }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
?>
