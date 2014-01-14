<?php 
require_once('includes/init.php');

$pageActive = "";


require_once('templates/header.php');

?>

<div id="titre"><strong>Prevenir d'un retard </strong></div><br />

<form name="prevenirretard" method="post"/>

	<select id="trajetdemandee" name ="trajetdemandee">
	<option value=0>Choisissez le trajet</option>
	
	<?php 
	foreach($data as $d)
	{
			
		$libelle = $d->ville_d." -> ".$d->ville_a." ".$d->date_tra;
		echo '<option value="'.$d->id_trajet.'">'.$libelle;
		echo '</option>';
	}	
	?>

	Raison : <textarea name="Raison" cols = "100" rows = "20"/>
	Temps de retard : <input type="text" name="tmpderetard" />
	
	<input type="submit" name="prevenir" value="Prevenir" class="btn btn-success" />

</form>
		

<?php 
//require_once('templates/footer.php');
