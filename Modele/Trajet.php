<?php

class Trajet{

	public $erreurs = array();
	public $confirmation;  

	public function __construct(){
		if(isset($_POST['trajet_confirmation'])){

			$this->creerTrajet();
		}
	}


	public function creerTrajet(){
		$database = UsineBDD::getUsine()->connection();
		
		if(!empty(trim($_POST['ville_a'])) && !empty(trim($_POST['ville_d'])) && !empty(trim($_POST['prix']))){

		$prix = intval($_POST['prix'])	;
		$tempsActuel = time();
		$ville_d = explode(",",$_POST['ville_d'])[0];
		$ville_a = explode(",",$_POST['ville_a'])[0];
		$timestamp_trajet = mktime($_POST['heure'],$_POST['minute'],0,$_POST['mois'],$_POST['jour'],$_POST['annee']);
		
		if(!$timestamp_trajet || (time() > $timestamp_trajet)){
			$this->erreurs[] = "La date que vous avez renseigné n'est pas valide";
		}elseif(Utilisateur::comparerTmp($timestamp_trajet)){
			$this->erreurs[] = "Vous avez déjà proposé un trajet pour ce jour ci";
	}else{
			if($ville_d == $ville_a ){
				$this->erreurs[] = "Vous ne pouvez pas effectuer un trajet entre 2 même villes";
			}else if ($prix < 0 || $prix > 2000 ){
				$this->erreurs[] = "Le prix des trajets doit être compris entre 0 et 2000 €";
			}
			else{
				$sql_nouveau_trajet = 'INSERT INTO trajet VALUES("",:id,:vd,:va,:tmp,:prx,:nb_place,"")';
				$requete_nouveau_trajet = $database->prepare($sql_nouveau_trajet);
				$requete_nouveau_trajet->execute(array(":id"=>Utilisateur::getUtilisateurId(),":vd"=>strtolower($ville_d),":va"=>strtolower($ville_a),":tmp"=>$timestamp_trajet,":prx"=>$_POST['prix'],":nb_place"=>$_POST['place']));
				$this->confirmation = "Votre trajet a été validé";

			}
		}


	}else{
		$this->erreurs[] = "Vous n'avez pas renseigné un des champs";
	}
	}

	public function validationTrajet($id_trajet){
		$database = UsineBDD::getUsine()->connection();
		$info_trajet = self::getInformationTrajet($id_trajet)[0];
		if(Utilisateur::getUtilisateurId() == $info_trajet['id_conducteur'] && $info_trajet['validation'] == 0 ){
			$passagers = Reservation::getUtilisateurReservation($id_trajet);
			$prix_g = 0;

			foreach($passagers as $array=>$passager){
				
				$prix = $info_trajet['prix'] * Reservation::getNombrePlaceReserve($info_trajet['id'],$passager['id_membre']);	
				$prix_g += $prix;
				Utilisateur::retirerSolde($prix,$passager['id_membre']);
				Utilisateur::ajouterSolde($prix,$info_trajet['id_conducteur']);

			}
				$sql_update_trajet = "UPDATE trajet SET validation = 1 WHERE id=:idt";
				$requete_update = $database->prepare($sql_update_trajet);
				$requete_update->execute(array(':idt'=>$id_trajet));
				Utilisateur::ajoutTrajetV();
				$this->confirmation = "Le trajet a bien été validé! ".$prix_g."€ ont été ajouté sur votre compte";



		}
	}

