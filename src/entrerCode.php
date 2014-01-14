<?php 
require_once('includes/init.php');
$pageActive = "EntrerCode";

require_once('templates/header.php');
?>
<form name="formulaire" action="" method="post" enctype="multipart/form-data">
	<div id="titre">
	<h1>Co-Voiturage : Entrer un code Co-Voiturage</h1>
	</div>
	<br/>
	<fieldset>
		<legend> Code : </legend>
		<label for id="code"> Entrez le code : </label>
		<input id="code" type="text" name="code" />
		<br/>
		<input type="reset"/>
		<input name="demande" type="submit"/>
	</fieldset>
</form>