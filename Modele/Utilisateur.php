<?php
class Utilisateur{

 

	public static function getUtilisateurId(){
		return $_SESSION['id_utilisateur'];
	}
	public static function peutCreerTrajet(){
		$database = UsineBDD::getUsine()->connection();
		$sql_type = "SELECT type_compte FROM utilisateur WHERE id=:id ";
		$requete_type = $database->prepare($sql_type);

		$requete_type->execute(array(":id"=>Utilisateur::getUtilisateurId()));
		$res_type = $requete_type->fetchAll();

		if($res_type[0]["type_compte"] == 3){
			return true;
		}
		else{
			return false;
		}
	}

	public static function comparerTmp($timestamp){
		$database = UsineBDD::getUsine()->connection();
		$resultat_comparaison = false;
		$id = Utilisateur::getUtilisateurId();
		$sql_tmp_last_trajet = "SELECT * FROM trajet WHERE id_conducteur=:id ";
		$requete_tmp_last_trajet = $database->prepare($sql_tmp_last_trajet);
		$requete_tmp_last_trajet->execute(array(":id"=>$id));
		$res = $requete_tmp_last_trajet->fetchAll();
		foreach($res as $array=>$tmp){
			
			if(date('dnY',$tmp['timestamp_trajet']) == date('dnY',$timestamp)){
				$resultat_comparaison = true;
			}
		}
		return $resultat_comparaison;

	}

	public static function getUsernameLoggedUser(){
		return self::getUsername(self::getUtilisateurId());
	}

	public static function getUsername($id){
		$database = UsineBDD::getUsine()->connection();
		$sql_pseudo = "SELECT SUBSTRING(nom,1,1) as name,prenom FROM Utilisateur WHERE id=:id";
		$requete_pseudo = $database->prepare($sql_pseudo);
		$requete_pseudo->execute(array(':id'=>$id));
		$resultat_pseudo = $requete_pseudo->fetchAll();

		$pseudo = ucfirst($resultat_pseudo[0]['prenom']).' '.ucfirst($resultat_pseudo[0]['name']);

		return $pseudo;
	}

	public static function getSolde(){
		$database = UsineBDD::getUsine()->connection();
		$sql_solde = "SELECT solde FROM Utilisateur WHERE id=:id";
		$requete_solde = $database->prepare($sql_solde);
		$requete_solde->execute(array(':id'=>self::getUtilisateurId()));
		$res = $requete_solde->fetchAll();

		return $res[0]['solde'];
	}


	public static function isAdmin(){
		$database = UsineBDD::getUsine()->connection();
		$sql_type = "SELECT type_compte FROM utilisateur WHERE id=:id ";
		$requete_type = $database->prepare($sql_type);
		$requete_type->execute(array(":id"=>Utilisateur::getUtilisateurId()));
		$res_type = $requete_type->fetchAll();

		if($res_type[0]['type_compte'] ==  1){
			return true;
		}else{
			return false;
		}

	}


	public static function ajouterSolde($montant,$id){
			$database = UsineBDD::getUsine()->connection();

			$sql_ajout = "UPDATE utilisateur SET solde=solde+:m WHERE id=:id";
			$requete_ajout = $database->prepare($sql_ajout);
			$requete_ajout->execute(array(':id'=>$id,':m'=>$montant));
	}

	public static function ajoutTrajetV(){
		$database = UsineBDD::getUsine()->connection();

	$sql_ajout = "UPDATE utilisateur SET nb_trajet_effectue=nb_trajet_effectue+1 WHERE id=:id";
		$requete_ajout = $database->prepare($sql_ajout);
		$requete_ajout->execute(array(':id'=>Utilisateur::getUtilisateurId()));
	}

	public static function ajoutTrajetA(){
		$database = UsineBDD::getUsine()->connection();

		$sql_ajout = "UPDATE utilisateur SET nb_trajet_annule=nb_trajet_annule+1 WHERE id=:id";
		$requete_ajout = $database->prepare($sql_ajout);
		$requete_ajout->execute(array(':id'=>Utilisateur::getUtilisateurId()));
	}
	
	public static function retirerSolde($montant,$id){
		$database = UsineBDD::getUsine()->connection();

		$sql_ajout = "UPDATE utilisateur SET solde=solde-:m WHERE id=:id";
		$requete_ajout = $database->prepare($sql_ajout);
		$requete_ajout->execute(array(':m'=>$montant,':id'=>$id));
	}
	

	public static function rendreConducteur(){
		$database = UsineBDD::getUsine()->connection();
		$sql = "UPDATE Utilisateur SET type_compte=3 WHERE id=:id";
		$requete = $database->prepare($sql);
		$requete->execute(array(':id'=>self::getUtilisateurId()));

	}

	public static function getInfo($id_membre){
		$database = UsineBDD::getUsine()->connection();
		if(Utilisateur::membreExiste($id_membre)){
			$sql = "SELECT * FROM utilisateur WHERE id=:id";
			$requete=$database->prepare($sql);
			$requete->execute(array(':id'=>$id_membre));
			$res = $requete->fetchAll();
			return $res;
		}
		
	}

	public static function membreExiste($id_membre){
		$database = UsineBDD::getUsine()->connection();
		$sql = "SELECT id FROM utilisateur WHERE id=:id";
		$requete=$database->prepare($sql);
		$requete->execute(array(':id'=>$id_membre));
		$res = $requete->fetchAll();

		if(count($res)!=0){
			return true;
		}else{
			return false;
		}
	}
	
	public static function getVoiture($id_membre){
		$database = UsineBDD::getUsine()->connection();
		$sql = "SELECT * FROM vehicule v WHERE id_membre=:id";
		$requete=$database->prepare($sql);
		$requete->execute(array(':id'=>$id_membre));
		$res = $requete->fetchAll();

		return $res;

	}


	public static function getAllMessage(){
		$database = UsineBDD::getUsine()->connection();
		$sql = "SELECT * FROM messagerie v WHERE id_destinataire=:id ORDER BY 5 DESC";
		$requete=$database->prepare($sql);
		$requete->execute(array(':id'=>Utilisateur::getUtilisateurId()));
		$res = $requete->fetchAll();

		return $res;

	}

	public static function getMessageNonLu(){
		$messages = self::getAllMessage();
		$nbMessageNL = 0;
		foreach($messages as $array=>$message){
			if($message['lu']==0){
				$nbMessageNL++;
			}
		}

		return $nbMessageNL;
	}

}