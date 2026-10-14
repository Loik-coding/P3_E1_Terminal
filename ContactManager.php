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

    public function create(Contact $contact) {
        $stmt = $this->pdo->prepare('INSERT INTO contact (name, email, phone_number) VALUES (:name, :email, :phone_number)');
        $stmt->execute([
            'name' => $contact->getName(),
            'email' => $contact->getEmail(),
            'phone_number' => $contact->getPhone()
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM contact WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPhone(?string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    public function modify($id, $name, $email, $phone_number): void
    {
        $contact = $this->findById($id);
        if ($contact === null) {
            echo "Contact introuvable.\n";
            return;
        }
        $stmt = $this->pdo->prepare('UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id');
        $stmt->execute(['name' => $name,'email' => $email,'phone_number' => $phone_number,'id' => $id]);

    }
}

