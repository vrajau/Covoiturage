<?php

require_once("../Config/autoload.php");
$login = new Login();



if (!$login->isConnecte()) {
    header("Location: ../Vue/connexion.php");

} 