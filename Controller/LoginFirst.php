<?php

require_once("../Config/autoload.php");
$login = new Login();



if (!$login->isConnecte()) {
    header("Location: ../Vue/connexion.php");

}elseif(Utilisateur::isAdmin()){
	header("Location: ../Vue/administration.php");
} 
else{
	header("Location: ../Vue/rechercherTrajet.php");
}