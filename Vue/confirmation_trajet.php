
<div class="reservation_c">
	<p> Réservation de <?php echo $_POST['nb_place_reserver']; ?> place(s) pour <span class="price"><?php echo ($_POST['nb_place_reserver']*Trajet::getInformationTrajet($_POST['id_trajet'])[0]['prix']); ?>&#8364;</span></p>
	<form action="/Controller/ReservationController.php" method="POST">
		
		<input type="hidden" name="confirmation_trajet_id" value="<?php echo $_POST['id_trajet'];?>">
		<input type="hidden" name="confirmation_trajet_place" value="<?php echo $_POST['nb_place_reserver'];?>">
		<button type="submit" class="button-success pure-button" name="reservation_confirmation"><i class="fa fa-car"></i> Réserver vos places </button>
	</form>

	
</div>