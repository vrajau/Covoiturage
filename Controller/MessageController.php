<?php
require_once("../Config/autoload.php");
require 'LoginController.php';

if(!isset($_GET['context']) || empty(trim($_GET['context']))){
	header('Location: ../Vue/rechercherTrajet.php');
}

if($_GET['context'] == 'reception'){
	render('reception.php');
}elseif($_GET['context'] == 'envoie'){
	render('envoie.php');
}elseif($_GET['context']=='lire' && isset($_GET['id_message'])){
	render('lire.php');
}else{
	header('Location: ../Vue/rechercherTrajet.php');
}