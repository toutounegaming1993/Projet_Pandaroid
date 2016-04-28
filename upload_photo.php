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
						$sql = "INSERT INTO photos (Nom, Lieu, Proprietaire, Date) VALUES(";
						$sql .= "'$nouveau_nom','$lieu', ".$_SESSION['id'].",'$date')";
						$bdd->query($sql);
					}
			}		
		}
	}
	else {
		$erreur = 'Un des champ est vide';
	}
}
?>

		
<html>
	<head>
	<!-- en tête -->
	
		
		<link rel="stylesheet" href="Global.css" />
		<link rel="stylesheet" href="Principale.css" />
		<meta charset="utf-8" />
		 <script type='text/javascript' src='//code.jquery.com/jquery-1.9.1.js'></script>
		<title>Pandaroid</title>
		<script type="text/javascript">
			   function readURL(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
					$('#image').attr('src', e.target.result);
				   }
					reader.readAsDataURL(input.files[0]);
				   }
				}
		</script>

	</head>
	
	<body>	
	<!-- Corps -->
		<div id = "Conteneur">
			<div id = "head">
				
				<div id ="Menu">
				<!-- Bloc des differentes options de notre site -->
					
					
					<table >
						<tr>
						<td><div id="logo">
								<img src="Image/Panda.png"  alt= "Logo Pandaroid"/>
							</div></td>
						<td><ul>
							<li><a href="#" ><b>Populaire</b></li>
							<li><a href="#"><b>Nouveau</b></li>
							<li><a href="Page_principale.php">Accueil</a></li>
							<li><a href="#">Mon Profil</a></li>
							<li><a href="#">Partager une photo</a></li>
							<li><a href="#">Mes Albums</a></li>
							<li><a href="#">Paramètres</a></li>
						</ul></td>
						</tr>
					</table>
				</div>		
			</div>
			<div id = "Contenu">
			<form id = "form" action="upload_photo.php" method="post" enctype="multipart/form-data" runat="server" >
					<input type="hidden" name="MAX_TAILLE_FICHIER" value="10485760" />		
					<input onchange="readURL(this);"  type="file" name="photo"><br><br>
						<img alt="Votre Image s'affiche ici" id="image" src="#" /><br><br>
					<input type="text" name="titre" placeholder="titre de la photo"><br><br>
					<input type="text" name="lieu" placeholder="Lieu de la photo">
					<input type="submit" name= "valider" value="Valider"  >
					
			</form>
			<!--<div "titre_image">
				<h4>Tire Image</h4>
			</div>	
			<div id ="date">
				<p>Date image</p>
			</div>
			
			<div id= "contenu_footer">
				<div id ="boutons_vote">
					<table>
						<tr>
						<td><img src ="Image/upvote.png" alt= "Upvote"/></td>
						<td><img src ="Image/downvote.png" alt= "Downvote"/></td>
					</table>
				</div>
				 <div id="social">
					<table>
						<td><img src="Image/facebook.png"  alt= "Facebook"/></td>
						<td><img src="Image/twitter.png"  alt= "Twitter"/></td>
					</table>
				</div>
			</div>-->
		
			<p><?php
			if (isset($erreur)) echo '<br />',$erreur;
		?></p>		
			</div>
				
		</div>
	</body>
</html>

