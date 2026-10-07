<?php

class Contact {
    private ?int $id;
    private ?string $name;
    private string $email;
    private ?string $phone_number;

    public function __construct(?int $id, ?string $name, string $email, ?string $phone_number = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone_number;
    }

    //Une fonction pour les afficher tous.
    public function toString() {
        return sprintf(
            "ID: %d, Name: %s, Email: %s, Phone: %s",
            $this->id,
            $this->name,
            $this->email,
            $this->phone_number ?? 'N/A'
        );
    }
}

?>