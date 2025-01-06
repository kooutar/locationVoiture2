<?php
require_once 'utilisateur.php';
require_once 'db.php';
class Client extends Utilisateur {
    // private string $telephone;
    // private string $adresse;

    public function reserverVehicule(array $data): bool {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO reservations (client_id, vehicule_id, date_debut, date_fin, lieu_prise)
                VALUES (:client_id, :vehicule_id, :date_debut, :date_fin, :lieu_prise)
            ");
            
            return $stmt->execute([
                'client_id' => $this->id,
                'vehicule_id' => $data['vehicule_id'],
                'date_debut' => $data['date_debut'],
                'date_fin' => $data['date_fin'],
                'lieu_prise' => $data['lieu_prise']
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de réservation : " . $e->getMessage());
        }
    }

    public function ajouterAvis(int $vehicule_id, string $commentaire, int $note): bool {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO avis (client_id, vehicule_id, commentaire, note)
                VALUES (:client_id, :vehicule_id, :commentaire, :note)
            ");
            
            return $stmt->execute([
                'client_id' => $this->id,
                'vehicule_id' => $vehicule_id,
                'commentaire' => $commentaire,
                'note' => $note
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur d'ajout d'avis : " . $e->getMessage());
        }
    }
}


// try {
//     $database = new Database();
//     $db = $database->connect();
    
//     $client = new Client($db);
    
//     // Exemple d'inscription
//     $client->register([
//         'nom' => 'John Doe',
//         'email' => 'john@example.com',
//         'password' => 'password123',
//         'role' => 'client'
//     ]);
    
//     // Exemple de connexion
//     if ($client->login('john@example.com', 'password123')) {
//         // Exemple de réservation
//         $client->reserverVehicule([
//             'vehicule_id' => 1,
//             'date_debut' => '2024-01-01',
//             'date_fin' => '2024-01-05',
//             'lieu_prise' => 'Paris'
//         ]);
//     }
// } catch (Exception $e) {
//     echo $e->getMessage();
// }