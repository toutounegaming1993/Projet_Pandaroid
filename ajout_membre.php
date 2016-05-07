<?php

$nom = isset($_POST["nom"]) ? $_POST["nom"]:"";
$prenom = isset($_POST["prenom"]) ? $_POST["prenom"]:"";
$email = isset($_POST["email"]) ? $_POST["email"]:"";
$mdp = isset($_POST["mdp"]) ? $_POST["mdp"]:"";
$db_login 	= "root";
$db_pass	= "root";
$dbname 	= "pandaroid";	
$verif=0;		

// on teste si le visiteur a soumis le formulaire
if (isset($_POST['valider']) AND $_POST['valider'] == 'Valider') {
	// on teste l'existence de nos variables. On teste également si elles ne sont pas vides
	if ((isset($_POST['nom']) AND !empty($_POST['nom'])) AND (isset($_POST['prenom']) AND !empty($_POST['prenom'])) AND (isset($_POST['email']) AND !empty($_POST['email'])) AND (isset($_POST['mdp']) AND !empty($_POST['mdp'])) AND (isset($_POST['mdp2']) AND !empty($_POST['mdp2'])) ) {
	// on teste les deux mots de passe
	if ($_POST['mdp'] != $_POST['mdp2']) {
		$erreur = 'Les deux mots de passe ne correspondent pas';
	}
	elseif(!preg_match("~^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$~i",$email)){
		$erreur = 'Addresse e-mail invalide';
	}
	else {
		
		try
			{
				$bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$db_login, $db_pass);
				$sql = "SELECT * FROM membre";
				$sql .= " WHERE email LIKE '%$email%' ";
				$resultat = $bdd->query($sql);
				while($mail=$resultat->fetch()){
					if ($mail["email"] == $email)
						{
							$verif=1;
						}
					else{
						$id=$mail["id"];
					}
				}
				if($verif==0)
				{
					session_start();
					$_SESSION['email']=$email;
					$sql = "INSERT INTO membre (nom, prenom, email, mdp) VALUES(";
					$sql .= "'$nom','$prenom','$email','$mdp')";
					$bdd->query($sql);
					$_SESSION['id']=$bdd->lastInsertId();
					$id=$_SESSION['id'];
					$_SESSION['url']="Images/$id/";
					$_SESSION['prenom']=$prenom;
					mkdir($_SESSION['url'], 0777, true);
					mkdir("min/$id/", 0777, true);
					header("Location: PandaRoid.php" ); 
					/* Redirige le client vers le site PHP */ 
					exit();
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
include_once('inscription.php');
?>
