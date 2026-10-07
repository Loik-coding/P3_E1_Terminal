<?php

class ContactManager {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    //Une fonction pour les trouver tous.
    public function findAll() {
        $findAll = $this->pdo->query('SELECT * FROM contact');
        $contacts = [];

        while ($row = $findAll->fetch(PDO::FETCH_ASSOC)) {
            $contacts[] = new Contact(
            $row['id'],
            $row['name'],
            $row['email'],
            $row['phone_number']
        );
        }
        return $contacts;
    }
}

?>