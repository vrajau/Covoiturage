<?php
$trajet = new Trajet();
if (isset($trajet)) {
	
    if ($trajet->erreurs) {
    	$html = '<div class="erreur"> <ul>';
        foreach ($trajet->erreurs as $error) {
           
            $html .= '<li>'.$error.'</li>';

        }
        $html .= '</ul> </div>';
        echo $html;
    }
    elseif(!empty(trim($trajet->confirmation))){
    		$html = '<div class="confirmation"><p>'.$trajet->confirmation.' </p> </div> ';
    		echo $html;
    }
    
   } 



   
?>
<div id="form_trajet"  class="border_element_L">
    <h2 class="title"> Nouveau Trajet </h2>
	<form action="/Controller/TrajetController.php" method="POST" class="pure-form pure-form-stacked ">
	   
		
		<input type="text" id="ville_depart_trajet" name="ville_d" placeholder="Départ" >
	

	
		<input type="text" id="ville_arrive_trajet" name="ville_a" placeholder="Arrivé">
	
    
   
 		<label> Place </label>
 		<select   name="place" class="notaligned">
 		<?php
 			for($i=1;$i<=10;$i++){
 				echo '<option value="'.$i.'">'.$i.'</option>';
 			}	
 		?>
 		</select>
        <label> Date </label>
 	    <table class="date_tab"> <tbody> <tr> <td> 
 		
 		<select name="jour" class="aligned">
 			<?php
 				for($i=1;$i < 32;$i++){
 					echo '<option value="'.$i.'"">'.$i.'</option>';
 				}
 			?>
 		</select></td>
 			<td><select name="mois" class="aligned">
 			<?php
 				for($i=1;$i < 13;$i++){
 					echo '<option value="'.$i.'"">'.$i.'</option>';
 				}
 			?>
 		</select></td>
 			<td><select name="annee" class="aligned">
 			<?php
 				for($i=date("Y");$i < (date("Y")+4);$i++){
 					echo '<option value="'.$i.'"">'.$i.'</option>';
 				}
 			?>
 		</select></td>
 			
 			<td><select name="heure" class="aligned" >
 			<?php
 				for($i=0;$i < 24;$i++){
 					if($i >= 10){
 						echo '<option value="'.$i.'"">'.$i.'</option>';
 					}else{
 						echo '<option value="0'.$i.'"">0'.$i.'</option>';
 					}
 					
 				}
 			?>
 		</select></td>
 			
 			<td><select name="minute" class="aligned">
 			<?php
 				for($i=0;$i < 60;$i++){
 					if($i >= 10){
 						echo '<option value="'.$i.'"">'.$i.'</option>';
 					}else{
 						echo '<option value="0'.$i.'"">0'.$i.'</option>';
 					}
 					
 				}
 			?>
 		</select></td></tr></tbody></table>



	<label for="prix_voyage"> Prix </label>
	<input type="text" id="prix_voyage" name="prix" size="1"> 

<button type="submit" class="button-success pure-button" name="trajet_confirmation"><i class="fa fa-map-marker"></i> Confirmer Trajet </button>
</form>
</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
<script src="/Javascript/location.js"></script>