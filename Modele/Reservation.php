<?php

class Reservation{

	public $_erreurs = array();
	public $_confirm;


	public function __construct(){
		if(isset($_POST['reservation_confirmation'],$_POST['confirmation_trajet_id'],$_POST['confirmation_trajet_place'])){
			$this->reserverTrajet($_POST['confirmation_trajet_place']);
		}
		else{
			$this->_erreurs[] = "Il manque des informations pour confirmer le trajet";
		}
	}


	public function reserverTrajet($nbplace){
		$database = UsineBDD::getUsine()->connection();
		$infos_trajet = Trajet::getInformationTrajet($_POST['confirmation_trajet_id'])[0];
		$nbplace_reste = $infos_trajet['nb_place'] - $nbplace;
		if(Utilisateur::getUtilisateurId() == $infos_trajet['id_conducteur']){
			$this->_erreurs[] = "Vous ne pouvez pas réserver sur votre propre trajet";
		}elseif(!Trajet::trajetExiste($infos_trajet['id'])){
			$this->_erreurs[] = "Désolé, ce trajet n'a jamais existé / n'existe plus";
		}elseif(!$this->verifierDate($database,$infos_trajet['id'])){
			$this->_erreurs[] = "Vous ne pouvez pas réserver un trajet similaire à la même date / Vous ne pouvez pas réserver un trajet à la même date et même heure";
		}elseif(Utilisateur::getSolde() < ($nbplace*$infos_trajet['prix']) ){
			$this->_erreurs[] = "Vous n'avez pas assez d'argent pour réserver ce trajet";
		}elseif($nbplace > $infos_trajet['nb_place'] || $nbplace_reste < 0){
			$this->_erreurs[] = "Vous avez réservé un nombre de place trop important";
		}
		else{
			$sql_reservation = "INSERT INTO reservation VALUES('',:id,:t,:nb)";
			$this->updatePlace($infos_trajet['id'],$nbplace);	
			$requete_reservation = $database->prepare($sql_reservation);
			$requete_reservation->execute(array(':id'=>Utilisateur::getUtilisateurId(),':t'=>$infos_trajet['id'],':nb'=>$nbplace));
			$this->_confirm = "Votre réservation a bien été prise en compte";

		}

		

	}

	private function verifierDate($database,$trajet_id){
		$verification = true;
		$sql_verification = "SELECT * FROM Reservation WHERE id_membre=:id ";
		$requete_verification = $database->prepare($sql_verification);
		$requete_verification->execute(array(":id"=>Utilisateur::getUtilisateurId()));
		$resultat_verification = $requete_verification->fetchAll();
		$trajet_compare = Trajet::getInformationTrajet($trajet_id)[0];
		foreach($resultat_verification as $array=>$resultat){
			$trajet = Trajet::getInformationTrajet($resultat['id_trajet'])[0];
			if(($trajet['ville_depart'] == $trajet_compare['ville_depart']) && ($trajet['ville_arrive'] == $trajet_compare['ville_arrive']) && (date('dnY',$trajet['timestamp_trajet']) == date('dnY',$trajet_compare['timestamp_trajet']))){
					$verification = false;
			}elseif(date('dnYHi',$trajet_compare['timestamp_trajet']) ==  date('dnYHi',$trajet['timestamp_trajet'])){
				$verification = false;
			}

		}

	return $verification;

	}

	private function updatePlace($idt,$nbplace){
		$infos_trajet = Trajet::getInformationTrajet($idt)[0];
		$database = UsineBDD::getUsine()->connection();
		$nbplace_reste = $infos_trajet['nb_place'] - $nbplace;
		$sql_update_trajet = "UPDATE trajet SET nb_place = :nbr WHERE id=:id";
		$requete_update = $database->prepare($sql_update_trajet);
		$requete_update->execute(array(':id'=>$infos_trajet['id'],':nbr'=>$nbplace_reste));
	}


	public static function getUtilisateurReservation($id_trajet){
		$database = UsineBDD::getUsine()->connection();
		$sql_reservations = "SELECT id_membre FROM trajet t, reservation r WHERE t.id=r.id_trajet AND t.id=:idt";
		$requete_reservations = $database->prepare($sql_reservations);
		$requete_reservations->execute(array(':idt'=>$id_trajet));
		$resultat = $requete_reservations->fetchAll();

		return $resultat;
	}

	public static function getNombrePlaceReserve($id_trajet,$id_membre){
		$database = UsineBDD::getUsine()->connection();
		$sql_nb = "SELECT r.nb_place FROM Trajet t, Reservation r WHERE t.id = r.id_trajet AND t.id=:idt AND r.id_membre=:idm";
		$requete_nb = $database->prepare($sql_nb);
		$requete_nb->execute(array(':idt'=>$id_trajet,':idm'=>$id_membre));
		$resultat = $requete_nb->fetchAll();

		return $resultat[0]['nb_place'];
	}

	public static function getAllReservation(){
		$database = UsineBDD::getUsine()->connection();
		$sql_reservations = "SELECT * FROM reservation WHERE id_membre=:id";
		$requete_reservations = $database->prepare($sql_reservations);
		$requete_reservations->execute(array(':id'=>Utilisateur::getUtilisateurId()));
		$resultat_reservations= $requete_reservations->fetchAll();

		return $resultat_reservations;
	}


}