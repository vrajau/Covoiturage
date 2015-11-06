<?php
if(isset($_GET['annulation_trajet']) && !empty(trim($_GET['annulation_trajet']))){
	$t = new Trajet();
	$t->annulationTrajet($_GET['id_trajet']);
	if(!empty(trim($t->confirmation))){
		echo '<div class="confirmation"><p>'.$t->confirmation.'</p></div>';
	}
}


$html ='';


if(isset($_GET['id_trajet']) && !empty(trim($_GET['id_trajet'])) && Trajet::trajetExiste($_GET['id_trajet'])){

if(isset($_GET['validation_trajet']) && !empty(trim($_GET['validation_trajet']))){
	$t = new Trajet();
	$t->validationTrajet($_GET['id_trajet']);
	if(!empty(trim($t->confirmation))){
		echo '<div class="confirmation"><p>'.$t->confirmation.'</p></div>';
	}
}

$n = new Note();

if(isset($n)){
	if($n->_erreurs){
		foreach($n->_erreurs as $error){
			echo '<div class="erreur"><p>'.$error.'</p></div>';
		}
	}
}




$info_trajet = Trajet::getInformationTrajet($_GET['id_trajet'])[0];
$reservations = Reservation::getUtilisateurReservation($info_trajet['id']);



if(count($reservations) != 0 && count($info_trajet) !=0){
	$html .= '<div class="liste_reservation"> <table class="pure-table pure-table-bordered"><thead> <tr> <th> Reservation </th> <th> Nombre de place prise</th>  <th> Note </th></tr> </thead>';
	foreach($reservations as $array=>$reservation){
//Notation
$notation = array(5=>'Amazing!',4=>'Super bon',3=>'Ca peut aller',2=>'Peut mieux faire',1=>'Ca fait mal');
				$notation_select = '<form method="POST" action="/Controller/ProfilController.php?context=trajets&id_trajet='.$info_trajet['id'].'&id_u='.$reservation['id_membre'].'"><select name="note">';
		foreach($notation as $note=>$description){
				$notation_select .= '<option value="'.$note.'">'.$note.'-'.$description.'</option>';
			}
			$notation_select .= '</select> <button type="submit" class="button-success pure-button" name="confirmation_note"><i class="fa fa-thumbs-up"></i> Note</button></form></form>';
$notation_r = (Trajet::isTrajetValide($info_trajet['id']))? $notation_select : 'Vous ne pouvez pas noter un trajet non valide';
$notation_r = (Note::isNoteExisteU($info_trajet['id'],$reservation['id_membre']))? 'Vous avez noté cette personne' : $notation_r;




		$html .= '<tbody><tr> <td><a href="/Controller/ProfilController.php?context=profil&id_membre='.$reservation['id_membre'].'">'.Utilisateur::getUsername($reservation['id_membre']).'    <a href="/Controller/MessageController.php?context=envoie&id_membre='.$reservation['id_membre'].'"><img src="/image/mail.png" alt="Message"/></a></td>';
		$html .= '<td>'.Reservation::getNombrePlaceReserve($info_trajet['id'],$reservation['id_membre']).'</td>';
		$html .= '<td>'.$notation_r.'</td></tr>';
		
		
}
		if(!Trajet::isTrajetValide($info_trajet['id'])){
			$html .= '<tr> <td colspan="4"><a class="button-validation pure-button" href="/Controller/ProfilController.php?context=trajets&id_trajet='.$info_trajet['id'].'&validation_trajet=1"> Validation du trajet </a></td> </tr>';
			$html .=  '<tr> <td colspan="4"> <a class="button-warning pure-button" href="/Controller/ProfilController.php?context=trajets&id_trajet='.$info_trajet['id'].'&annulation_trajet=1"> Annuler le trajet </a></tr>';   
		}else{
			
			$html .= '<tr> <td colspan="4"> Trajet Validé </td></tr>';
		}

		$html .='</tbody></table> </div>';
}elseif(count($reservations) == 0 && count($info_trajet) !=0){
	$html .= '<div class="erreur"><p> Il n\' y a aucune réservation sur ce trajet </p></div>';
}


		

}elseif(isset($_GET['id_trajet']) && !empty(trim($_GET['id_trajet'])) && !Trajet::trajetExiste($_GET['id_trajet'])){
		$html .= "<p> Ce trajet n'existe plus !</p>";
}else{
$trajets = Trajet::getAllTrajetConducteur();

if(count($trajets) != 0){
	foreach($trajets as $array=>$trajet){
		$html .= '<div class="liste_reservation">';
	$infos_trajet = Trajet::getInformationTrajet($trajet['id'])[0];

	$tmp = $infos_trajet['timestamp_trajet'];
	$jour = date('d',$tmp);
	$mois = moisFrancais(date('n',$tmp));
	$annee = date('Y',$tmp);
	$heure = date('H : i',$tmp);

	$date_depart = $jour.' '.$mois.' '.$annee.' '.$heure;


	$html .= '<table class="pure-table pure-table-bordered"><thead>';
	$html .= '<tr > <th colspan="2"> Trajet : '.ucfirst($infos_trajet['ville_depart']).'-'.ucfirst($infos_trajet['ville_arrive']).'</th></tr></thead>';
	$html .= '<tbody><tr> <td> Date : </td><td>'.$date_depart.'</td></tr>';
	$html .='<tr> <td> Places restante : </td><td>'.$infos_trajet['nb_place'].'</td></tr>';
	$html .='<tr> <td> Prix Place : </td><td> '.$infos_trajet['prix'].'&#8364;</td></tr>';
	$html .= '<tr> <td colspan="2"> <a class="pure-button pure-button-primary" href="/Controller/ProfilController.php?context=trajets&id_trajet='.$infos_trajet['id'].'"> Préparation trajet </a></tr>';
	
	$html .= '</tbody></table> </div>';


	
}
}else{
		$html .= '<div class="erreur"><p> Il n\' y a pas de trajet à afficher </p></div>';
}


}














echo $html;