<?php

	function render($file){
		include '../Vue/template/header.php';
		render_only('../Vue/menu.php');
		include '../Vue/'.$file;
		include '../Vue/template/footer.php';

	}


	function render_only($file){
		include '../Vue/'.$file;
	}


	function moisFrancais($numero){
		$mois_mots = array(1=>"Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre");

		return $mois_mots[$numero];
	}
