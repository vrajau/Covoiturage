<?php
$vehicule = new Vehicule();

	if(count($vehicule->_erreurs) > 0){
		$html = '<div class="erreur"> <p> Erreur :<ul>';
		foreach($vehicule->_erreurs as $message){
			$html .= '<li>'.$message.'</li>';
		}

		$html .= '</ul></div>';


	}else{
		$html = '<div class="confirmation">';
		$html .= '<p>'.$vehicule->_confirm.'</p>';
		$html .= '</div>';
	}

	echo $html;