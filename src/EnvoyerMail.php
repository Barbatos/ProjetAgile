<?php


/*
exemple:

$destinataire = $_POST['mail'];
$sujet = "sujet email";
$entetes = "From: no-reply@covoiturage.lol\n";
$entetes .= "MIME-Version: 1.0\n";
$entetes .= "Content-Type: text/html; charset=UTF-8\n";
$txt = "blabla";

mail($destinataire, $sujet, $txt, $entetes);
*/

// page annuler un trajet

if(est_connecte()){
$id = $_SESSION['id']


$subject='';
$message='';

$dns = 'mysql:host=barbatos.fr;dbname=agile';

	try{
		$co = new PDO($dns,'agile', '4g!l3');
	}
	
	catch (Exception $e){
        	die('Erreur : ' . $e->getMessage());
	}
	
$req ='select MAIL from TRAJET join UTILISATEUR using(ID_UTILISATEUR) 
where ID_TRAJET=(select ID_TRAJET from PASSAGER where ID_UTILISATEUR='.$_SESSION['id'].')';

$req = $co->query($req);
	$to = $req->fetchAll();
		echo $to;
		

}

?>
