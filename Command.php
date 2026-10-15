<?php

class command {
    
    private ContactManager $contactManager;
    
    public function __construct() {
        $this->contactManager = new ContactManager();
    }

    public function list() {
       
        $contacts = $this->contactManager->findAll();

        // Affichage des contacts sous forme de texte
        //echo "Liste des contacts :\n";
        //foreach ($contacts as $contact) {
        //    echo $contact . "\n";
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

    //Fonction pour afficher les détails d'un contact spécifique
    public function detail($id){
        $contact = $this->contactManager->findById($id);
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

    //Fonction pour rechercher un contact par nom
    public function search($searchTerm) {
        $contacts = $this->contactManager->findAll();
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

    //Fonction pour rechercher un contact par nom avec paramètres
    public function searchprmtrs($matches) {
        $contacts = $this->contactManager->findAll();
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
            echo "Aucun contact trouvé avec le nom : $matches\n";
        }
        
    }

    //Fonction pour créer un nouveau contact avec saisie utilisateur
    public function create() {
        $name = readline("Entrez le nom du contact : ");
        $email = readline("Entrez l'email du contact : ");
        $phone_number = readline("Entrez le numéro de téléphone du contact : ");

        $contact = new Contact(null, $name, $email, $phone_number);
        $this->contactManager->create($contact);
        echo "Contact créé avec succès !\n";
    }

    //Fonction pour créer un nouveau contact avec paramètres
    public function createprmtrs($name, $email, $phone) {

        $contact = new Contact(null, $name, $email, $phone);
        $this->contactManager->create($contact);

        echo "Contact créé avec succès !\n";
    }

    //Fonction pour supprimer un contact spécifique par son id
    public function delete($id) {
        $contact = $this->contactManager->findById($id);

        if (!empty($contact)) {
            $validate = readline("Êtes-vous sûr de vouloir supprimer le contact : " . $contact->getName() . " ? (yes/no) : ");
            if ($validate === 'yes') {
                $this->contactManager->delete($id);
                echo "Contact supprimé avec succès !\n";
            }
        } else {
            echo "Aucun contact trouvé avec l'ID : $id\n";
        }
    }

    //Fonction pour modifier un contact spécifique par son id de manière guidée
    public function modify($id) {
        $contact = $this->contactManager->findById($id);
        echo "Modification du contact : " . $contact->getName() . "\n";
        $modifyName = readline("Souhaitez-vous modifier le nom du contact : " . $contact->getName() . " ? (yes/no) : ");
        if ($modifyName === 'yes') {
            $name = readline("Entrez le nouveau nom du contact : ");
        }
        else {
            $name = $contact->getName();
        }

        $modifyEmail = readline("Souhaitez-vous modifier l'email (" . $contact->getEmail() . ") ? (yes/no) : ");
        if ($modifyEmail === 'yes') {
            $email = readline("Entrez le nouvel email du contact : ");
        }
        else {
            $email = $contact->getEmail();
        }

        $modifyPhone = readline("Souhaitez-vous modifier le numéro de téléphone (" . $contact->getPhone() . ") ? (yes/no) : ");
        if ($modifyPhone === 'yes') {
            $phone_number = readline("Entrez le nouveau numéro de téléphone du contact : ");
        }
        else   
        {
            $phone_number = $contact->getPhone();
        }
        $contact = new Contact($id, $name, $email, $phone_number);
        $this->contactManager->modify($contact);
        if ($modifyEmail === 'no' && $modifyName === 'no' && $modifyPhone === 'no') {
            echo "Aucune modification effectuée pour le contact : " . $contact->getName() . "\n";
        } else {
            echo "Contact mis à jour avec succès : " . $name . " - " . $email . " - " . $phone_number . "\n";
        }
    }


    //affiche la liste des commandes disponibles
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
        echo "modify <id> - Modifie un contact spécifique\n";
        echo "help - Affiche cette aide\n";
        echo "exit - Quitte l'application\n";
    }
}