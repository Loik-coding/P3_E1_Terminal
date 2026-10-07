<?php

require_once 'Command.php';
require_once 'Contact.php';
require_once 'ContactManager.php';
require_once 'DBconnect.php';

$dbConnect = new DBconnect();
$contactManager = new ContactManager($dbConnect->getPDO());
$command = new Command($contactManager);

while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";

    // List command
    if ($line === 'list') { 
        $command->list();
    }

    // Detail command with parameter
    if (preg_match('/^detail\s(\d+)$/', $line, $id)) {
        $command->detail($id[1]);
    }

    // Create command with user input
    if ($line === 'create') {
        $command->create();
    }

    // Create command with parameters
    if (preg_match('/^create\s+(.+);(.+);(.+)$/', $line, $matches)) {
        $name = $matches[1];
        $email = $matches[2];
        $phone_number = $matches[3];
        $command->createprmtrs($name, $email, $phone_number);
    }

    // Search command with user input
    if ($line === 'search') {
        $searchTerm = readline("Entrez le nom à rechercher : ");
        $command->search($searchTerm);
    }

    // Search command with parameter
    if (preg_match('/^search\s+(.+)$/', $line, $matches)) {
        $command->searchprmtrs($matches[1]);
    }

    // Modify command with user input
    if ($line === 'modify') {
        $id = readline("Entrez l'ID du contact à modifier : ");
        $choix = readline("Souhaitez-vous modifier le nom, l'email ou le numéro de téléphone ? (name/email/phone) : ");
        if ($choix === 'name') {
            $newValue = readline("Entrez le nouveau nom : ");
            $command->modify($id, $newValue, null, null);
        } elseif ($choix === 'email') {
            $newValue = readline("Entrez le nouvel email : ");
            $command->modify($id, null, $newValue, null);
        } elseif ($choix === 'phone') {
            $newValue = readline("Entrez le nouveau numéro de téléphone : ");
            $command->modify($id, null, null, $newValue);
        } else {
            echo "Choix invalide. Veuillez choisir 'name', 'email' ou 'phone'.\n";
        }
    }

    // Modify command with all parameters
    if (preg_match('/^modify\s+(\d+);(.+);(.+);(.+)$/', $line, $matches)) {
        $id = $matches[1];
        $name = $matches[2];
        $email = $matches[3];
        $phone_number = $matches[4];
        $command->modifyFull($id, $name, $email, $phone_number);
    }    

    //Delete command
    if (preg_match('/^delete\s(\d+)$/', $line, $id)) {
        $command->delete($id[1]);
    }

    //Help command
    if ($line === 'help') {
        $command->help();
    }

    //Exit command
    if ($line === 'exit') {
        echo "Au revoir !\n";
        break;
    }
}