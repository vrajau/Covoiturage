<?php
	$trajets = Administration::getToutTrajets();

	$html = '<table border="1" class="tableadmin"> <tr> <th> Conducteur </th> <th> Ville Départ </th> <th>Ville Arrivé</th> <th> Prévu le  </th> <th> Prix</th> <th> Place Restante </th></tr>';
foreach($trajets as $array=>$trajet){
	$creation = date('d-n-Y H:i',$trajet['timestamp_trajet']);
	$html .= '<tr> <td>'.Utilisateur::getUsername($trajet['id_conducteur']).'</td>';
	$html .= ' <td>'.ucfirst($trajet['ville_depart']).'</td>';
	$html .= ' <td>'.ucfirst($trajet['ville_arrive']).'</td>';
	$html .= ' <td>'.$creation.'</td>';
	$html .= ' <td>'.$trajet['prix'].'</td>';
	$html .= ' <td>'.$trajet['nb_place'].'</td></tr>';
	

}

$html .='</table>';

echo $html;