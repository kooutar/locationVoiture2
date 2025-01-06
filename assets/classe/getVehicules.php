<?php

require_once 'vehicule.php';
require_once 'db.php';

try {
    $database = new Database();
    $db = $database->connect();

    $vehicule = new vehicule($db);
    if (isset($_GET['idcategorie'])) {
        $idcategorie = $_GET['idcategorie'];

        if ($idcategorie == "all") {
            $vehicules = $vehicule->afficheVehicule();
            echo json_encode($vehicules);
            exit;
        } else {
            $vehicules = $vehicule->getVehiculeByCategorie($idcategorie);
            echo json_encode($vehicules);
            exit;
        }
    } else {
        echo json_encode([]); 
        exit;
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

header('Content-Type: application/json');
?>
