<?php 
require_once('includes/init.php');

$pageActive = "";

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

	if(P('accepter') && P('utilisateur')){
		$stmt = $bdd->prepare('UPDATE PASSAGER SET DEMANDE_VALIDEE = :validation WHERE ID_UTILISATEUR = :user AND ID_TRAJET = :trajet');
		$stmt->bindValue(':validation', 1);
		$stmt->bindValue(':user', P('utilisateur'));
		$stmt->bindValue(':trajet', G('id'));
		$stmt->execute();
		$stmt->closeCursor();

		message_redirect('La demande de ce passager a bien été validée !', 'voirtrajet.php?id='.G('id'));
	}

	if(P('refuser') && P('utilisateur')){
		$stmt = $bdd->prepare('UPDATE PASSAGER SET DEMANDE_VALIDEE = :validation WHERE ID_UTILISATEUR = :user AND ID_TRAJET = :trajet');
		$stmt->bindValue(':validation', 2);
		$stmt->bindValue(':user', P('utilisateur'));
		$stmt->bindValue(':trajet', G('id'));
		$stmt->execute();
		$stmt->closeCursor();

		message_redirect('La demande de ce passager a bien été refusée !', 'voirtrajet.php?id='.G('id'));
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
$dataTrajet = $stmt->fetch(PDO::FETCH_OBJ);
$stmt->closeCursor();


if(est_connecte() && ($_SESSION['id'] != $dataTrajet->USERID)){
	if(!empty($dataTrajet->ID_TRAJET_RESERV)){
	
		$stmt = $bdd->prepare("SELECT count(*)  
								FROM `COMPTE` 
								WHERE id_utilisateur=:utilisateur 
								and `DATE_VALIDITE`>=sysdate();");
		$stmt->bindValue(':utilisateur', $_SESSION['id']);
		$stmt->execute();
		$data = $stmt->fetch();
		$stmt->closeCursor();
	
		if($data['count(*)']==0){
			message_redirect("Il faut enregistrer une carte pour s'inscrire au covoiturage !", "compte.php");
		}
	}
}

require_once('templates/header.php');
?>

<div id="titre"><strong>Informations sur le trajet <?php echo $dataTrajet->NOM_VILLE_D ?> -> <?php echo $dataTrajet->NOM_VILLE_A ?></strong></div><br />

<?php 
if($_SESSION['id'] == $dataTrajet->USERID){
	$stmt = $bdd->prepare('
		SELECT * FROM PASSAGER p
		LEFT JOIN UTILISATEUR u ON u.ID_UTILISATEUR = p.ID_UTILISATEUR
		WHERE ID_TRAJET = :trajet AND DEMANDE_VALIDEE = :valide');
	$stmt->bindValue(':trajet', G('id'));
	$stmt->bindValue(':valide', 0);
	$stmt->execute();
	$data = $stmt->fetchAll(PDO::FETCH_OBJ);
	$stmt->closeCursor();

	if($data){
	?>
		<h4>Vous avez des demandes en attente de confirmation !</h4>
	<div class="alert">
		<table class="table">
			<thead>
				<th>Prénom Nom</th>
				<th>Age</th>
				<th>Places demandées</th>
				<th>Validation</th>
			</thead>
			<tbody>
			<?php 
			foreach($data as $d){
			?>
			
			<tr>
				<td><?php echo $d->PRENOM . " " . $d->NOM ?></td>
				<td><?php echo (date('Y') - $d->DATENAISS_ANNEE) ?></td>
				<td>1</td>
				<td>
					<form name="validationConducteur" method="post">
						<input type="hidden" name="utilisateur" value="<?php echo $d->ID_UTILISATEUR ?>" />
						<input type="submit" name="refuser" value="Refuser" class="btn btn-danger" />
						<input type="submit" name="accepter" value="Accepter" class="btn btn-success" />
					</form>
				</td>
			</tr>
				
			<?php 
			}
			?>
			</tbody>
		</table>	
	</div>
	<?php	
	}

	$stmt = $bdd->prepare('
		SELECT * FROM PASSAGER p
		LEFT JOIN UTILISATEUR u ON u.ID_UTILISATEUR = p.ID_UTILISATEUR
		WHERE ID_TRAJET = :trajet AND DEMANDE_VALIDEE != :valide');
	$stmt->bindValue(':trajet', G('id'));
	$stmt->bindValue(':valide', 0);
	$stmt->execute();
	$data = $stmt->fetchAll(PDO::FETCH_OBJ);
	$stmt->closeCursor();

	if($data){
	?>
		<h4>Liste des demandes traitées :</h4>
	<div class="alert">
		<table class="table">
			<thead>
				<th>Prénom Nom</th>
				<th>Age</th>
				<th>Places demandées</th>
				<th>Validation</th>
			</thead>
			<tbody>
			<?php 
			foreach($data as $d){
			?>
			
			<tr>
				<td><?php echo $d->PRENOM . " " . $d->NOM ?></td>
				<td><?php echo (date('Y') - $d->DATENAISS_ANNEE) ?></td>
				<td>1</td>
				<td>
					<?php if($d->DEMANDE_VALIDEE == 1){ ?>
					<button name="acceptee" class="btn btn-success">Demande acceptée</button>
					<?php } elseif($d->DEMANDE_VALIDEE == 2){ ?>
					<button name="refusee" class="btn btn-danger">Demande refusée&nbsp;&nbsp;&nbsp;</button>
					<?php } ?>
				</td>
			</tr>
				
			<?php 
			}
			?>
			</tbody>
		</table>	
	</div>
	<?php	
	}

}
?>

Trajet ajouté <?php echo dateformat(strtotime($dataTrajet->DATE_AJOUT), 0) ?><br /><br />

Ville de départ : <?php echo $dataTrajet->NOM_VILLE_D ?><br />
Lieu de départ : <?php echo $dataTrajet->LIEUX_D ?><br /><br />

Ville d'arrivée : <?php echo $dataTrajet->NOM_VILLE_A ?><br />
Lieu d'arrivée : <?php echo $dataTrajet->LIEUX_A ?><br /><br />

Date de départ : <?php echo dateformat(strtotime($dataTrajet->DATE_TRAJET), 0) ?><br />
Heure de départ : <?php echo date('H\hi', strtotime($dataTrajet->DATE_TRAJET)) ?><br /><br />

Prix : <?php echo $dataTrajet->PRIX ?>€<br />
Nombre de places : <?php echo $dataTrajet->NB_PLACE ?><br /><br /><br />

Conducteur: <?php echo $dataTrajet->PRENOM ?> <?= $dataTrajet->NOM ?><br />
Age : <?php echo (date('Y') - $dataTrajet->DATENAISS_ANNEE) ?><br />

<br />	

<?php 
if(est_connecte() && ($_SESSION['id'] != $dataTrajet->USERID)){
	if(!empty($dataTrajet->ID_TRAJET_RESERV)){
	?>
		<input type="button" class="btn btn-large btn-warning" value="Demande de réservation confirmée. Attente de la validation du conducteur...">
	<?php 
	} else { 
	?>
	<form name="demanderPlace" method="post" action="">
		<input type="submit" class="btn btn-large btn-warning" name="demanderPlace" value="Demander une place">
	</form>
	<?php
	}
}
else if(!est_connecte()){
?>
	<p><a href="connexion.php" class="btn btn-success btn-medium" title="Se connecter">Se connecter pour réserver une place</a></p>
<?php 
}
?>

<?php 
require_once('templates/footer.php');
