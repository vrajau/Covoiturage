<?php
	require '../Controller/LoginController.php';




	if(isset($_GET['id_trajet_r']) && !empty(trim($_GET['id_trajet_r'])) && Trajet::trajetExiste($_GET['id_trajet_r'])){
		render('trajet.php');
	}elseif(isset($_POST['depart']) && $_POST['depart'] != -1 && !empty(trim($_POST['arrive']))){
		render('reservation_trajet_liste.php');

	}elseif(isset($_POST['id_trajet'],$_POST['nb_place_reserver']) && !empty(trim($_POST['id_trajet'])) && !empty(trim($_POST['nb_place_reserver']))){
		render('confirmation_trajet.php');

	}elseif(isset($_POST['reservation_confirmation'],$_POST['confirmation_trajet_id'],$_POST['confirmation_trajet_place'])){
		render('reservation_confirmed.php');
	}else{
		header("Location: ../Vue/rechercherTrajet.php");
	}