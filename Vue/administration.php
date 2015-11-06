


<?php
	include '../Controller/LoginController.php';
	include '/template/header.php';

?>
<h1> Espace d'administration </h1>

<form method='GET' action="" class="adminform">
<input type="submit" value="Afficher les membres">
<input type="hidden" name="page" value="membres">
</form>

<form method='GET' action="" class="adminform">
<input type="submit" value="Afficher les trajets">
<input type="hidden" name="page" value="trajets">
</form>

<form method="get" action="" class="adminform">
<input type="submit" name="logout" value="Se déconnecter">
</form>


<?php
	if( isset($_GET['page']) && $_GET['page'] =='trajets'){
		include('trajets_admin.php');
	}else{
		include('membres.php');
	}


	include '/template/footer.php';

?>	