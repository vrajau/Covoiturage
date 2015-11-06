<?php

include '../Controller/LoginController.php';
include '../Vue/template/header.php';

render_only('menu.php');
$trajets = Administration::getToutTrajets();
?>
<div class="border_element">
<h2 class="title"> Rechercher un trajet </h2>
<form method="POST" action="/Controller/ReservationController.php" class=" rechercher pure-form-stacked pure-form">
<?php
		
		$villesd =array();
		$villesa = array();
		$select1='<select name="depart">';
		$select2='<select name="arrive">';
		$select1 .='<option value="-1"> Choisir un point de départ</option>';
		foreach($trajets as $array=>$trajet){
	
			if(!in_array($trajet['ville_depart'],$villesd)){
				$select1 .= '<option value="'.$trajet['ville_depart'].'">'.ucfirst($trajet['ville_depart']).'</option>';
			}
					$villesd[] = $trajet['ville_depart'];
			
		}
		$select2 .='<option value="-1"> Choisir une destination</option>';
		foreach($trajets as $array=>$trajet){
			
			if(!in_array($trajet['ville_arrive'],$villesa)){
			$select2 .= '<option value="'.$trajet['ville_arrive'].'">'.ucfirst($trajet['ville_arrive']).'</option>';
				}
				$villesa[] = $trajet['ville_arrive'];
		}

		

		$select1.="</select>";
		$select2.="</select>";
	

			$select = $select1.$select2;

			echo $select;
?>

<input type="submit" class="pure-button pure-button-primary" value="Rechercher un trajet">
</form></div>

