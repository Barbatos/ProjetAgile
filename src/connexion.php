<?php 
require_once('includes/init.php');
require_once('templates/header.php');
?>
<form name="formulaire" action="" method="post" enctype="multipart/form-data">
	<h1> Connexion site Co-Voiturage </h1>
	<br/>
	<fieldset>
		
		<legend> Connexion</legend>
		<label for="identifiant"> Identifiant : </label> <br/>
		<input id="identifiant" type="text" name="identifiant" placeholder="Votre nom d'utilisateur"><br/>
		<br/>
		<label for="mdp"> Mot de passe : </label> <br/>
		<input id="mdp" type="password" name="mdp" placeholder="Votre mot de passe"><br/>
		<br/>
		
		<a href="..." > <input type="button" value="Mot de passe oublié"> </a>
		<a href="..." > <input type="button" value="Créer un compte"> </a>
	</fieldset>
	
	<fieldset>
		<input type="reset"/>
		<input name="valider" type="submit"/>
	</fieldset>
</form>

<?php
require_once('templates/footer.php');
