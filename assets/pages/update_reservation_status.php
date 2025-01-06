<?php
 require_once '../classe/db.php';
 $database=new Database();
 $db= $database->connect(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['iduser'], $_POST['idvehicule'], $_POST['status'])) {
        $iduser = $_POST['iduser'];
        $idvehicule = $_POST['idvehicule'];
        $status = $_POST['status'];
        $stmt = $db->prepare("UPDATE reservation SET status = :status WHERE iduser = :iduser AND idVehicule = :idvehicule");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':iduser', $iduser);
        $stmt->bindParam(':idvehicule', $idvehicule);


        if ($stmt->execute()) {

            header('Location: admin.php?status=success');
            exit;
        } else {
          
            header('Location: admin.php?status=error');
            exit;
        }
    } else {
 
        header('Location: admin.php?status=missing_params');
        exit;
    }
}
?>
