
		<!-- Corps -->
	<?php 
			if{
				(isset($_POST['mdp']) AND $_POST['mdp'] ==  "kangourou")AND(isset($_POST['identifiant']) AND $_POST['identifiant'] ==  "kangourou")
				header("Location: page_principale.php" ); 
			/* Redirige le client vers le site PHP */ 
			  exit();
			}
			else // Sinon, on affiche un message d'erreur
    {
        echo '<p>Mot de passe ou identifiant incorrect</p>';
    }
		?>
			
