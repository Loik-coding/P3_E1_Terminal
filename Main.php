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


    if ($line === 'search') {


    }

    if ($line === 'exit') {
        echo "Au revoir !\n";
        break;
    }
}