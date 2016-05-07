<?php
$titre = isset($_POST["titre"]) ? $_POST["titre"]:"";
$lieu = isset($_POST["lieu"]) ? $_POST["lieu"]:"";
$db_login 	= "root";
$db_pass	= "root";
$dbname 	= "pandaroid";
session_start();
date_default_timezone_set('Europe/Paris');

if (isset($_POST['valider']) AND $_POST['valider'] == 'Valider') {
	
	// on teste l'existence de nos variables. On teste également si elles ne sont pas vides
	
	if ((isset($_POST['titre']) AND !empty($_POST['titre'])) AND (isset($_POST['lieu']) AND !empty($_POST['lieu']))){
		
		$maxsize=$_POST['MAX_TAILLE_FICHIER'];
		$image=$_FILES['photo']['name'];
		$image_tmp=$_FILES['photo']['tmp_name'];
		$dossier = $_SESSION['url'];
		$ext_image = substr($image, strrpos($image, '.') + 1);
		
		// on renomme le fichier
		$date = date("ymdhis");
		$nouveau_nom = $date . "." . $ext_image;
		
		if ($_FILES['photo']['error'] > 0) $erreur = "Erreur lors du transfert";
		else{
			if ($_FILES['photo']['size'] > $maxsize) $erreur = "Le fichier est trop gros";
			else
			{
				$formats = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
				$verif = strtolower(  substr(  strrchr($_FILES['photo']['name'], '.')  ,1)  );
				if ( in_array($verif,$formats) )
					{
						move_uploaded_file($image_tmp, "$dossier/$nouveau_nom");
						$bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$db_login, $db_pass);
						$sql = "INSERT INTO photos (Nom, Titre, Lieu, Proprietaire, Date) VALUES(";
						$sql .= "'$nouveau_nom','$titre','$lieu', ".$_SESSION['id'].",'$date')";
						$bdd->query($sql);
					}
			}		
		}
	}
	else {
		$erreur = 'Un des champ est vide';
	}
}
include_once('upphoto.php');
?>

		

