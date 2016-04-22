<!DOCTYPE html>
<html>
	<head>
	 <link rel="stylesheet" href="Global.css" />
		<link rel="stylesheet" href="Accueil.css" />
		<meta charset="utf-8" />
		<title>Bienvenue! </title>
		<title>Bienvenue! </title>
	</head>
	<body>
	<!-- Corps -->
		<div id = "Conteneur">
			<div class="Panda_logo" id="logo">
				<img src="Image/Panda.png"  alt= "Logo Pandaroid"/>
			</div>
			<div id ="Tableauform">
					<!-- Bloc du formuliare nécessaire pour l'identification -->
				<form id = "form" action="ajout_membre.php" method="post">
					
					<input type="text" name="nom" placeholder="Nom"><br><br>
					<input type="text" name="prenom" placeholder="Prenom"><br><br>						
					<input type="text" name="email"  placeholder="adresse e-mail"><br><br>
					<input type="password" name="mdp" placeholder="Mot de passe"><br><br>
					<input type="password" name="mdp2" placeholder="Confirmer mdp"><br><br>
					<input type="submit" name= "valider" value="Valider"  >
					
				</form>
			</div>	
		<p><?php
			if (isset($erreur)) echo '<br />',$erreur;
		?></p>
		</div>		
	</body>
</html>
