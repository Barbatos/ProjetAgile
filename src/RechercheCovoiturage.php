<?php

$erreur = '';

if(!P('villeD'))
	$erreur += 'Vous n\'avez pas saisi une ville de depart.\n'; 
if(!P('villeA'))
	$erreur += 'Vous n\'avez pas saisi une ville d\'arriver.\n';
if(!P('date1'))
	$erreur += 'Vous n\'avez pas choisi de date de depart.\n';
if(!P('heureD'))
	$erreur += 'Vous n\'avez pas choisi une heure.\n';

$villeDepart = P('villeD');
$villeArriver = P('villeA');
$dateDepart = P('date1');
$heureDepart = P('villeD');

if(empty($erreur)){
	$query = $bdd->prepare("select dictinct id_trajet, vA.nom_ville as villeArriver, vD.nom_ville as villeDepart, prix, date_trajet, nb_place, nb_place_occupe 
	from trajet tra 
	join ville vA join ville vD 
	where tra.id_ville_d = vA.id_ville 
	and tra.id_ville = vD.id_ville_a 
	and date_trajet = to_date(?, 'yyyy-mm-dd')
	order by date_trajet");
	
	$query->execute(array($villeDepart, $villeArriver, $dateDepart));
	$resultat = $query->fetchAll();
	$query->closeCursor();
}

if(isset(!P('rechercheCovoiturage')) && empty($erreur)){
	require_once('rechercheCovoiturage.php');
}
else if(isset(P('rechercheCovoiturage'))){
	require_once('afficheTrajetRechercher.php');
}
