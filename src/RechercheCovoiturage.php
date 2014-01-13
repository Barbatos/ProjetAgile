<?php

$erreur = '';
$erreurBool = true;

if(!P('villeD')){
	$erreur += 'Vous n\'avez pas saisi une ville de depart.\n'; 
	$erreurBool = false;
}
if(!P('villeA')){
	$erreur += 'Vous n\'avez pas saisi une ville d\'arriver.\n';
	$erreurBool = false;
}
if(!P('date1')){
	$erreur += 'Vous n\'avez pas choisi de date de depart.\n';
	$erreurBool = false;
}
if(!P('heureD')){
	$erreur += 'Vous n\'avez pas choisi une heure.\n';
	$erreurBool = false;
}

$villeDepart = P('villeD');
$villeArriver = P('villeA');
$dateDepart = P('date1');
$heureDepart = P('villeD');

if($erreurBool && isset(P('rechercheCovoiturage'))){
	$query = $bdd->prepare("SELECT tr.*,d.nom_ville as villeDepart,a.nom_ville as villeArriver from TRAJET tr join VILLE a on a.id_ville = id_ville_a join VILLE d on d.id_ville = id_ville_d where id_ville_d=(select id_ville from VILLE where nom_ville=?) and id_ville_a=(select id_ville from VILLE where nom_ville=?) and date_trajet=?");
	
	$query->execute(array($villeDepart, $villeArriver, $dateDepart));
	$resultat = $query->fetchAll();
	$query->closeCursor();
}

if(isset(!P('rechercheCovoiturage')) && $erreurBool){
	require_once('rechercheCovoiturage.php');
}
else if(isset(P('rechercheCovoiturage'))){
	require_once('afficheTrajetRechercher.php');
}
