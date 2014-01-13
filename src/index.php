<?php 
require_once('includes/init.php');

$pageActive = "Accueil";

require_once('templates/header.php');

$stmt = $bdd->prepare("SELECT tra.id_trajet, vi1.nom_ville as ville_d, vi2.nom_ville as ville_a,
							DATE_FORMAT(tra.date_trajet, '%d-%m-%Y') as date_tra
							FROM TRAJET tra 
							JOIN VILLE vi1 ON tra.id_ville_d = vi1.id_ville
							JOIN VILLE vi2 ON tra.id_ville_a = vi2.id_ville
							ORDER BY tra.date_trajet DESC LIMIT 10");
	$stmt->execute();
	$data = $stmt->fetchAll(PDO::FETCH_OBJ);
	$stmt->closeCursor();
?>

<form name="formulaire" action="" method="post" enctype="multipart/form-data">
	<div id="titre">
	<h1> Accueil Site Covoiturage </h1>
	</div>
	<br/>
	<fieldset>
		<legend> Derniers covoiturages proposés </legend>
		<select size="10">
		<?php
			foreach($data as $d)
			{
			
				$libelle = $d->ville_d." -> ".$d->ville_a." ".$d->date_tra;
			  echo '<option value="'.$d->id_trajet.'">'.$libelle;
			  echo '</option>';
			}
				
		?>
	</fieldset>
</form>
  
<?php
require_once('templates/footer.php');
?>
