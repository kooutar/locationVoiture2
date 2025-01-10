<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
abstract class Utilisateur {
  protected PDO $db;
  protected int $id;
  protected string $nom;
  protected string $email;
  protected string $password;
  protected string $telephone;
  protected String $dateNaissance;
  protected string $gender;
  protected int $role;

  public function __construct(PDO $db) {
      $this->db = $db;
  }

  public function login(string $email, string $password) {
      $stmt = $this->db->prepare("SELECT * FROM utilisateur WHERE Email = :email");
      $stmt->execute(['email' => $email]);
      $user = $stmt->fetch();
      echo var_dump($user);
      if(!$user){
        echo "pas de user avec ce email";
      }else{
        if ( password_verify($password, $user['password'])) {
            if($user['idrole']==1)
            {
               $_SESSION['id_user']=$user['iduser'];
               $_SESSION['idrole']='client';
               $this->id = $user['iduser'];
              
               header('location:../pages/cars.php');
               exit();
            }else{
              $_SESSION['id_user']=$user['iduser'];
              $_SESSION['idrole']='admin';
              header('location:../pages/admin.php');
              exit();
            } 
            
        }
        else{
          echo "mot de pass ou mail incorrect";
        }
      }
    
    
     
  }

  public function register(array $data): bool {
      try {
          $stmt = $this->db->prepare("
              INSERT INTO utilisateur (nom, email,telephone,date_Naissance,gender, password,idrole)
              VALUES (:nom, :email,:telephone,:date_Naissance,:gender ,:password, :role)
          ");
          $idrole='1';
          return $stmt->execute([
              'nom' => $data['nom'],
              'email' => $data['email'],
              'telephone'=>$data['telephone'],
              'date_Naissance'=>$data['date_Naissance'],
              'gender'=>$data['gender'],
              'password' => password_hash($data['password'], PASSWORD_DEFAULT),
              'role' =>  $idrole
          ]);
          $this->nom=$data['nom'];
          $this->email=$data['email'];
          $this->password=password_hash($data['password'], PASSWORD_DEFAULT);
          $this->telephone=$data['telephone'];
          $this->dateNaissance=$data['date_Naissance'];
      } catch (PDOException $e) {
          throw new Exception("Erreur d'inscription : " . $e->getMessage());
      }
  }
  public function logeOut(){
    
    $_SESSION = [];
    session_destroy();
    header('Location: ../pages/login.php');
    exit();
  }
}

