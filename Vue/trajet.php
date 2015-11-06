<?php


	$reservation = new Reservation();
	$infos_trajet = Trajet::getInformationTrajet($_GET['id_trajet_r'])[0];
	$tmp = $infos_trajet['timestamp_trajet'];
	$jour = date('d',$tmp);
	$mois = moisFrancais(date('n',$tmp));
	$annee = date('Y',$tmp);
	$heure = date('H : i',$tmp);

	$date_depart = $jour.' '.$mois.' '.$annee.' '.$heure;

	if($infos_trajet['nb_place'] == 0){
		$reservation = "Complet";
	}else{
		$reservation = '<select name="nb_place_reserver">';
		for($i = 1; $i <= $infos_trajet['nb_place'];$i++){
			$reservation .= '<option value="'.$i.'">'.$i.' place(s)</option>';
		}
		$reservation .='</select>';
	}


	$html = '<div class="reservation">';
	$html .= '<form method="POST" action="/Controller/ReservationController.php"> <table class="pure-table pure-table-bordered">';
	$html .= '<thead><tr > <th colspan="2"> Trajet : '.ucfirst($infos_trajet['ville_depart']).'-'.ucfirst($infos_trajet['ville_arrive']).'</th></tr></thead>';
	$html .= '<tbody><tr> <td>Conducteur : </td><td><a title="Voir Profil" href="/Controller/ProfilController.php?context=profil&id_membre='.$infos_trajet['id_conducteur'].'">'.Utilisateur::getUsername($infos_trajet['id_conducteur']).'</a></td></tr>';
	$html .= '<tr> <td> Date : </td><td>'.$date_depart.'</td></tr>';

	$html .='<tr> <td> Places restante : </td><td>'.$infos_trajet['nb_place'].'</td></tr>';
	$html .='<tr> <td> Prix Place : </td><td> '.$infos_trajet['prix'].'&#8364;</td></tr>';
	$html .= '<tr><td> Réserver : </td> <td>'.$reservation.'</td></tr>';

	$html .= '</tbody></table> <button type="submit" class="button-success pure-button"><i class="fa fa-car"></i> Réserver vos places </button><input type="hidden" name="id_trajet" value="'.$infos_trajet['id'].'"></form></div>';


	echo $html;