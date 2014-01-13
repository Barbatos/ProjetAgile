<<<<<<< HEAD
<?php
=======
<?php 
require_once('includes/init.php');
require_once('templates/header.php');
?>
<!-- Tableau obligatoire ! C'est lui qui contiendra le calendrier ! -->
<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
	<tr>
		<td id="ds_calclass"></td>
	</tr>
</table>

<?php 
if(isset(!P('rechercheCovoiturage')) && $erreurBool){ ?>
<div>
	<?php echo $erreur; ?>
</div>
<?php } 

function isErreur($value){
	if($erreurBool){
		switch($value){
			case 'villeD':{ echo 'value="'. $villeDepart.'"';}break;
			case 'villeA':{echo 'value="'. $villeArriver.'"';}break;
			case 'date1':{echo 'value="'. $dateDepart.'"';}break;
			case 'heureD':{echo 'value="'. $heureDepart.'"';}break;
		}
	}
} ?>



<form action="rechercheCovoiturage.php" methode="POST">
	<fieldset>
	<legend>Recherche de covoiturage</legend>
	<label for="villeD">Ville de depart: </label><br/>
	<input type="text" name="villeD" id="villeD" <?php isErreur('villeD'); ?> /><br/><br/>

	<label for="villeA">Ville d'arrive: </label><br/>
	<input type="text" name="villeA" id="villeA" <?php isErreur('villeA'); ?> /><br/><br/>
>>>>>>> 099d1c42c3d21fdcd4f6693cb9dfbe783a47b4a1

$erreur = '';

if(!P('villeD'))
	$erreur += 'Vous n\'avez pas saisi une ville de depart.\n'; 
if(!P('villeA'))
	$erreur += 'Vous n\'avez pas saisi une ville d\'arriver.\n';
if(!P('date1'))
	$erreur += 'Vous n\'avez pas choisi de date de depart.\n';
if(!P('heureD'))
	$erreur += 'Vous n\'avez pas choisi une heure.\n';

$villeDepart = P('villeD');
$villeArriver = P('villeA');
$dateDepart = P('date1');
$heureDepart = P('villeD');

if(empty($erreur)){
	$query = $bdd->prepare("select dictinct id_trajet, vA.nom_ville as villeArriver, vD.nom_ville as villeDepart, prix, date_trajet, nb_place, nb_place_occupe 
	from trajet tra 
	join ville vA join ville vD 
	where tra.id_ville_d = vA.id_ville 
	and tra.id_ville = vD.id_ville_a 
	and date_trajet = to_date(?, 'yyyy-mm-dd')
	order by date_trajet");
	
	$query->execute(array($villeDepart, $villeArriver, $dateDepart));
	$resultat = $query->fetchAll();
	$query->closeCursor();
}

if(isset(!P('rechercheCovoiturage')) && empty($erreur)){
	require_once('rechercheCovoiturage.php');
}
else if(isset(P('rechercheCovoiturage'))){
	require_once('afficheTrajetRechercher.php');
}
