<?php
require 'Configuration.php';
/**
* Classe inspiré du post suivant : http://stackoverflow.com/questions/130878/global-or-singleton-for-database-connection
*/


class UsineBDD{
	private static $_usine;
	private $_bdd;


	public static function getUsine(){

		if(!self::$_usine){
			self::$_usine = new UsineBDD();
		}

		return self::$_usine;
	}


	public  function connection(){
		if(!$this->_bdd){
			$this->_bdd = new PDO(Configuration::get('DB_DNS'),Configuration::get('DB_UTILISATEUR'),Configuration::get('DB_PASSWORD'));
		}

		return $this->_bdd;
	}

	

	
	
}