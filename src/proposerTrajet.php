<?php

require_once('includes/init.php');

if(!est_connecte()){
	message_redirect("Vous devez être connecté pour voir cette page !", "index.php");
}

	
	$villeD="";
	$villeA="";
	$lieuxA="";
	$lieuxD="";
	$date="";
	$heure="";
	$prix="";
	$nbplace="";
	$erreur=' Insertion Imposible Cause :'.'<br>';
		
	if(isset($_POST['villeD'])){
		$prixvirgule = '/^[0-9]*,?[0-9]+$/';
		$prixpoint = '/^[0-9]*.?[0-9]+$/';
		$nbplacetest = '/^[0-9]*.?[0-9]+$/';
		$test=true;
		
		
		/**
		* Test si le prix est valide
		*/
		if (preg_match($prixvirgule,$_POST['prix'])||preg_match($prixpoint,$_POST['prix']))
			$prix=$_POST['prix'];
		else{
			$erreur=$erreur.' * Veuillez rentrée un prix valide'.'<br>';
			$test=false;
			$prix="";
		}
		/**
		* Test si le nombre de place est valide
		*/
		if (preg_match($nbplacetest,$_POST['nbplace']))
			$nbplace=$_POST['nbplace'];
		else{
			$erreur=$erreur.' * Veuillez rentrée un nb de place valide'.'<br>';
			$test=false;
			$nbplace="";			
		}
		
		/**
		* Test si tous les champ sont remplits
		*/
		if(empty($_POST['prix']))
			$erreur=$erreur.' * Veuillez rentrée un prix pour le trajet'.'<br>';
		else
			$prix=$_POST['prix'];
		
		if(empty($_POST['nbplace']))
			$erreur=$erreur.' * Veuillez rentrée un nombre de place disponible'.'<br>';
		else
			$nbplace=$_POST['nbplace'];
		
		if($_POST['villeD']=='0')
			$erreur=$erreur.' * Veuillez rentrée une ville de départ'.'<br>';		
			
		if($_POST['villeA']=='0')
			$erreur=$erreur.' * Veuillez rentrée une ville d\'arrivée'.'<br>';
			
		if(empty($_POST['lieuxD']))
			$erreur=$erreur.' * Veuillez rentrée un lieux de départ'.'<br>';
		else
			$lieuxD=$_POST['lieuxD'];
		
		if(empty($_POST['lieuxA']))
			$erreur=$erreur.' * Veuillez rentrée un lieux de d\'arrivée'.'<br>';
		else
			$lieuxA=$_POST['lieuxA'];
			
		if(empty($_POST['date']))
			$erreur=$erreur.' * Veuillez rentrée un date pour le trajet'.'<br>';
		
		if(empty($_POST['heure']))
			$erreur=$erreur.' * Veuillez rentrée l\'heure de départ'.'<br>';
			
		if($erreur==' Insertion Imposible Cause :'.'<br>'){
			$villeD=$_POST['villeD'];
			$villeA=$_POST['villeA'];
			$lieuxD=$_POST['lieuxD'];
			$lieuxA=$_POST['lieuxA'];
			$date=$_POST['date'];
			$heure=$_POST['heure'];
			$login="Administrateur";
			$jour=preg_replace('#/[0-9][0-9]/[0-9][0-9][0-9][0-9]#','',$date);
			$mois=preg_replace('#^[0-9][0-9]/#','',$date);
			$mois=preg_replace('#/[0-9][0-9][0-9][0-9]#','',$mois);
			$annee=preg_replace('#[0-9][0-9]/[0-9][0-9]/#','',$date);
			$date_trajet=$annee.'-'.$mois.'-'.$jour.' '.$heure.':00';
			$stmt = $bdd -> prepare ("INSERT INTO TRAJET(ID_VILLE_D, PRIX, DATE_TRAJET,ID_VILLE_A,ID_UTILISATEUR,LIEUX_D,NB_PLACE,LIEUX_A,NB_PLACE_OCCUPE) VALUES ('$villeD','$prix','$date_trajet','$villeA', '".$_SESSION['id']."','$lieuxD','$nbplace','$lieuxA','$nbplace')");
			$stmt->execute();
			header('location:index.php'); 
		}
	}
	
	if(isset($_POST['reset'])){
		$villeD="";
		$villeA="";
		$lieuxA="";
		$lieuxD="";
		$date="";
		$heure="";
		$prix="";
		$nbplace="";
	}
	
		$pageActive = "Proposer";
		require_once('templates/header.php');
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
		
		<form name="formulaire" action="" method="post">
		<div id="titre">
			<h1> Création d'un Trajet </h1>
		</div>
		<br/>
		<fieldset>
		<legend> Création</legend>
			<table>
			<tr><td>Ville de Départ :</td> <td>
				<select id="villeD" name="villeD">
						<option value='0'>Choisissez la ville départ</option>
						<?php
							foreach($data as $d)
							{
								echo '<option value="'.$d->id_ville.'">'.$d->nom_ville.'</option>';
							}
						?>
				</select><br>
			<tr><td>Lieux :</td> <td><input type="text" name="lieuxD" value="<?php echo $lieuxD ?>" placeholder="Lieux de départ"/><br>
			<tr><td>Ville d'Arrivée :</td> <td>
				<select id="villeA" name="villeA">
					<option value='0'>Choisissez la ville d'arrivée</option>
					<?php
							foreach($data as $d)
							{
							 echo '<option value="'.$d->id_ville.'">'.$d->nom_ville.'</option>';
							}
					?>
				</select><br>
			<tr><td>Lieux :</td> <td><input type="text" class="form-control input-normal" name="lieuxA" value="<?php echo $lieuxA ?>" placeholder="Lieux de d'arrivée"/><br>
			<tr><td>Nombre de places :</td> <td><input type="text" class="form-control input-normal" name="nbplace" value="<?php echo $nbplace ?>" placeholder="nb de place dispo"/><br>
			<tr><td>Prix :</td> <td><input type="text" name="prix" class="form-control input-normal" value="<?php echo $prix ?>" placeholder="Valeur Du trajet"/><br>
			<tr><td>Date de Départ :</td> <td><input type="text" class="form-control input-normal" name="date" name="date1" placeholder="Jour de Trajet"onclick="ds_sh(this);" /><br>
			<tr><td>Heure :</td> <td><input type="text" class="form-control input-normal" name="heure" placeholder="Heure Départ" class="hourPicker" /><br>
			</table><br><br>
			</fieldset>
			<fieldset>
			<input type="submit" class="btn btn-success btn-large" value="Envoyer">
			<input type="submit"  name="reset" class="btn btn-danger" value="Effacer">
			</fieldset>
		</form>
		
		
	</body>
</html>
<?php
if(!isset($_POST['reset'])){
	if($erreur!=' Insertion Imposible Cause :'.'<br>'){
		echo $erreur;
	}
}

require_once('templates/footer.php');



	
