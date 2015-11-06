<?php
	$message = Messagerie::getMessage($_GET['id_message']);

	if(!$message){
		echo '<div class="erreur"><p>Il semble y avoir un problème</p></div>';
	}else{
		$message = $message[0];
		Messagerie::messageLu($message['id']);
		$html = '<div class="liste_reservation"> <table class="pure-table pure-table-bordered"> <thead> <tr><th colspan="2"> Message Envoyé par '.Utilisateur::getUsername($message['id_expediteur']).'</th></thead>';
		$html .= '<tbody> <tr><td> Date :</td><td>'.date('d-n-Y H:i',$message['timestamp_message']).'</td></tr>';
		$html .= '<tr><td colspan="2">'.$message['contenu'].'</td></tr></tbody></table>';

		echo $html;
	}