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

    public function getId() : ?int {
        return $this->id;
    }

    public function getName() : ?string {
        return $this->name;
    }

    public function setName(?string $name) {
        $this->name = $name;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function getPhone() : ?string {
        return $this->phone_number;
    }

    //Une fonction pour les afficher tous en chaine de caractères.
    public function __toString() : string {
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