<?php
include '../Vue/formulaire_note.php';




$reservations = Reservation::getAllReservation();
$n = new Note();

if(isset($n)){
	if($n->_erreurs){
		foreach($n->_erreurs as $error){
			echo $error;
		}
	}
}


$html = '<div class="liste_reservation_L">';
if(count($reservations) != 0){

		$html .= '<table class="pure-table pure-table-bordered"><thead><tr><th> Conducteur </th> <th> Trajet </th> <th> Date </th> <th>Prix </th> <th> Nombre de place prise </th> <th> Note </th></tr></thead><tbody>';
		foreach($reservations as $array=>$reservation){
				$info_trajet = Trajet::getInformationTrajet($reservation['id_trajet'])[0];
				$notation = array(5=>'Amazing!',4=>'Super bon',3=>'Ca peut aller',2=>'Peut mieux faire',1=>'Ca fait mal');
				$notation_select = '<form method="POST" action="/Controller/ProfilController.php?context=reservations&id_trajet='.$info_trajet['id'].'"><select name="note">';
		foreach($notation as $note=>$description){
				$notation_select .= '<option value="'.$note.'">'.$note.'-'.$description.'</option>';
			}
			$notation_select .= '</select> <button type="submit" class="button-success pure-button" name="confirmation_note"><i class="fa fa-thumbs-up"></i> Note</button></form>';
		
			$notation_r = (Trajet::isTrajetValide($reservation['id_trajet']))? $notation_select : 'Vous ne pouvez pas noter un trajet non valide';
			$notation_r = (Note::isNoteExiste($info_trajet['id']))? 'Vous avez noté cette personne' : $notation_r;
			$date = date('d-n-Y H:i',$info_trajet['timestamp_trajet']);
			$html .= '<tr><td><a href="/Controller/ProfilController.php?context=profil&id_membre='.$info_trajet['id_conducteur'].'">'.Utilisateur::getUsername($info_trajet['id_conducteur']).'<a href="/Controller/MessageController.php?context=envoie&id_membre='.$info_trajet['id_conducteur'].'"><img src="/image/mail.png" alt="Message"/></a></td>';
			$html .= '<td>'.ucfirst($info_trajet['ville_depart']).' - '.ucfirst($info_trajet['ville_arrive']).'</td>';
			$html .= '<td>'.$date.'</td>';
			$html .= '<td>'.$info_trajet['prix'].'</td>';
			$html .= '<td>'.$reservation['nb_place'].'</td>';
			$html .= '<td>'.$notation_r.'</td></tr>';
		}
		$html .= '</tbody></table>';

}else{
	$html .= '<div class="erreur"><p> Vous n\'avez pas de réservations pour le moment</p></div>';	
}		

$html .= '</div>';
echo $html;