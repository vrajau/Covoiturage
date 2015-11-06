<?php

class Note{

	public $_erreurs = array();
	public $_confirm;
	public function __construct(){
		if(	isset($_POST['note'],$_POST['confirmation_note'],$_GET['id_u'],$_GET['id_trajet'])){
			$this->noteUtilisateur($_GET['id_trajet'],$_GET['id_u']);

		}elseif(isset($_POST['note'],$_POST['confirmation_note'],$_GET['id_trajet'])){
			
			$this->noterConducteur($_GET['id_trajet']);
		}
	}




	public function noterConducteur($trajet){
		//Recupération des infos trajets
		$database = UsineBDD::getUsine()->connection();
		$info_t = Trajet::getInformationTrajet($trajet)[0];
		$passager = Utilisateur::getUtilisateurId();
		$note = intval($_POST['note']);
		$isPassagerTrajet = false;

		//On vérifie que le passager fait partie du trajet
		foreach(Reservation::getUtilisateurReservation($trajet) as $array=>$reservation){
			if($reservation['id_membre'] == $passager){
				$isPassagerTrajet = true;
			}

		}

		if($info_t['id_conducteur'] == $passager){
			$_erreurs[] = "Vous ne pouvez pas noter votre propre trajet";
		}else if(!Trajet::isTrajetValide($info_t['id'])){
			$_erreurs[] = "Vous ne pouvez pas noter un trajet non validé";
		}else if(self::isNoteExiste($info_t['id'])){
			$_erreurs[] = "Vous avez dejà noté ce trajet";
		}else if(!$isPassagerTrajet){
			$_erreurs[] = "Vous devez être un passager de ce trajet pour pouvoir le noté";
		}else if($note <= 0 || $note > 5){
			$_erreurs[] = "Votre note doit être compris en 1 et 5";
		}else{

			$sql = "INSERT INTO note VALUES('',:idm,:idn,:idt,:n)";
			$requete = $database->prepare($sql);
			$requete->execute(array(':idm'=>$passager,':idn'=>$info_t['id_conducteur'],':idt'=>$info_t['id'],':n'=>$note));
			$_confirm = "Vous avez bien noté le conducteur";
			}

	}



	public  function noteUtilisateur($trajet,$utilisateur){
		//Recupération des infos trajets
		$database = UsineBDD::getUsine()->connection();
		$info_t = Trajet::getInformationTrajet($trajet)[0];
		$conducteur = Utilisateur::getUtilisateurId();
		$note = intval($_POST['note']);
		$isPassagerTrajet = false;

		//On vérifie que le passager fait partie du trajet

		foreach(Reservation::getUtilisateurReservation($trajet) as $array=>$reservation){
			if($reservation['id_membre'] == $utilisateur){
				$isPassagerTrajet = true;
			}

		}

		if($utilisateur == $conducteur){
			
			$this->_erreurs[] = "Vous ne pouvez pas noter votre propre trajet";
		}else if(!Trajet::isTrajetValide($info_t['id'])){
			
			$this->_erreurs[]  = "Vous ne pouvez pas noter un trajet non validé";
		}else if(self::isNoteExisteU($info_t['id'],$utilisateur)){
		
			$this->_erreurs[] = "Vous avez dejà noté cette personne sur ce trajet";
		}else if(!$isPassagerTrajet){
			
			$this->_erreurs[]  = "Le passager ne fait pas partie de ce trajet";
		}else if($note <= 0 || $note > 5){
			
			$this->_erreurs[]  = "Votre note doit être compris en 1 et 5";
		}else{

			$sql = "INSERT INTO note VALUES('',:idm,:idn,:idt,:n)";
			$requete = $database->prepare($sql);
			$requete->execute(array(':idm'=>$info_t['id_conducteur'],':idn'=>$utilisateur,':idt'=>$info_t['id'],':n'=>$note));
			$_confirm = "Vous avez bien noté le passager";
			}	

	}
	

public static function isNoteExiste($id_trajet){
	$database = UsineBDD::getUsine()->connection();
	$info_t = Trajet::getInformationTrajet($id_trajet)[0];
	$sql = "SELECT id FROM note WHERE id_trajet=:idt AND id_membre=:idm";
	$requete = $database->prepare($sql);
	$requete->execute(array(':idt'=>$info_t['id'],':idm'=>Utilisateur::getUtilisateurId()));
	$res = $requete->fetchAll();

	if(count($res) != 0){
		return true;
	}else{
		return false;
	}

}

public static function isNoteExisteU($id_trajet,$utilisateur){
	$database = UsineBDD::getUsine()->connection();
	$info_t = Trajet::getInformationTrajet($id_trajet)[0];
	$sql = "SELECT id FROM note WHERE id_trajet=:idt AND id_membre=:idm AND id_membre_note=:idn";
	$requete = $database->prepare($sql);
	$requete->execute(array(':idt'=>$info_t['id'],':idm'=>Utilisateur::getUtilisateurId(),':idn'=>$utilisateur));
	$res = $requete->fetchAll();

	if(count($res) != 0){
		return true;
	}else{
		return false;
	}

}

public static function calculerMoyenne($id_membre){
	$database = UsineBDD::getUsine()->connection();
	$sql = "SELECT note FROM note WHERE id_membre_note=:idn";
	$req = $database->prepare($sql);
	$req->execute(array(':idn'=>$id_membre));
	$res = $req->fetchAll();

	if(count($res)==0){
		return false;
	}else{
		$nombreNote = 0;
		$total = 0;
		foreach($res as $array=>$note){
			$nombreNote++;
			$total += $note['note'];
		}
		$moyenne = bcdiv($total,$nombreNote,3);
		return number_format($moyenne,2);
	}


	
}

}