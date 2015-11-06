
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>EasyCovoit</title>
			<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
			<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/base-min.css">
			<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/buttons-min.css">
			<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/forms-nr-min.css">
			<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/menus-nr-min.css">
			<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/tables-min.css">
			<link rel="stylesheet" href="/Vue/CSS/customize.css">
			<link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
			
			
		
			


    
		</head>
		  <body>


<?php
		$menu = '<div class="size pure-menu pure-menu-horizontal">';
		$menu .= '<a href="#" class="pure-menu-heading pure-menu-link">Easy Covoit\'</a>';
		$menu .= '<ul class="pure-menu-list">';
		$menu .= '<li class="pure-menu-item"><a href="/Controller/InscriptionController.php" class="pure-menu-link">S\'inscrire</a></li>';
		$menu .= '<li class="pure-menu-item"><a href="/Vue/accueil.php" class="pure-menu-link">Se connecter</a></li>';
		$menu .='</ul> </div>';
		echo $menu;
?>
<?php
$registration = new Inscription();
if (isset($registration)) {

    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo '<div class="erreur"><p>'.$error.'</p></div>';
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo '<div class="confirmation"><p>'.$message.'</p></div>';
        }
    }
} 
?>

<div class="border_element_L">
<h2 class="title"> Inscription </h2>
	<form method="POST" action="/Controller/InscriptionController.php" class="  pure-form pure-form-stacked">
			<fieldset>
		
			<label for="nom_utilisateur"> Nom :  </label>
			<input type="text" id="nom_utilisateur" name="nom" required>
	
			<label for="prenom_utilisateur"> Prénom </label>
			<input type="text" id="prenom_utilisateur" name="prenom" required>
	

		
			<label for="pwd_utilisateur"> Mot de Passe :  </label>
			<input type="password" id="pwd_utilisateur" name="pwd">
		
			<label for="confirmation_pwd_utilisateur"> Confirmation </label>
			<input type="password" id="confirmation_pwd_utilisateur" name="confirmation_pwd">
		

		
			<label for="email_utilisateur"> E-mail : </label>
			<input type="text" id="email_utilisateur" name="email">
		


		
			<label> Année de Naissance </label>
			<?php
				
				$select3='<select class="select_date_naissance" name="annee">';
				for($i=date("Y");$i > 1900;$i--){
					$select3 .= '<option value="'.$i.'">'.$i.'</option>';
				}
				$select3 .= "</select>";

				echo $select3;
		?>

		
		<input type="submit" name="inscription" class="button-success pure-button" value="Inscription Complete" >
		</fieldset>
	</form>

</div></body></html>
