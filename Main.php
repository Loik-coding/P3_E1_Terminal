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

    if ($line === 'list') { 
        $command->list();
    }
    if (preg_match('/^detail\s(\d+)$/', $line, $id)) {
        $command->detail($id[1]);
    }

    if (preg_match('/^create\s+(.+);(.+);(.+)$/', $line, $matches)) {
        $name = $matches[1];
        $email = $matches[2];
        $phone_number = $matches[3];
        $command->create($name, $email, $phone_number);
    }


    if (preg_match('/^search\s+(.+)$/', $line, $matches)) {
        $command->search($matches[1]);
    }

    if (preg_match('/^modify\s+(\d+);(.+);(.+);(.+)$/', $line, $matches)) {
        $id = $matches[1];
        $name = $matches[2];
        $email = $matches[3];
        $phone_number = $matches[4];
        $command->modify($id, $name, $email, $phone_number);
    }

    if (preg_match('/^delete\s(\d+)$/', $line, $id)) {
        $command->delete($id[1]);
    }

    if ($line === 'help') {
        $command->help();
    }

    if ($line === 'exit') {
        echo "Au revoir !\n";
        break;
    }
}