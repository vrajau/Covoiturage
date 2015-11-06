<?php

class Administration{


	public static function getToutTrajets(){
		$database = UsineBDD::getUsine()->connection();
		$sql_trajets = "SELECT * FROM trajet WHERE validation=0";
		$requete_trajets = $database->prepare($sql_trajets);
		$requete_trajets->execute();
		$resultats = $requete_trajets->fetchAll();

		return $resultats;

	}

	public static function  getToutMembres(){
		$database = UsineBDD::getUsine()->connection();
		$sql_membres = "SELECT * FROM utilisateur WHERE type_compte=2 OR type_compte=3 ";
		$requete_membres = $database->prepare($sql_membres);
		$requete_membres->execute();
		$resultats = $requete_membres->fetchAll();

		return $resultats;

	}	


}