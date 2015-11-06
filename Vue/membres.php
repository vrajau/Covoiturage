<?php
	$membres = Administration::getToutMembres();

	$html = '<table border="1" class="tableadmin"> <tr> <th> Nom </th> <th> Prenom </th> <th>Email</th> <th> Compte crée le </th> <th> Type Compte</th> <th> Solde </th> <th> Trajet effectué </th> </tr>';
foreach($membres as $array=>$membre){
	$creation = date('d-n-Y',$membre['timestamp_creation']);
	$type_compte = ($membre['type_compte']==3)?'Conducteur/Passager' : 'Seulement Passager';
	$html .= '<tr> <td>'.$membre['nom'].'</td>';
	$html .= ' <td>'.$membre['prenom'].'</td>';
	$html .= ' <td>'.$membre['email'].'</td>';
	$html .= ' <td>'.$creation.'</td>';
	$html .= ' <td>'.$type_compte.'</td>';
	$html .= ' <td>'.$membre['solde'].'</td>';
	$html .= '<td>'.$membre['nb_trajet_effectue'].'</td></tr>';

}

$html .='</table>';

echo $html;