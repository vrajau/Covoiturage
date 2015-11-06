
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
<div class="border_element">
<h2 class="title"> Easy Covoit'</h2>
<p class="subtitle"> Le site de covoiturage minimaliste </p>
<form method="POST" action="/Controller/LoginFirst.php" class="pure-form">

	<p>
		
		<input type="text" id="utilisateur" class="input_login_field"  name="id_user" placeholder="Adresse e-mail" required>
	</p>


	<p>
		
		<input type="password" id="password" class="input_login_field" name="pwd_user" placeholder="Mot de Passe" required>
	</p>

		 <p><input type="submit" class="pure-button pure-button-primary" value="Connexion" name="login"></p>

</form>

</div>

</body></html>