<?php 

$pageActive = "Recherche";

require_once('templates/header.php');
?>

<div id="titre"><h1>Recherche de covoiturage</h1></div>

<!-- Tableau obligatoire ! C'est lui qui contiendra le calendrier ! -->
<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
	<tr>
		<td id="ds_calclass"></td>
	</tr>
</table>

<form action="rechercheCovoiturage.php" method="POST">
	<fieldset>
	<legend></legend>
	<label for="villeD">Ville de depart: </label><br/>
	<input type="text" name="villeD" id="villeD"/><br/><br/>

	<label for="villeA">Ville d'arrive: </label><br/>
	<input type="text" name="villeA" id="villeA"/><br/><br/>

	<label for="date1">Date de depart: </label><br/>
	<input type="text" name="date1" id="date1" onclick="ds_sh(this);"/><br/><br/>
	
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

require_once('templates/footer.php');
?>