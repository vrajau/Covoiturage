<?php
	
	require 'LoginController.php';

	

if(Utilisateur::peutCreerTrajet()){

		
		render('nouveau_trajet.php');
	
}else{
	header("Location: ../Vue/rechercherTrajet.php");
}
?>