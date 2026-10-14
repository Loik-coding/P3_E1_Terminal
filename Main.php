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
    if (preg_match('/^modify\s+(.+)$/', $line, $id)) {
        $command->modify($id[1]);
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
    else {
        echo "Commande inconnue. Tapez 'help' pour la liste des commandes disponibles.\n";
    }

}