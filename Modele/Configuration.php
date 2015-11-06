<?php

class Configuration{
	public static $_configuration;

	public static function get($cle){
		if(!self::$_configuration){
			$fichier_configuration_url = "../Config/configuration_constantes.php";

			if(!file_exists($fichier_configuration_url)){
				return false;
			}
			//Affecte le contenu du fichier à la variable de classe
			self::$_configuration = require $fichier_configuration_url;

		}
		//Le contenu étant un tableau de hashage, nous pouvont récupérer l'information grâce à la clé 
		//précisé dans le paramètre de la fonction
		return self::$_configuration[$cle];
	}

}