<?php

session_start();
function diapo($bdd){
	
				$sql = "SELECT * FROM photos";
				$sql .= " WHERE Proprietaire LIKE ".$_SESSION['id']." ";
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
include_once('album.php')
?>

