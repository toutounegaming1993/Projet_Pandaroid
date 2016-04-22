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
				<form id = "form" action="secret.php" method="post">
							
					<input type="text" name="identifiant"  placeholder="Identifiant"><br><br>
					<input type="password" name="mdp" placeholder="Mot de passe"><br><br>
					<input type="submit" value="Valider"  >
					
				</form>
			<input type="button" onclick="self.location.href='inscription.php'" value="inscription" >	
			</div>

				
		</div>		
	</body>
	
</html>