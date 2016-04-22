<!DOCTYPE html>
<html>
	<head>
	<!-- en tête -->
	
		<link rel="stylesheet" href="Global.css" />
		<link rel="stylesheet" href="Accueil.css" />
		<meta charset="utf-8" />
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
				<form id = "form" action="Connection.php" method="post">
							
					<input type="text" name="email"  placeholder="Identifiant"><br><br>
					<input type="password" name="mdp" placeholder="Mot de passe"><br><br>
					<input type="submit" name= "valider" value="Valider"  >
					
				</form>
			<input type="button" onclick="self.location.href='ajout_membre.php'" value="inscription" >	
			</div>

			<p><?php
			if (isset($erreur)) echo '<br />',$erreur;
		?></p>	
		</div>		
	</body>
	
</html>