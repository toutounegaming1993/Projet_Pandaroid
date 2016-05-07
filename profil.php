<?php
include_once('fonctions.php');
if(isset($_GET['membre']) AND !empty($_GET['membre']))
	$membre=$_GET['membre'];
else{
	$membre=$_SESSION['id'];	
}

$sql = "SELECT * FROM membre";
$sql .= " WHERE id LIKE '$membre' ";
$resultat = $bdd->query($sql);
while($non_amis=$resultat->fetch()){

	$nom=$non_amis['nom'];
	$prenom=$non_amis['prenom'];

	
}
$mon_id=$_SESSION['id'];
if($membre!=$mon_id){
	
	$res = $bdd->query("SELECT * FROM amis WHERE (membre1_id='$mon_id' AND membre2_id='$membre') OR(membre1_id='$membre' AND membre2_id='$mon_id')");
	$rows=$res->rowCount();
	if($rows==1){
		$social= "<a href='#' class='b_social'> Vous êtes déjà amis</a> | <a href='actions.php?action=enlever&membre=$membre' class='b_social'> Retirer $prenom $nom de ma liste d'amis</a> " ;
	}
		
	else{
		$res_dem = $bdd->query("SELECT * FROM req_amis WHERE demandeur='$membre' AND recepteur='$mon_id'");
		$res_rec = $bdd->query("SELECT * FROM req_amis WHERE demandeur='$mon_id' AND recepteur='$membre'");
		if($res_dem->rowCount()==1){
			$social= "<a href='actions.php?action=accepter&membre=$membre' class='b_social'> Accepter</a> | <a href='#' class='bouton'> Ignorer</a>";
		}
		else if($res_rec->rowCount()==1){
			$social= "<a href='actions.php?action=annuler&membre=$membre' class='b_social'> Annuler la demande</a> ";
		}
		else{
			$social= "<a href='actions.php?action=envoie&membre=$membre' class='b_social'> Envoyer une demande d'amis</a> ";
		}
			
	}
}
		
?>
<html>

    <head>
		<link rel="stylesheet" href="PandaRoid.css" />
		<link rel="shortcut icon" href="tetedepanda.ico"/>
		<!-- ADAPTER LA TAILLE A TOUS LES ECRANS !-->
		<script type='text/javascript' src='//code.jquery.com/jquery-1.9.1.js'></script>
		<script type="text/javascript">

</script>
		<meta name="viewport" content="width=device-width" />
        <meta charset="utf-8" />
        <title>PandaRoid</title>
    </head>

	<div id="nav">
		<ul>
			<img src="Image/tetecadree.jpg" alt="tete"/>
			<li id="links"><a href="pandaroid.php">ACCUEIL</a></li>
			<li id="links"><a href="profil.php"><?php 
			$prenom = strtoupper($_SESSION['prenom']);
			echo $prenom; 
			?></a></li>
			<li id="links"><a href="upload_photo.php">PARTAGER UNE PHOTO</a></li>
			<li id="links"><a href="diapo.php">ALBUMS</a></li>
			<li id="links"><a href="amis.php">AMIS</a></li>
			<li id="links"><a href="#5">PARAMETRES</a></li>
			<li id="lastlink"><a href="log_out.php">DECONNEXION</a></li>
		
		<div id="recherche_p">
			<form action="/search" id="searchthis" method="get">
				<input id="search" name="q" type="text" placeholder="Rechercher" />
				<input id="search-btn" src="Image/recherche1.png" type=image value=submit align="middle"/>
			</form>
		</div>
		</ul>
		
		
	</div>
	
	<header class="header">
		<div id="banniere">
			<img src="Image/bannierepandacadre.png"  alt= "banniere PandaRoid"/>
		</div>
	</header>
	
    <body>
		<div id="fond">
			<div id="contenu">
			<p><?php
			if (isset($social)) echo '<br />',$social;
		?></p>
			</div>
		</div>
	</body>
	
	
	<footer>
		<div id="footer">
			MAI LAM + DUHESME COPYRIGHT MODAFUKA NERF DAT BITCH PLZZZ YOLO BBOY IN DA PLACE 
		</div>
	</footer>
	
	
</html>
