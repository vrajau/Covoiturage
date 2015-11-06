<?php
	$reservation = new Reservation();

	if(count($reservation->_erreurs) > 0){
		$html = '<div class="erreurs"> <p> Erreur :<ul>';
		foreach($reservation->_erreurs as $message){
			$html .= '<li>'.$message.'</li>';
		}

		$html .= "</ul> </p> </div>";


	}else{
		$html = '<div class="confirmation">';
		$html .= '<p>'.$reservation->_confirm.'</p>';
		$html .= '</div>';
	}

	echo $html;