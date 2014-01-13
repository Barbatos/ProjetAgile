<?php

require_once('includes/init.php'); 

$villeD="";
$villeA="";
$lieuxA="";
$lieuxD="";
$date="";
$heure="";
$prix="";
$nbplace="";

	
if(isset($_POST['villeD'])){
	$prixvirgule = '/^[0-9]*,?[0-9]+$/';
	$prixpoint = '/^[0-9]*.?[0-9]+$/';
	$nbplacetest = '/^[0-9]*.?[0-9]+$/';
	$test=true;
	$erreur='';
	
	/**
	* Test si le prix est valide
	*/
	if (preg_match($prixvirgule,$_POST['prix'])||preg_match($prixpoint,$_POST['prix']))
		$prix=$_POST['prix'];
	else
		$test=false;
	/**
	* Test si le nombre de place est valide
	*/
	if (preg_match($nbplacetest,$_POST['nbplace']))
		$nbplace=$_POST['nbplace'];
	else
		$test=false;
	
	/**
	* Test si tous les champ sont remplits
	*/
	if(empty($_POST['prix']))
		$erreur+="Veuillez rentrée unprix pour le trajet";
	
	if(empty($_POST['nbplace']))
		$erreur+="Veuillez rentrée un nombre de place disponible";
	
	if(empty($_POST['villeD']))
		$erreur+="Veuillez rentrée une ville de départ";
	else
		
	if(empty($_POST['villeA']))
		$erreur+="Veuillez rentrée une ville de d'arrivée";
		
	if(empty($_POST['lieuxD']))
		$erreur+="Veuillez rentrée un lieux de départ";
	
	if(empty($_POST['lieuxA']))
		$erreur+="Veuillez rentrée un lieux de d'arrivée";
		
	if(empty($_POST['date']))
		$erreur+="Veuillez rentrée un date pour le trajet";
	
	if(empty($_POST['heure']))
		$erreur+="Veuillez rentrée l'heure de départ";

		
		
		
	if($erreur=""){
		$villeD=$_POST['villeD'];
		$villeA=$_POST['villeD'];
		$lieuxD=$_POST['lieuxD'];
		$lieuxA=$_POST['lieuxA'];
		$date=$_POST['date'];
		$heure=$_POST['heure'];
		$login="Administrateur";
		echo "insertion";
		//$stmt = $bdd -> prepare ("INSERT INTO trajet(id_trajet, id_utilisateur, id_ville_d, id_ville_a, prix, date_trajet, lieuxA,lieuxD, nb_place) VALUES('1','$login','$villeD','$villeA','$prix','$date','$lieuxA','$lieuxD', '$nbplace')")
		//$stmt->execute();
		//insertionTrajet($villeD,$villeA,$lieuxD,$lieuxA,$date,$heure);
	}else{
		
		echo $erreur;
	}
}
	
$pageActive = "Proposer";

require_once('templates/header.php');
?>

<div id="titre"><h1>Proposer un trajet</h1></div>

<!-- Tableau obligatoire ! C'est lui qui contiendra le calendrier ! -->
<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
	<tr>
		<td id="ds_calclass"></td>
	</tr>
</table>
	
<?php
$stmt = $bdd->prepare("select id_ville,nom_ville from VILLE");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_OBJ);
$stmt->closeCursor();
?>
<!-- Les champs texte avec le code "onclick" déclenchant le script pour afiicher le calendrier-->
<form name="formulaire" action="" method="post" class="form-horizontal">
	<legend>Proposer un nouveau covoiturage</legend>

	<div class="control-group">
		<label class="control-label" for="villeD">Ville de Départ</label>
		<div class="controls">
			<select id="villeD" name="villeD">
				<option value="">Choisissez la ville départ</option>
				<?php
				foreach($data as $d)
				{
					echo '<option value="'.$d->id_ville.'">'.$d->nom_ville.'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="LieuD">Lieu</label>
		<div class="controls">
			<input type="text" name="lieuxD" id="LieuD" value="<?php echo $lieuxD ?>" placeholder="Lieu de départ"/>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="VilleA">Ville d'Arrivée</label>
		<div class="controls">
			<select id="VilleA" name="VilleA" id="VilleA">
				<option value="">Choisissez la ville d'arrivée</option>
				<?php
				foreach($data as $d)
				{
				 echo '<option value="'.$d->id_ville.'">'.$d->nom_ville.'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="LieuA">Lieu</label>
		<div class="controls">
			<input type="text" name="lieuxA" id="LieuA" value="<?php echo $lieuxA ?>" placeholder="Lieu de d'arrivée"/>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="NBplace">Nombre de places</label>
		<div class="controls">
			<input type="text" name="nbplace" id="NBplace" value="<?php echo $nbplace ?>" placeholder="nb de place dispo"/>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="Prix">Prix</label>
		<div class="controls">
			<input type="text" name="prix" id="Prix" value="<?php echo $prix ?>" placeholder="Valeur Du trajet"/>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="Date">Date de Départ :</label>
		<div class="controls">
			<input type="text" name="date" name="date1" id="Date" onclick="ds_sh(this);" />
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="heure">Heure :</label>
		<div class="controls">
			<input type="text" name="heure" id="heure" class="hourPicker" />
		</div>
	</div>

	<br />
	<input type="reset" class="btn" name="reset" id="reset" value="Reset">&nbsp;&nbsp;<input class="btn btn-success btn-primary" type="submit" value="Proposer">
</form>
		
<?php 
require_once('templates/footer.php');
