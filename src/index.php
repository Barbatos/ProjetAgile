<?php 
require_once('includes/init.php');
require_once('templates/header.php');
?>

<form name="formulaire" action="" method="post" enctype="multipart/form-data">
	<h1> Accueil Site Co-Voiturage </h1>
	<br/>
	<fieldset>
		
		<legend> Connexion</legend>
		<label> Identifiant : </label> <br/>
		<br/>
		<label> Mot de passe : </label> <br/>
		<br/>
		
		<a href="..." > <input type="button" value="Mot de passe oublié"> </a>
		<a href="..." > <input type="button" value="Créer un compte"> </a>
	</fieldset>
	
	<fieldset>
		<input type="reset"/>
		<input name="valider1" type="submit"/>
	</fieldset>
</form>
  
<?php
require_once('templates/footer.php');