	public function annulationTrajet($id_trajet){
		$database = UsineBDD::getUsine()->connection();
		if(Trajet::trajetExiste($id_trajet)){
			$info_trajet = self::getInformationTrajet($id_trajet)[0];
		$prix_g = 0;
		if(Utilisateur::getUtilisateurId() == $info_trajet['id_conducteur'] && $info_trajet['validation'] == 0 ){
				$passagers = Reservation::getUtilisateurReservation($id_trajet);
				$prix_g += 10;
				foreach($passagers as $array=>$passager){
				Utilisateur::retirerSolde(10,$info_trajet['id_conducteur']);
				Utilisateur::ajouterSolde(10,$passager['id_membre']);
			}
				Messagerie::envoyerMessageA($info_trajet['id']);
				$sql_update_trajet = "DELETE FROM trajet  WHERE id=:idt";
				$requete_update = $database->prepare($sql_update_trajet);
				$requete_update->execute(array(':idt'=>$id_trajet));
				Utilisateur::ajoutTrajetA();
				$this->confirmation = "Le trajet a bien été annulé! ".$prix_g."€ ont été retiré de votre compte";

		}
		}
		
	}

	public static function isTrajetValide($id_t){
		$database = UsineBDD::getUsine()->connection();
		$sql = "SELECT validation FROM trajet WHERE id=:idt";
		$requete = $database->prepare($sql);
		$requete->execute(array(':idt'=>$id_t));
		$res = $requete->fetchAll();
		
		if($res[0]['validation'] == 1){
			return true;
		}else{
			return false;
		}

	}


public static function afficherListeTrajet($ville_d,$ville_a=""){
		$database = UsineBDD::getUsine()->connection();
		$liste_resultat=array();

		$ville_a = strtolower($ville_a);
		$ville_d = strtolower($ville_d);
		if(empty(trim($ville_a))){
			$sql_list_trajet = "SELECT * FROM trajet WHERE ville_depart=:vd  AND validation=0   ORDER BY 7 DESC";
			$requete_liste_trajet =  $database->prepare($sql_list_trajet);
			$requete_liste_trajet->execute(array(":vd"=>$ville_d));
		}else{
			$sql_list_trajet = "SELECT * FROM trajet WHERE ville_depart=:vd AND ville_arrive=:va AND validation=0   ORDER BY 7 DESC";
			$requete_liste_trajet =  $database->prepare($sql_list_trajet);
			$requete_liste_trajet->execute(array(":vd"=>$ville_d,":va"=>$ville_a));
		}
		
		
	
		$resultat_trajets = $requete_liste_trajet->fetchAll();

		

		return $resultat_trajets;

	}

public static function getInformationTrajet($id_trajet){
	$database = UsineBDD::getUsine()->connection();
	$sql_trajet = "SELECT * FROM Trajet WHERE id=:id";
	$requete_trajet = $database->prepare($sql_trajet);
	$requete_trajet->execute(array(':id'=>$id_trajet));
	$resultat = $requete_trajet->fetchAll();

	return $resultat;
}

public static function getAllTrajetConducteur(){
	$database = UsineBDD::getUsine()->connection();
	$sql_trajets = "SELECT id FROM trajet WHERE id_conducteur=:idc";
	$requete_trajets = $database->prepare($sql_trajets);
	$requete_trajets->execute(array(':idc'=>Utilisateur::getUtilisateurId()));
	$trajets = $requete_trajets->fetchAll();

	return $trajets;
}


public static function getTrajetConducteurId($id_trajet){
	$database = UsineBDD::getUsine()->connection();
	$sql_id_utilisateur = "SELECT u.id FROM UTILISATEUR u, Trajet t WHERE t.id=:id_t AND t.id_conducteur=u.id";
	$requete_id_utilisateur = $database->prepare($sql_id_utilisateur);
	$requete_id_utilisateur->execute(array(':id_t'=>$id_trajet));
	$id_utilisateur = $requete_id_utilisateur->fetchAll();

	if(count($id_utilisateur) != 0){
		return $id_utilisateur[0][0];	
	} 
	



}


public static function trajetExiste($id_trajet){
	$database = UsineBDD::getUsine()->connection();
	$sql_existe = "SELECT id FROM trajet WHERE id=:id";
	$requete_trajet_existe = $database->prepare($sql_existe);
	$requete_trajet_existe->execute(array(":id"=>$id_trajet));
	$resultat = $requete_trajet_existe->fetchAll();

	if(count($resultat) > 0){
		return true;
	}else{
		return false;
	}

}


	

}