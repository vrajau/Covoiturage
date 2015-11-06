<?php
		$message= (Utilisateur::getMessageNonLu() > 0)?'('.Utilisateur::getMessageNonLu().')' : '';
		$menu = '<div class=" size pure-menu pure-menu-horizontal">';
		$menu .= '<a href="#" class="pure-menu-heading pure-menu-link">Easy Covoit\'</a>';
		$menu .= '<ul class="pure-menu-list">';
		$menu .= '<li class="pure-menu-item"><a href="/Vue/rechercherTrajet.php" class="pure-menu-link">Rechercher un trajet</a></li>';
		$menu .= '<li class="pure-menu-item"><a href="/Controller/ProfilController.php?context=profil" class="pure-menu-link">Mon Profil</a></li>';
		$menu .= '<li class="pure-menu-item"><a href="/Controller/MessageController.php?context=reception" class="pure-menu-link">Messagerie'.$message.'</a></li>';
		$menu .= '<li class="pure-menu-item"><a href="/Controller/ProfilController.php?context=reservations" class="pure-menu-link">Mes Réservations</a></li>';

		if(Utilisateur::peutCreerTrajet()){
			$menu .= '<li class="pure-menu-item"><a href="/Controller/TrajetController.php" class="pure-menu-link">Nouveau Trajet</a></li>';
			$menu .= '<li class="pure-menu-item"><a href="/Controller/ProfilController.php?context=trajets" class="pure-menu-link">Mes Annonces</a></li>';
		}else{
			$menu .= '<li class="pure-menu-item"><a href="/Controller/VehiculeController.php" class="pure-menu-link">Devenir Conducteur!</a></li>';
		}
		$menu .= '<li class="pure-menu-item"><a href="#" class="pure-menu-link">Solde : '.Utilisateur::getSolde().'€</a></li>';
		$menu .= '<li class="pure-menu-item"> <form action="/Vue/accueil.php" methdod="GET"><button type="submit"class="button-disconnect pure-button" name="logout"><i class="fa fa-cogs"></i> Se déconnecter</button></form></li>';
		$menu .='</ul> </div>';
		echo $menu;
?>


               
                    
                    
                
            