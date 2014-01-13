<?php 
require_once('includes/init.php');
require_once('templates/header.php');
?>

<form name="inscription" action="" method="post">
	<br>
	<fieldset>
		<legend><b>Inscription :</b></legend>
		Nom: 	<input type="text" name="nom" size="30" maxlength="30" ><br />
		Prénom: <input type="text" name="prenom" size="30" maxlength="30"><br />
		Adresse e-mail: <input type="text" name="adresseMail" size="30" maxlength="256"><br />
		Mot de passe: <input type="text" name="motdepasse" size="30" maxlength="30"><br />
		Année de naissance 
		<select name="anneeNaiss">
			<?php
			for ($i = 1900; $i < 2014; $i++) 
			{
			echo '<option value="'.$i.'">'.$i.'</option>';
			}
			?>
		</select>
		<br />
		  
		<input type="submit" name="valider" value="Valider"> 

	</fieldset>
</form>	
	
<?php
require_once('templates/footer.php');
