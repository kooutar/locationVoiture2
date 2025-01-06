<?php
require_once '../classe/db.php';
require_once '../classe/vehicule.php';

try {
    $database = new Database();
    $db = $database->connect();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        for ($i = 0; $i < count($_POST['nom']); $i++) {
            $vehicule = new Vehicule($db);
            $finalPath = null;
            if (isset($_FILES['image_path']['name'][$i]) && !empty($_FILES['image_path']['name'][$i])) {
                $dir = '../uplods/';
                $path = basename($_FILES['image_path']['name'][$i]);
                $finalPath = $dir . uniqid() . "_" . $path;
                $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif', 'svg'];
                $extension = pathinfo($finalPath, PATHINFO_EXTENSION);
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    if (move_uploaded_file($_FILES['image_path']['tmp_name'][$i], $finalPath)) {
                        
                    } else {
                       
                        echo "Erreur lors du téléchargement de l'image pour le véhicule : " . $_POST['nom'][$i];
                        continue;
                    }
                } else {
                    echo "Extension non autorisée pour le fichier : " . $_FILES['image_path']['name'][$i];
                    continue;
                }
            }

          
           $bool= $vehicule->ajouterVehicule(
                $_POST['nom'][$i],
                $_POST['prix'][$i],
                $finalPath,
                $_POST['lieu'][$i],
                $_POST['selectCategorie'][$i]
            );
           
        }
    }

    
    header("Location: ../pages/admin.php");
    exit();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

