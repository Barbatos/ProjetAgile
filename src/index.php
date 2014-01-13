<?php 
require_once('includes/init.php');
require_once('templates/header.php');
?>

<form name="formulaire" action="" method="post" enctype="multipart/form-data">
	<h1> Accueil Site Co-Voiturage </h1>
	<br/>
	<fieldset>
	
		<a href="..." > <input type="button" value="Consulter les trajets disponibles"> </a>
		<a href="..." > <input type="button" value="Ajouter un trajet"> </a>
		<a href="..." > <input type="button" value="Gérer ses trajets"> </a>
	</fieldset>
	
	<fieldset>
		<input type="reset"/>
		<input name="valider1" type="submit"/>
	</fieldset>
</form>
  
<?php
require_once('templates/footer.php');
