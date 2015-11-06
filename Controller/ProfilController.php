
<?php
require_once("../Config/autoload.php");
require 'LoginController.php';

if(!isset($_GET['context']) || empty(trim($_GET['context']))){
	header('Location: ../Vue/rechercherTrajet.php');
}

if($_GET['context'] == 'trajets' && isset($_GET['id_trajet']) && Utilisateur::getUtilisateurId() == Trajet::getTrajetConducteurId($_GET['id_trajet'])){
	render('mytrajet.php');
}elseif($_GET['context'] == 'trajets' ||($_GET['context'] == 'trajets' && isset($_GET['id_u']))){
	render('mytrajet.php');
}elseif($_GET['context']=='reservations' ||($_GET['context']=='reservations' && isset($_GET['id_t']))){
	render('myreservation.php');
}elseif($_GET['context']=='profil'){
	render('profil.php');
}
else{
	header('Location: ../Vue/rechercherTrajet.php');
}