<?php


class Messagerie{

	public $_erreurs = array();
	public $_confirmation;
	public function __construct(){
		if(isset($_POST['envoie_message'])){
			$this->envoyerMessage(); 
		}
	}


	public function envoyerMessage(){
		$destinataire = $_GET['id_membre'];
		$contenu = $_POST['message'];
		if(!Utilisateur::membreExiste($destinataire)){
			$this->_erreurs[] = "Ce membre n'existe pas";
		}elseif (empty(trim($contenu))) {
			$this->_erreurs[] = "Le message est vide";
		}else{
			$contenu = htmlspecialchars($contenu);
			$database = UsineBDD::getUsine()->connection();
			$sql_message = "INSERT INTO messagerie VALUES('',:ide,:idd,:c,:t,'')";
			$requete = $database->prepare($sql_message);
			$requete->execute(array(':ide'=>Utilisateur::getUtilisateurId(),':idd'=>$destinataire,':c'=>$contenu,':t'=>time()));
			$this->_confirmation = "Le message a bien été envoyé";
		}
	}

	public static function getMessage($id){
		$database = UsineBDD::getUsine()->connection();
		if(self::messageExiste($id)){
			$sql = "SELECT * FROM messagerie WHERE id=:id";
			$requete=$database->prepare($sql);
			$requete->execute(array(':id'=>$id));
			$res = $requete->fetchAll();
			if($res[0]['id_destinataire'] != Utilisateur::getUtilisateurId()){
				return false;
			}else{
				return $res;
			}

		}else{
			return false;
		}
	}

	public static function messageExiste($id){
		$database = UsineBDD::getUsine()->connection();
		$sql = "SELECT id FROM messagerie WHERE id=:id";
		$requete=$database->prepare($sql);
		$requete->execute(array(':id'=>$id));
		$res = $requete->fetchAll();

		if(count($res)!=0){
			return true;
		}else{
			return false;
		}
	}

	public static function messageLu($id){
		$database = UsineBDD::getUsine()->connection();
		if(self::messageExiste($id)){
			if(self::getMessage($id)[0]['id_destinataire'] == Utilisateur::getUtilisateurId()){
				$sql = "UPDATE messagerie SET lu=1  WHERE id=:id";
				$requete=$database->prepare($sql);
				$requete->execute(array(':id'=>$id));
			}

			
		
		}
	}

	
	public static function envoyerMessageA($id_trajet){
		$database = UsineBDD::getUsine()->connection();
		$passagers = Reservation::getUtilisateurReservation($id_trajet);
		$info = Trajet::getInformationTrajet($id_trajet)[0];
		$date = date('d-n-Y H:i',$info['timestamp_trajet']);
		$message ="Le trajet ".$info['ville_depart'].'-'.$info['ville_arrive'].'du '.$date.'a été annulé ! Vous avez recu 10€ en dédomagement';

		foreach($passagers as $array=>$passager){

			$sql_message = "INSERT INTO messagerie VALUES('',:ide,:idd,:c,:t,'')";
			$requete = $database->prepare($sql_message);
			$requete->execute(array(':ide'=>Utilisateur::getUtilisateurId(),':idd'=>$passager['id_membre'],':c'=>$message,':t'=>time()));
		}

			
			
			
	
	}


}