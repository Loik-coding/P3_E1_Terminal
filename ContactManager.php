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

    public function findById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM contact WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Contact(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['phone_number']
            );
        }
        return null;
    }
}

?>