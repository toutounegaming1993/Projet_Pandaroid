<?php
session_start();
include_once('bdd.php');	
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
		$nom="$pre $n";
		return $nom;
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
function diapo($bdd){
	$mon_id=$_SESSION['id'];
	$amigas=liste_amis($bdd);
	if($amigas!=null)
		$amigass=join(',',$amigas);
	else
		$amigass=$mon_id;
	$sql = "SELECT * FROM photos ";
	$sql .= " WHERE Proprietaire LIKE ".$_SESSION['id']." ";
	$sql .= " OR Proprietaire IN ($amigass) ";
	$sql .= " ORDER BY Date DESC LIMIT 10 ";
	$resultat = $bdd->query($sql);

		while($diap=$resultat->fetch())
			{
				//$nom=
				if($diap['Proprietaire']==$mon_id){

					echo '<a class="image_lien" data-lightbox="diapo" data-title="'.$_SESSION['prenom'].''.$_SESSION['nom'].'|'.$diap['Titre'].' | '.$diap['Lieu'].' | '.$diap['Date'].'"  href="Images/'.$_SESSION['id'].'/'.$diap['Nom'].'"><img class="image_diapo" src="min/'.$_SESSION['id'].'/'.'mini'.'_'.''.$diap['Nom'].'"></a>';
				}
					
				else{
					echo '<a class="image_lien" data-lightbox="diapo"  data-title="'.$diap['Titre'].' | '.$diap['Lieu'].' | '.$diap['Date'].'" href="Images/'.$diap['Proprietaire'].'/'.$diap['Nom'].'"><img class="image_diapo" src="min/'.$diap['Proprietaire'].'/'.'mini'.'_'.''.$diap['Nom'].'"></a>';
				}
			}
				
}
function liste_amis($bdd){
	$amigos=array();
	$mon_id=$_SESSION['id'];
	$sql = "SELECT * FROM amis ";
	$sql .="WHERE (membre1_id ='$mon_id') OR (membre2_id ='$mon_id')";
	$resultat = $bdd->query($sql);
	while($amis=$resultat->fetch())
	{
		if($amis['membre1_id'] !=$mon_id)
			$amigos[]=$amis['membre1_id'];
		else if($amis['membre2_id'] !=$mon_id) 
			$amigos[]=$amis['membre2_id'];
	}
	return $amigos;
}
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
			
?>