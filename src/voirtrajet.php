<?php 
require_once('includes/init.php');

if(!G('id')){
	message_redirect("L'adresse URL est incorrecte !", "index.php");
}

if(P()){
	if(P('demanderPlace')){
		$stmt = $bdd->prepare("SELECT * FROM PASSAGER WHERE ID_TRAJET = :trajet AND ID_UTILISATEUR = :utilisateur");
		$stmt->bindValue(':trajet', G('id'));
		$stmt->bindValue(':utilisateur', $_SESSION['id']);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_OBJ);
		$stmt->closeCursor();

		if($data->ID_UTILISATEUR){
			message_redirect("Vous avez déjà demandé une place pour ce trajet !", "voirtrajet.php?id=".G('id'), 1);
		}
		else {
			$stmt = $bdd->prepare("INSERT INTO PASSAGER (ID_TRAJET, ID_UTILISATEUR) VALUES (:trajet, :user)");
			$stmt->bindValue(':trajet', G('id'));
			$stmt->bindValue(':user', $_SESSION['id']);
			if($stmt->execute()){
				message_redirect("Vous avez bien effectué une demande de réservation de place ! Vous devez maintenant attendre la réponse du conducteur.", "voirtrajet.php?id=".G('id'));
			}
			else {
				message_redirect("Une erreur s'est produite lors de la tentative de réservation. Merci de réessayer.", "voirtrajet.php?id=".G('id'), 1);
			}
			$stmt->closeCursor();
		}
	}
}

$stmt = $bdd->prepare("
	SELECT t.*, u.*, v1.NOM_VILLE AS NOM_VILLE_D, v2.NOM_VILLE AS NOM_VILLE_A, p.ID_TRAJET AS ID_TRAJET_RESERV, t.ID_UTILISATEUR AS USERID 
	FROM TRAJET t
	LEFT JOIN VILLE v1 ON v1.ID_VILLE = t.ID_VILLE_D
	LEFT JOIN VILLE v2 ON v2.ID_VILLE = t.ID_VILLE_A
	LEFT JOIN UTILISATEUR u ON u.ID_UTILISATEUR = t.ID_UTILISATEUR
	LEFT JOIN PASSAGER p ON p.ID_TRAJET = t.ID_TRAJET AND p.ID_UTILISATEUR = :utilisateur
	WHERE t.ID_TRAJET = :id
");
$stmt->bindValue(':id', G('id'));
$stmt->bindValue(':utilisateur', $_SESSION['id']);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_OBJ);
$stmt->closeCursor();

require_once('templates/header.php');
?>

<div id="titre"><strong>Informations sur le trajet <?= $data->NOM_VILLE_D ?> -> <?= $data->NOM_VILLE_A ?></strong></div><br />

Trajet ajouté le <?= date('d/m/Y à H\hi', strtotime($data->DATE_AJOUT)) ?><br /><br />

Ville de départ : <?= $data->NOM_VILLE_D ?><br />
Lieu de départ : <?= $data->LIEUX_D ?><br /><br />

Ville d'arrivée : <?= $data->NOM_VILLE_A ?><br />
Lieu d'arrivée : <?= $data->LIEUX_A ?><br /><br />

Date de départ : <?= date('d/m/Y', strtotime($data->DATE_TRAJET)) ?><br />
Heure de départ : <?= date('H\hi', strtotime($data->DATE_TRAJET)) ?><br /><br />

Prix : <?= $data->PRIX ?>€<br />
Nombre de places : <?= $data->NB_PLACE ?><br /><br /><br />

Conducteur: <?= $data->PRENOM ?> <?= $data->NOM ?><br />
Age : <?= (date('Y') - $data->DATENAISS_ANNEE) ?><br />

<br />	

<?php 
if(est_connecte() && ($_SESSION['id'] != $data->USERID)){
	if(!empty($data->ID_TRAJET_RESERV)){
	?>
		<input type="button" class="btn large" value="Demande de réservation confirmée. Attente de la validation du conducteur...">
	<?php 
	} else { 
	?>
	<form name="demanderPlace" method="post" action="">
		<input type="submit" class="btn large" name="demanderPlace" value="Demander une place">
	</form>
	<?php
	}
}
else if(!est_connecte()){
?>
	<p><a href="connexion.php" title="Se connecter">Se connecter pour réserver une place</a></p>
<?php 
}
?>

<?php 
require_once('templates/footer.php');
