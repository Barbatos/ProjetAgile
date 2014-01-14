<?php 
require_once('includes/init.php');

$pageActive = "Accueil";

require_once('templates/header.php');

$stmt = $bdd->prepare("
	SELECT tra.id_trajet, vi1.nom_ville as ville_d, vi2.nom_ville as ville_a, tra.prix, tra.date_trajet 
	FROM TRAJET tra 
	JOIN VILLE vi1 ON tra.id_ville_d = vi1.id_ville
	JOIN VILLE vi2 ON tra.id_ville_a = vi2.id_ville
	ORDER BY tra.date_trajet DESC LIMIT 10
");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_OBJ);
$stmt->closeCursor();
?>

<div id="titre"><h1>Bienvenue sur Covoiturage.lol</h1></div><br />

<legend>Derniers covoiturages proposés</legend>

<table class="table">
	<thead>
		<th>Ville de départ</th>
		<th>Ville d'arrivée</th>
		<th>Date</th>
		<th>Prix</th>
		<th>Places disponibles</th>
		<th>Action</th>
	</thead>
	<tbody>
		<?php 
		foreach($data as $d){
		?>
		<tr>
			<td><?php echo $d->ville_d ?></td>
			<td><?php echo $d->ville_a ?></td>
			<td><?php echo dateformat(strtotime($d->date_trajet)) ?></td>
			<td><?php echo $d->prix ?>€</td>
			<td>
				<?php 
				$nbPlacesDispo = compterPlacesDispo($d->id_trajet);
				if($nbPlacesDispo <= 0){
					$couleur = "red";
				} elseif($nbPlacesDispo > 0 && $nbPlacesDispo <= 2){
					$couleur = "orange";
				}
				else $couleur = "green";

				echo '<font color="'.$couleur.'">'.compterPlacesDispo($d->id_trajet).'</font>' ?>
			</td>
			<td><a href="voirtrajet.php?id=<?php echo $d->id_trajet ?>">Voir les informations</a></td>
		</tr>
		<?php 
		} 
		?>
	</tbody>
</table>
  
<?php
require_once('templates/footer.php');

