<?php

class DBconnect {
    private $host = 'localhost';
    private $port = 3306;
    private $dbname = 'projet3';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8', $this->host, $this->dbname, $this->port),
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $exception) {
            die('Erreur : ' . $exception->getMessage());
        }
    }

    public function getPDO() {
        return $this->pdo;
    }
}

?>