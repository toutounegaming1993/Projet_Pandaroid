<?php
$nom = isset($_POST["nom"]) ? $_POST["nom"]:"";
$prenom = isset($_POST["prenom"]) ? $_POST["prenom"]:"";
$email = isset($_POST["email"]) ? $_POST["email"]:"";
$mdp = isset($_POST["mdp"]) ? $_POST["mdp"]:"";

// on teste si le visiteur a soumis le formulaire
if (isset($_POST['valider']) AND $_POST['valider'] == 'Valider') {
	// on teste l'existence de nos variables. On teste également si elles ne sont pas vides
	if ((isset($_POST['nom']) AND !empty($_POST['nom'])) AND (isset($_POST['prenom']) AND !empty($_POST['prenom'])) AND (isset($_POST['email']) AND !empty($_POST['email'])) AND (isset($_POST['mdp']) AND !empty($_POST['mdp'])) AND (isset($_POST['mdp2']) AND !empty($_POST['mdp2'])) ) {
	// on teste les deux mots de passe
	if ($_POST['mdp'] != $_POST['mdp2']) {
		$erreur = 'Les deux mots de passe ne correspondent pas';
	}
	else {
		$db_login 	= "root";
		$db_pass	= "root";
		$dbname 	= "pandaroid";		
		try
			{
				$bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$db_login, $db_pass);
				$req = "SELECT * FROM membre";
				$req.= " WHERE email=\"$email\"";
				$resultat = $bdd->query($req);
				while($resultat->fetch()){
					if ($resultat["email"] == 1)
						{
							$verif=1;
					
						}
				}
				if($verif==1)
				{
					$sql = "INSERT INTO membre (nom, prenom, email, mdp) VALUES(";
							$sql .= "'$nom','$prenom','$email','$mdp')";
							$bdd->query($sql);
				}
				else
				{
					$erreur = 'Un membre possède déjà cet email.';
				}	
			}
		catch(Exception $e) {
				echo $e->getMessage();
				return;	
			}

		}
	}
	else {
	$erreur = 'Au moins un des champs est vide.';
	}
}





?>
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
