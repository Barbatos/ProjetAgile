<?php 
	require_once('includes/init.php');
	
	if(!isset($_SESSION['id'])){
		header('Location: connexion.php');
	}
	else{
		$queryInsertAvert = $bdd->prepare('INSERT INTO DEMANDE (ID_UTILISATEUR,ID_VILLE_A,ID_VILLE_D,DATE_TRAJET) values(?,(select ID_VILLE from VILLE WHERE NOM_VILLE = ?),(select ID_VILLE from VILLE WHERE NOM_VILLE = ?),?);');
		$queryInsertAvert->execute(array($_SESSION['id'], $_GET['villeA'], $_GET['villeD'], $_GET['dateD']));
		header('Location: rechercheCovoiturage.php?averti');
	}
	
	