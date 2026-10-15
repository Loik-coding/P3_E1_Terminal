<?php

class ContactManager {
    private $pdo;

    public function __construct() {
        $dbConnect = new DBconnect();
        $this->pdo = $dbConnect->getPDO();
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

    //Fonction pour trouver un contact par son ID.
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

    //Fonction pour créer un nouveau contact.
    public function create(Contact $contact) {
        $stmt = $this->pdo->prepare('INSERT INTO contact (name, email, phone_number) VALUES (:name, :email, :phone_number)');
        $stmt->execute([
            'name' => $contact->getName(),
            'email' => $contact->getEmail(),
            'phone_number' => $contact->getPhone()
        ]);
    }

    //Fonction pour supprimer un contact existant.
    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM contact WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }


    //Fonction pour modifier un contact existant.
    public function modify($modifiedContact): void
    {
        $contact = $this->findById($modifiedContact->getId());
        if ($contact === null) {
            echo "Contact introuvable.\n";
            return;
        }
        $stmt = $this->pdo->prepare('UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id');
        $stmt->execute(['name' => $modifiedContact->getName(),'email' => $modifiedContact->getEmail(),'phone_number' => $modifiedContact->getPhone(),'id' => $modifiedContact->getId()]);

    }
}

