<?php
require_once('includes/init.php');
$erreur = '';
$erreurBool = true;

if(P('rechercheCovoiturage')){
	if(!P('villeD')){
		$erreur = $erreur .'Vous n\'avez pas saisi une ville de depart.<br/>'; 
		$erreurBool = false;
	}
	if(!P('villeA')){
		$erreur = $erreur.'Vous n\'avez pas saisi une ville d\'arriver.<br/>';
		$erreurBool = false;
	}
	if(!P('date1')){
	
		$erreur = $erreur.'Vous n\'avez pas choisi de date de depart.<br/>';
		$erreurBool = false;
	}
	if(!P('heureD')){
		$erreur = $erreur.'Vous n\'avez pas choisi une heure.<br/>';
		$erreurBool = false;
	}
}

$villeDepart = P('villeD');
$villeArriver = P('villeA');
$dateDepart = P('date1');
$heureDepart = P('heureD');

if($erreurBool && P('rechercheCovoiturage')){
	$jour=preg_replace('#/[0-9][0-9]/[0-9][0-9][0-9][0-9]#','',$dateDepart);
	$mois=preg_replace('#^[0-9][0-9]/#','',$dateDepart);
	$mois=preg_replace('#/[0-9][0-9][0-9][0-9]#','',$mois);
	$annee=preg_replace('#[0-9][0-9]/[0-9][0-9]/#','',$dateDepart);
	$date_trajet=$annee.'-'.$mois.'-'.$jour.' '.$heureDepart.':00';
	

	$query = $bdd->prepare("SELECT tr.*,d.nom_ville as villeDepart,a.nom_ville as villeArriver from TRAJET tr join VILLE a on a.id_ville = id_ville_a join VILLE d on d.id_ville = id_ville_d where id_ville_d in (select id_ville from VILLE where nom_ville = ?) and id_ville_a in (select id_ville from VILLE where nom_ville = ?) and date_trajet >= ?");
	
	$query->execute(array($villeDepart, $villeArriver, $date_trajet));
	$resultat = $query->fetchAll();
	$query->closeCursor();
}

	$pageActive = "Recherche";
	require_once('templates/header.php');
if(!P('rechercheCovoiturage') || !$erreurBool){
	$queryVille = $bdd->prepare("SELECT NOM_VILLE from VILLE order by NOM_VILLE");
	$queryVille->execute();
	$ville = $queryVille->fetchAll();
	$queryVille->closeCursor();
	
	?>
	

	<div id="titre"><h1>Recherche de covoiturage</h1></div>
	
	<?php 
	if(!$erreurBool){ ?>
	<div> <?php echo $erreur; ?></div>
	<?php }
	if(isset($_GET['averti'])){?>
		<div>Votre demande a bien etait pris en compte.</div>
	<?php }
	?>
	
	<!-- Tableau obligatoire ! C'est lui qui contiendra le calendrier ! -->
	<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
		<tr>
			<td id="ds_calclass"></td>
		</tr>
	</table>

	<form action="rechercheCovoiturage.php" method="POST">
		<fieldset>
		<label for="villeD">Ville de depart: </label><br/>
		<select name="villeD" id="villeD">
			<?php foreach($ville as $villeS){?>
					<option value="<?php echo $villeS['NOM_VILLE'];?>" ><?php echo $villeS['NOM_VILLE'];?></option>
			<?php }?>
		</select><br/><br/>

		<label for="villeA">Ville d'arrive: </label><br/>
		<select name="villeA" id="villeA">
			<?php foreach($ville as $villeS){?>
					<option value="<?php echo $villeS['NOM_VILLE'];?>" ><?php echo $villeS['NOM_VILLE'];?></option>
			<?php }?>
		</select><br/><br/>

		<label for="date1">Date de depart: </label><br/>
		<input type="text" name="date1" id="date1" onclick="ds_sh(this);" /><br/><br/>
		
		<label for="heureD">Heure de depart: </label><br/>
		<input type="text" class="hourPicker" id="heureD" name="heureD" /><br/><br/>

		<input type="submit" name="rechercheCovoiturage" value="Recherche"/><br/>
		</fieldset>
	</form>

	<script type="text/javascript" src="js/calendrier.js"></script>
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/design.css" />
	<link rel="stylesheet" type="text/css" href="css/heure_js.css" />
	<script type="text/javascript" src="js/pickHour.js"></script>
	<?php 
}
else if(P('rechercheCovoiturage')){

	require_once('afficheTrajetRechercher.php');
}

require_once('templates/footer.php');
