<?php
$titre = isset($_POST["titre"]) ? $_POST["titre"]:"";
$lieu = isset($_POST["lieu"]) ? $_POST["lieu"]:"";
$db_login 	= "root";
$db_pass	= "root";
$dbname 	= "pandaroid";
session_start();
date_default_timezone_set('Europe/Paris');

/* Création de miniatures */
function creer_min($chemin_img,$nom_img,$largeur_min,$hauteur_min) {
	$extension = strtolower(  substr(  strrchr($nom_img, '.')  ,1)  );
	/* On prend l'image que l'on souhaite miniaturiser*/
	switch($extension){
	case 'jpeg':$image = imagecreatefromjpeg($chemin_img); break;
    case 'jpg': $image = imagecreatefromjpeg($chemin_img); break;
    case 'png': $image = imagecreatefrompng($chemin_img); break;
    case 'gif': $image = imagecreatefromgif($chemin_img); break;
	default : echo 'error';die();
	}
    
	$nouv_lar = $largeur_min;
	$nouv_haut = $hauteur_min;
    $largeur = imagesx($image);
    $hauteur = imagesy($image);
    /* On accorde la hauteur de la miniature par rapport a sa largeur  */

		$ratio = $hauteur / $largeur;
		$nratio = $nouv_haut / $nouv_lar; 

		  if($ratio > $nratio)
		  {
			$inter = intval($largeur * $nouv_haut / $hauteur);
			if ($inter < $nouv_lar)
			{
			  $nouv_haut = intval($hauteur * $nouv_lar / $largeur);
			} 
			else
			{
			  $nouv_lar = $inter;
			}
		  }
		  else
		  {
			$inter = intval($hauteur * $nouv_lar / $largeur);
			if ($inter < $nouv_haut)
			{
			  $nouv_lar = intval($largeur * $nouv_haut / $hauteur);
			} 
			else
			{
			  $nouv_haut = $inter;
			}
		  } 	
    
    /* On crée une image virtuelle avec les dimension de notre miniature */
    $image_vir = imagecreatetruecolor($nouv_lar,$nouv_haut);
    /* On copie l'image dans l'image virtuelle   */
    imagecopyresized($image_vir,$image,0,0,0,0,$nouv_lar,$nouv_haut,$largeur,$hauteur);
	 $viewimage = imagecreatetruecolor($largeur_min, $hauteur_min);
	imagecopy($viewimage, $image_vir, 0, 0, 0, 0, $nouv_lar,$nouv_haut);
    /* On cree l'image et on la place dans le repertoire voulu */
    imagejpeg($viewimage, 'min/'.$_SESSION['id'].'/'.'mini'.'_'."$nom_img");
}

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
						creer_min("$dossier/$nouveau_nom",$nouveau_nom,200,200);
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

		

