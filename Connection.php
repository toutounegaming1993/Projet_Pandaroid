<?php
$email = isset($_POST["email"]) ? $_POST["email"]:"";
$mdp = isset($_POST["mdp"]) ? $_POST["mdp"]:"";
$db_login 	= "root";
$db_pass	= "root";
$dbname 	= "pandaroid";	
$verif=0;		

// on teste si le visiteur a soumis le formulaire
if (isset($_POST['valider']) AND $_POST['valider'] == 'Se Connecter') {
	// on teste l'existence de nos variables. On teste également si elles ne sont pas vides
	if ((isset($_POST['email']) AND !empty($_POST['email'])) AND (isset($_POST['mdp']) AND !empty($_POST['mdp'])) ) {
		try
			{
				
				$bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$db_login, $db_pass);
				$sql = "SELECT * FROM membre";
				$sql .= " WHERE email LIKE '%$email%' ";
				$sql .= " AND mdp LIKE '%$mdp%' ";
				$resultat = $bdd->query($sql);
				while($mail=$resultat->fetch()){
					if (($mail["email"] == $email)AND($mail["mdp"] == $mdp))
						{
							$verif=1;
							session_start();
							$_SESSION['email']=$email;
							$_SESSION['id']=$mail['id'];
							$id=$_SESSION['id'];
							$_SESSION['url']="Images/$id/";
							header("Location: PandaRoid.php" ); 
							/* Redirige le client vers le site PHP */ 
							exit();
						}	
				}
				if($verif==0)
				{
					
					$erreur = 'e-mail ou mot de passe non correct';
				}	
			}
		catch(Exception $e) {
				echo $e->getMessage();
				return;	
			}
	}
	else {
	$erreur = 'Au moins un des champs est vide.';
	}

}
include_once('PandaRoidAcc.php');
?>