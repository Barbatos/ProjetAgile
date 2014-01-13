<?php


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
	
	
	
		$villeD="";
		$villeA="";
		$lieuxA="";
		$lieuxD="";
		$date="";
		$heure="";
		$prix="";
		$nbplace="";
	
	
?>
<html>
	<head>
		<?php require_once('includes/init.php'); ?>
		<script type="text/javascript" src="js/calendrier.js"></script>
		<script type="text/javascript" src="js/pickHour.js"></script>	
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/design.css" />
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/heure_js.css" />
	</head>
	<body>
		<!-- Tableau obligatoire ! C'est lui qui contiendra le calendrier ! -->
		<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
			<tr>
				<td id="ds_calclass"></td>
			</tr>
		</table>
				
		<fieldset>
		<?php
					
				$stmt = $bdd->prepare("select id_ville,nom_ville from VILLE");
				$stmt->execute();
				$data = $stmt->fetchAll(PDO::FETCH_OBJ);
				$stmt->closeCursor();
				
		?>
		<!-- Les champs texte avec le code "onclick" déclenchant le script pour afiicher le calendrier-->
		Inscrire un nouveau covoiturage<br><br>
		<form name="formulaire" action="" method="post">
			<label for="VilleD">Ville de Départ :</label>
				<select id="villeD" name="villeD">
						<option value="1">Choisissez la ville départ</option>
						<?php
							foreach($data as $d)
							{
								echo '<option name="villeD" value="'.$d->id_ville.'">'.$d->nom_ville.'</option>';
							}
						?>
				</select><br>
			<label for="LieuxD">Lieux :</label><input type="text" name="lieuxD" value="<?php echo $lieuxD ?>" placeholder="Lieux de départ"/><br>
			<label for="VilleA">Ville d'Arrivée :</label>
				<select id="VilleA" name="VilleA">
					<option value="1">Choisissez la ville d'arrivée</option>
					<?php
							foreach($data as $d)
							{
							 echo '<option name="villeA" value="'.$d->id_ville.'">'.$d->nom_ville.'</option>';
							}
					?>
				</select><br>
			<label for="LieuxA">Lieux :</label><input type="text" name="lieuxA" value="<?php echo $lieuxA ?>" placeholder="Lieux de d'arrivée"/><br>
			<label for="NBplace">Nombre de places :</label><input type="text" name="nbplace" value="<?php echo $nbplace ?>" placeholder="nb de place dispo"/><br>
			<label for="Prix">Prix :</label><input type="text" name="prix" value="<?php echo $prix ?>" placeholder="Valeur Du trajet"/><br>
			<label for="Date">Date de Départ :</label><input type="text" name="date" name="date1" onclick="ds_sh(this);" /><br>
			<label for="Date">Heure :</label><input type="text" name="heure" class="hourPicker" /><br>
			<input type="submit"><input type="reset" name="reset" id="reset">
		</form>
		</fieldset>
		
		
	</body>
</html>


	
