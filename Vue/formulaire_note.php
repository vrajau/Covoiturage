<?php
	$notation = array(5=>'Amazing!',4=>'Super bon',3=>'Ca peut aller',2=>'Peut mieux faire',1=>'Ca fait mal');

	$notation_select = '<form method="POST" action=""><select name="note">';

	foreach($notation as $note=>$description){
		$notation_select .= '<option value="'.$note.'">'.$note.'-'.$description.'</option>';
	}

	$notation_select .= '</select> <input type="submit" value="Valider la note" name="confirmation_note"></form>';