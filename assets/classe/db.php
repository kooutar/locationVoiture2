<?php
// db.php
interface DatabaseConnectionInterface {
    public function connect(): PDO;
}

class Database implements DatabaseConnectionInterface {
    private string $host = "localhost";
    private string $dbname = "Drive";
    private string $username = "root";
    private string $password = "";
    private static Database $instance;
    private $connection;


    public function connect(): PDO {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            return new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
}


