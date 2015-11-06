<?php

require_once("../Config/autoload.php");
require 'LoginController.php';


if(isset($_POST['marque'],$_POST['modele'],$_POST['couleur'],$_POST['mise_en_service'],$_POST['vehicule_confirmation']) && !Utilisateur::peutCreerTrajet()){
	
	render('vehicule_confirmed.php');
}elseif(!Utilisateur::peutCreerTrajet()){
	render('nouveau_vehicule.php');

}else{
	header("Location: ../Vue/rechercherTrajet.php");
}