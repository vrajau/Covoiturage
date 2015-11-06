<?php
	$messages = Utilisateur::getAllMessage();
	$html = '<div class="liste_reservation"><table class="pure-table pure-table-bordered"><thead><tr><th>Destinataire</th><th>Réception</th><th>Message</th><th>Lire Message</th></tr></thead><tbody>';
	if(count($messages) == 0){
		$html .= '<tr><td> Pas de message </th>';
	}else{
		foreach($messages as $array=>$message){
			if(strlen($message['contenu']) > 90){
				$cont = substr($message['contenu'],0,50).'...';
			}
			else{
				$cont = $message['contenu'];
			}

			$date = date('d-n-Y H:i',$message['timestamp_message']);
			$html .= '<tr>';
			$html .= '<td><a href="/Controller/ProfilController.php?context=profil&id_membre='.$message['id_expediteur'].'">'.Utilisateur::getUsername($message['id_expediteur']).'</a></td>';
			$html .= '<td>'.$date.'</td>';
			$html .= '<td>'.$cont.'</td>';
			$html .= '<td><a href="/Controller/MessageController.php?context=lire&id_message='.$message['id'].'"> <img src="/image/readed.png" alt="Read"> </a></td>';
			$html .= '</tr>';
		}
	}

	$html .='</tbody></table></div>';


	echo $html;