<?php

class command {
    private ContactManager $contactManager;

    public function list() {
        $dbConnect = new DBconnect();
        $contactManager = new ContactManager($dbConnect->getPDO());
        $contacts = $contactManager->findAll();

        // Affichage des contacts sous forme de texte
        echo "Liste des contacts :\n";
        foreach ($contacts as $contact) {
            echo $contact->toString() . "\n";
        }

        // Affichage des contacts sous forme de tableau avec bordures
        echo "Liste des contacts :\n";
        echo "+----+--------------------------------+--------------------------------+----------------+\n";
        echo "| ID | Name                           | Email                          | Phone          |\n";
        echo "+----+--------------------------------+--------------------------------+----------------+\n";

        foreach ($contacts as $contact) {
        echo "| "
            . str_pad($contact->getId(), 2)
            . " | "
            . str_pad($contact->getName(), 30)
            . " | "
            . str_pad($contact->getEmail(), 30)
            . " | "
            . str_pad($contact->getPhone(), 14)
            . " |\n";
        }
        echo "+----+--------------------------------+--------------------------------+----------------+\n";
    }

    public function detail($id){
        $dbConnect = new DBconnect();
        $contactManager = new ContactManager($dbConnect->getPDO());
        $contact = $contactManager->findById($id);
        if (!empty($contact)) {
            echo sprintf(
                "ID: %d, Name: %s, Email: %s, Phone: %s\n",
                    $contact->getId(),
                    $contact->getName(),
                    $contact->getEmail(),
                    $contact->getPhone() ?? 'N/A'
                );
                $found = true;
        } else 
        {
            echo "Aucun contact trouvé avec l'ID : $id\n";       
        }
    }



    public function search() {
        $searchTerm = readline("Entrez le nom à rechercher : ");
        $dbConnect = new DBconnect();
        $contactManager = new ContactManager($dbConnect->getPDO());
        $contacts = $contactManager->findAll();
        $found = false;
        foreach ($contacts as $contact) {
            if (stripos($contact->getName(), $searchTerm) !== false) {
                echo sprintf(
                    "ID: %d, Name: %s, Email: %s, Phone: %s\n",
                    $contact->getId(),
                    $contact->getName(),
                    $contact->getEmail(),
                    $contact->getPhone() ?? 'N/A'
                );
                $found = true;
            }
            if (!$found) {
                echo "Aucun contact trouvé avec le nom : $searchTerm\n";
            }
        }
    }

    public function create() {
        $name = readline("Entrez le nom du contact : ");
        $email = readline("Entrez l'email du contact : ");
        $phone = readline("Entrez le numéro de téléphone du contact (optionnel) : ");

        $dbConnect = new DBconnect();
        $contactManager = new ContactManager($dbConnect->getPDO());
        $contact = new Contact(null, $name, $email, $phone);
        $contactManager->create($contact);

        echo "Contact créé avec succès !\n";
    }
}