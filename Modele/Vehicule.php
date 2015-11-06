<?php


class Vehicule{
		public $_erreurs = array();
		public $_confirm;
	public function __construct(){
		if(isset($_POST['vehicule_confirmation'])){
			$this->ajouterVehicule();
		}
	}


	public function ajouterVehicule(){
		$database = UsineBDD::getUsine()->connection();

		if(!empty(trim($_POST['marque'])) && !empty(trim($_POST['couleur'])) && !empty(trim($_POST['modele'])) && !empty(trim($_POST['mise_en_service']))){
				$sql_vehicule = "INSERT INTO vehicule VALUES ('',:membre,:mq,:mo,:c,:ms)";
				$requete_vehicule = $database->prepare($sql_vehicule);
				$requete_vehicule->execute(array(':membre'=>Utilisateur::getUtilisateurId(),':mq'=>$_POST['marque'],':mo'=>$_POST['modele'],':c'=>$_POST['couleur'],':ms'=>$_POST['mise_en_service']));
				Utilisateur::rendreConducteur();
				$this->_confirm = "C'est bon ! Vous pouvez désormais ajouter des trajets !";


		}else{
			$this->_erreurs[] = "Il manque des informations pour valider votre véhicule";
		}
	}
}