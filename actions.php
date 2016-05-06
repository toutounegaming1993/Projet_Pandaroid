<?php
session_start();
$db_login 	= "root";
$db_pass	= "root";
$dbname 	= "pandaroid";	
$bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$db_login, $db_pass);

$action= $_GET['action'];

$membre=$_GET['membre'];

$mon_id=$_SESSION['id'];


if($action == 'envoie'){
	$bdd->query("INSERT INTO req_amis(demandeur, recepteur) VALUES ('$mon_id','$membre')");
}
else if($action == 'annuler'){
	$bdd->query("DELETE FROM req_amis WHERE demandeur='$mon_id' AND recepteur='$membre'");
}
else if($action == 'accepter'){
	$bdd->query("DELETE FROM req_amis WHERE demandeur='$membre' AND recepteur='$mon_id'");
	$bdd->query("INSERT INTO amis(membre1_id, membre2_id) VALUES ('$membre','$mon_id')");
}
else if($action == 'enlever'){
	$bdd->query("DELETE FROM amis WHERE (membre1_id='$membre' AND membre2_id='$mon_id') OR (membre1_id='$mon_id' AND membre2_id='$membre')");
}
header('location: profil.php?membre='.$membre);
?>
