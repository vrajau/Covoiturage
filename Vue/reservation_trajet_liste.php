
<?php
	
		if(isset($_POST['arrive']) && $_POST['arrive'] == -1){
				$liste_trajet = Trajet::afficherListeTrajet($_POST['depart']);
		}else{
			$liste_trajet = Trajet::afficherListeTrajet($_POST['depart'],$_POST['arrive']);
		}
		
	foreach($liste_trajet as $main_array=>$result){
		$temps = date('d-n-Y H:i',$result['timestamp_trajet']);
		$html = '<div class="liste_reservation"><table class="pure-table pure-table-bordered"><thead><tr><th>Départ</th><th>Arrivé</th><th>Date Départ</th><th>Conducteur</th><th>Prix</th><th>Place Disponible</th><th></th></tr></thead><tbody>';
		$html .= '<tr><td>'.ucfirst($result['ville_depart']).'</td>';
		$html .= '<td>'.ucfirst($result['ville_arrive']).'</td>';
		$html .= '<td>'.$temps.'</td>';
		$html .= '<td> <a href="/Controller/ProfilController.php?context=profil&id_membre='.Trajet::getTrajetConducteurId($result['id']).'">'.Utilisateur::getUsername(Trajet::getTrajetConducteurId($result['id'])).'</a></td>';
		$html .= '<td>'.$result['prix'].'&#8364;</td>';
		$place = ($result['nb_place'] == 0)? "Complet" : $result['nb_place'] ; 
		$html .= '<td>'.$place.'</td>';
		$html .= '<td><a class="button-success pure-button" href="/Controller/ReservationController.php?id_trajet_r='.$result['id'].'"><i class="fa fa-car"></i> Réserver</a></td></tr></tbody></table>';
		echo $html;
	}
	

	