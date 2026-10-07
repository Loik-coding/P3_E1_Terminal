<?php

class command {
    private ContactManager $contactManager;

    public function list() {
        $dbConnect = new DBconnect();
        $contactManager = new ContactManager($dbConnect->getPDO());
        $contacts = $contactManager->findAll();

        // Affichage des contacts sous forme de texte
        //echo "Liste des contacts :\n";
        //foreach ($contacts as $contact) {
        //    echo $contact->toString() . "\n";
        //}

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

    public function search($searchTerm) {
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
        }
        if (!$found) {
            echo "Aucun contact trouvé avec le nom : $searchTerm\n";
        }
        
    }

    public function searchprmtrs($matches) {
        $dbConnect = new DBconnect();
        $contactManager = new ContactManager($dbConnect->getPDO());
        $contacts = $contactManager->findAll();
        $found = false;
        foreach ($contacts as $contact) {
            if (stripos($contact->getName(), $matches) !== false) {
                echo sprintf(
                    "ID: %d, Name: %s, Email: %s, Phone: %s\n",
                    $contact->getId(),
                    $contact->getName(),
                    $contact->getEmail(),
                    $contact->getPhone() ?? 'N/A'
                );
                $found = true;
            }
        }
        if (!$found) {
            echo "Aucun contact trouvé avec le nom : $searchTerm\n";
        }
        
    }

    public function create() {
        $dbConnect = new DBconnect();
        $contactManager = new ContactManager($dbConnect->getPDO());

        $name = readline("Entrez le nom du contact : ");
        $email = readline("Entrez l'email du contact : ");
        $phone_number = readline("Entrez le numéro de téléphone du contact : ");

        $contact = new Contact(null, $name, $email, $phone_number);
        $contactManager->create($contact);
        echo "Contact créé avec succès !\n";
    }

    public function createprmtrs($name, $email, $phone) {

        $dbConnect = new DBconnect();
        $contactManager = new ContactManager($dbConnect->getPDO());
        $contact = new Contact(null, $name, $email, $phone);
        $contactManager->create($contact);

        echo "Contact créé avec succès !\n";
    }

    public function delete($id) {
        $dbConnect = new DBconnect();
        $contactManager = new ContactManager($dbConnect->getPDO());
        $contact = $contactManager->findById($id);

        if (!empty($contact)) {
            $validate = readline("Êtes-vous sûr de vouloir supprimer le contact : " . $contact->getName() . " ? (yes/no) : ");
            if ($validate === 'yes') {
                $stmt = $dbConnect->getPDO()->prepare('DELETE FROM contact WHERE id = :id');
                $stmt->execute(['id' => $id]);
                echo "Contact supprimé avec succès !\n";
            }
        } else {
            echo "Aucun contact trouvé avec l'ID : $id\n";
        }
    }

    public function modify($id, $name, $email, $phone_number) {
        $dbConnect = new DBconnect();
        $contactManager = new ContactManager($dbConnect->getPDO());
        $contact = $contactManager->findById($id);
        if ($contact(name) !== null) {
            $contact->setName($name);
            $stmt = $dbConnect->getPDO()->prepare('UPDATE contact SET name = :name, WHERE id = :id');
            $stmt->execute([
                'name' => $contact->getName(),
                'email' => $email,
                'phone_number' => $phone_number,
                'id' => $id
            ]);
        }
        if ($contact(email) !== null) {
            $contact->setEmail($email);
        }
        if ($contact(phone_number) !== null) {
            $contact->setPhone($phone_number);
        }
    }

    public function modifyFull($id, $name, $email, $phone_number) {
        $dbConnect = new DBconnect(); 
        $contactManager = new ContactManager($dbConnect->getPDO());
        $contact = $contactManager->findById($id);   
        if (!empty($contact)) {
            $contact->setName($name);
            $stmt = $dbConnect->getPDO()->prepare('UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id');
            $stmt->execute([
                'name' => $contact->getName(),
                'email' => $email,
                'phone_number' => $phone_number,
                'id' => $id
            ]);
            echo "Contact modifié avec succès !\n";
        } else {
            echo "Aucun contact trouvé avec l'ID : $id\n";
        }
    }

    public function help() {
        echo "\n";
        echo "Commandes disponibles :\n";
        echo "\n";
        echo "list - Affiche la liste de tous les contacts\n";
        echo "detail <id> - Affiche les détails d'un contact spécifique\n";
        echo "create - Crée un nouveau contact en demandant les informations à l'utilisateur\n";
        echo "create <name>;<email>;<phone_number> - Crée un nouveau contact\n";
        echo "search - Recherche un contact par nom en demandant le nom à l'utilisateur\n";
        echo "search <term> - Recherche un contact par nom\n";
        echo "delete <id> - Supprime un contact spécifique\n";
        echo "modify <id>;<name>;<email>;<phone_number> - Modifie un contact spécifique\n";
        echo "help - Affiche cette aide\n";
        echo "exit - Quitte l'application\n";
    }
}