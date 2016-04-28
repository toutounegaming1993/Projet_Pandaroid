<?php

session_start();
function diapo($bdd){
	
				$sql = "SELECT * FROM photos";
				$resultat = $bdd->query($sql);
				while($diap=$resultat->fetch())
				{
					
					echo '<a class="image_lien" data-lightbox="diapo" href="Images/'.$_SESSION['id'].'/'.$diap['Nom'].'"><img class="image_diapo" src="Images/'.$_SESSION['id'].'/'.$diap['Nom'].'"></a>';
				}
				
}


$db_login 	= "root";
$db_pass	= "root";
$dbname 	= "pandaroid";
$bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$db_login, $db_pass);
?>

<html>
	<head>
	<!-- en tête -->
	
		
		<link rel="stylesheet" href="Global.css" />
		<link rel="stylesheet" href="Principale.css" />
		<link rel="stylesheet" href="lightbox2-master/dist/css/lightbox.min.css">
		  <script type='text/javascript' src='//code.jquery.com/jquery-1.9.1.js'></script>
		<meta charset="utf-8" />
		<title>Pandaroid</title>

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
							<li><a href="upload_photo.php">Partager une photo</a></li>
							<li><a href="diapo.php">Mes Albums</a></li>
							<li><a href="#">Paramètres</a></li>
						</ul></td>
						</tr>
					</table>
				</div>		
			</div>	
			<div id = "Contenu">
				 
				 <?php
					diapo($bdd);
				?>
			</div>
			
	
		
		
	<script src="lightbox2-master/dist/js/lightbox-plus-jquery.min.js"></script>	
	</body>
	
	
</html>