<?php
	if(!isset($_GET['id_membre'])){
		header('Location: /Vue/rechercherTrajet.php');
	}

$message = new Messagerie();

if(isset($message)){
	if($message->_erreurs){
		foreach($message->_erreurs as $erreur){
			echo '<div class="erreur"><p>'.$erreur.'</p></div>';
		}
	}

	if($message->_confirmation){
		echo '<div class="confirmation"><p>'.$message->_confirmation.'</p></div>';
	}
}


?>
<div class="border_element_L">
<h2 class="title"> Envoyer un message à <?php echo Utilisateur::getUsername($_GET['id_membre']);?> </h2>

	<form action="" method="POST" class="  pure-form pure-form-stacked">
	<textarea rows="10" cols="50"  name="message" placeholder="Tapez votre message ici"></textarea>

	<button type="submit" class="pure-button pure-button-primary" name="envoie_message"><i class="fa fa-envelope-o"></i> Envoyer le Message </button>
</form>
</div>
		