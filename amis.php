<?php
session_start();
$db_login 	= "root";
	$db_pass	= "root";
	$dbname 	= "pandaroid";	
	$bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$db_login, $db_pass);
	
function non_amis($bdd){
	
	$sql = "SELECT * FROM membre ";
	$sql .= " WHERE id NOT LIKE ".$_SESSION['id']." ";
	$resultat = $bdd->query($sql);
	while($non_amis=$resultat->fetch())
	{
		$membre_id=$non_amis['id'];
		$nom=$non_amis['nom'];
		$prenom=$non_amis['prenom'];
		echo "<a href='profil.php?membre=$membre_id'>$prenom $nom</a>";
	}
				
}

function amis($bdd){
	$mon_id=$_SESSION['id'];
	$sql = "SELECT * FROM amis ";
	$sql .="WHERE (membre1_id ='$mon_id') OR (membre2_id ='$mon_id')";
	$resultat = $bdd->query($sql);
	while($amis=$resultat->fetch())
	{	
		$membre1_id=$amis['membre1_id'];
		$membre2_id=$amis['membre2_id'];
		if($membre1_id == $mon_id){
			$membre=$membre2_id;
		}
		else{
			$membre=$membre1_id;
		}
		$nom_req = "SELECT * FROM membre ";
		$nom_req .="WHERE id LIKE '$membre' ";
		$resu = $bdd->query($nom_req);
		while($nom=$resu->fetch())
		{
			$n=$nom['nom'];
			$pre=$nom['prenom'];
			
		}
		echo "<a href='profil.php?membre=$membre'>$pre $n</a>";
	}
}

function req_amis($bdd){
	$mon_id=$_SESSION['id'];
	$sql = "SELECT * FROM req_amis ";
	$sql .="WHERE recepteur ='$mon_id' ";
	$resultat = $bdd->query($sql);
	while($req_amis=$resultat->fetch())
		{	
			$membre=$req_amis['demandeur'];
			
			$nom_req = "SELECT * FROM membre ";
			$nom_req .="WHERE id LIKE '$membre' ";
			$resu = $bdd->query($nom_req);
			while($nom=$resu->fetch())
			{
				$no=$nom['nom'];
				$pren=$nom['prenom'];
				
			}
			echo "<a href='profil.php?membre=$membre'>$pren $no</a>";
	}
}


	
	$db_login 	= "root";
	$db_pass	= "root";
	$dbname 	= "pandaroid";	
	$bdd = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$db_login, $db_pass);
			
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
			<li id="lastlink"><a href="#5">PARAMETRES</a></li>
		
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
			<form id = "form" action="amis.php" method="post" enctype="multipart/form-data" runat="server" >
				Les membres du site:<br>
				<?php
					non_amis($bdd);
				?>
				<br><br>Les membres du site qui sont vos amis:
				<?php
					amis($bdd);
				?>
				<br><br>Vos demandes d'amis:
				<?php
				req_amis($bdd)
				?>
			</form>
			<p><?php
			if (isset($erreur)) echo '<br />',$erreur;
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