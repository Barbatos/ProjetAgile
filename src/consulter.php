<?php 
require_once('includes/init.php');
require_once('templates/header.php');
?>
<form name="formulaire" action="" method="post" enctype="multipart/form-data">
	<h1>Co-Voiturage : Consulter les trajets</h1>
	<br/>
	<fieldset>
		
		<legend> Trajets :</legend>
		<select name="Id_trajet" size="1">
					<?php
						//Insertion de la liste
					?> 
				</select>
		<br/>
	</fieldset>
	
	<fieldset>
		<input type="reset"/>
		<input name="demande" type="submit"/>
	</fieldset>
</form>

<?php
require_once('templates/footer.php');
