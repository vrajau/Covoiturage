<?php

$html = '';
	if(isset($_GET['id_membre'])){
		$membre = Utilisateur::getInfo($_GET['id_membre']);
		if(count($membre)==0){
			$html = '<div class="error"><p> Ce membre n\'existe pas</p></div>';

		}else{
			$membre = $membre[0];
			$type_compte = ($membre['type_compte'] == 3)?'Conducteur/Passager' : 'Passager';
			$note = Note::calculerMoyenne($membre['id']);
		}
	}else{
		$membre = Utilisateur::getInfo(Utilisateur::getUtilisateurId())[0];
		$type_compte = ($membre['type_compte'] == 3)?'Conducteur/Passager' : 'Passager';
		$note = Note::calculerMoyenne($membre['id']);

		

	}



	if(count($membre)!=0 ){
		if($membre['type_compte'] == 3){
			$voiture = Utilisateur::getVoiture($membre['id'])[0];
			$table ='<tr> <td class="bold_td"> Marque : </td><td>'.$voiture['marque'].' </td></tr>';
			$table .='<tr> <td class="bold_td"> Modèle : </td><td>'.$voiture['modele'].'</td></tr>';
			$table .='<tr> <td class="bold_td"> Couleur : </td><td style="background-color:#'.$voiture['couleur'].'"></td></tr>';
			$table .='<tr> <td class="bold_td"> Mise en Service : </td><td>'.$voiture['mise_service'].'</td></tr>';
		}else{

			$table = '<tr><td class="italic_td" colspan="2">Ce membre ne possède pas de voiture</td></tr>';

	}

		if(!$note){
			$note="Pas encore noté";
		}else{
			$note .= '/5';
		}

	}

?>

<table class=" profil pure-table pure-table-bordered"> <thead> <tr> <th colspan="2"> Profil de  <?php echo Utilisateur::getUsername($membre['id']); ?><a href="/Controller/MessageController.php?context=envoie&id_membre=<?php echo $membre['id']?>"><img src="/image/mail.png" alt="Message"/></a> </th></tr></thead>

<tbody>
<tr> <td class="bold_td"> Né en : </td><td><?php echo $membre['naissance'];?></td></tr>
<tr> <td class="bold_td"> Membre depuis : </td><td><?php echo date('d-n-Y',$membre['timestamp_creation']);?></td></tr>
<tr> <td class="bold_td"> Type de compte : </td><td><?php echo $type_compte;?></td></tr>
<tr> <td class="bold_td"> Trajet Effectué : </td><td><?php echo $membre['nb_trajet_effectue'];?></td></tr>
<tr> <td class="bold_td"> Trajet Annulé : </td><td><?php echo $membre['nb_trajet_annule'];?></td></tr>
<tr> <td class="bold_td"> Note Moyenne : </td><td><?php echo $note;?></td></tr> </tbody> </table>

<table class="profil pure-table pure-table-bordered"> <thead> <tr> <th colspan="2"> Voiture de <?php echo Utilisateur::getUsername($membre['id']); ?></th></tr></thead>
<tbody>
<?php echo $table;?>
</tbody></table>