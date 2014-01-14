<?php 
require_once('includes/init.php');

$pageActive = "Inscription";

if(P()){
	if(P('nom') && P('prenom') && P('motdepasse') && P('tel') && P('adresseMail') && P('jourNaiss') && P('moisNaiss') && P('anneeNaiss')){
		
		$stmt = $bdd->prepare("SELECT count(*) FROM UTILISATEUR WHERE NOM = :nom");
		$stmt->bindValue(':nom', P('nom'));
		$stmt->execute();
		$nb = $stmt->fetch(PDO::FETCH_OBJ);
		
		if($nb <= 0)
		{
			$stmt = $bdd->prepare("
				INSERT INTO UTILISATEUR (LOGIN, MDP, NOM, PRENOM, ID_TYPE, MAIL, TEL, DATENAISS_JOUR, DATENAISS_MOIS, DATENAISS_ANNEE) 
				VALUES 
				(:login, :mdp, :nom, :prenom, :type, :mail, :tel, :jour, :mois, :annee)
			");
			$stmt->bindValue(':login', P('login'));
			$stmt->bindValue(':mdp', sha1(P('motdepasse')));
			$stmt->bindValue(':type', 1);
			$stmt->bindValue(':mail', P('adresseMail'));
			$stmt->bindValue(':tel', P('tel'));
			$stmt->bindValue(':nom', P('nom'));
			$stmt->bindValue(':prenom', P('prenom'));
			$stmt->bindValue(':jour', P('jourNaiss'));
			$stmt->bindValue(':mois', P('moisNaiss'));
			$stmt->bindValue(':annee', P('anneeNaiss'));

			if($stmt->execute()){
				$stmt = $bdd->prepare('INSERT INTO COMPTE (ID_UTILISATEUR) VALUE (:id)');
				$stmt->bindValue(':id', $bdd->lastInsertId());
				$stmt->execute();
				$stmt->closeCursor();

				message_redirect("Votre inscription est terminée ! Vous pouvez maintenant vous connecter au site.", "connexion.php", 1);
			}
			else {
				message_redirect("Une erreur s'est produite lors de l'inscription. Veuillez réessayer.", "inscription.php");
			}
		}
		else message_redirect("Nom déjà utilisé", "inscription.php");

		$stmt->closeCursor();
	}
	else {
		message_redirect("Il faut remplir tous les champs !", 'inscription.php');
	}
}

require_once('templates/header.php');

?>

<form name="inscription" action="" method="post">
  	<br>
  	<fieldset>
	<div id="legend">
  	<legend><b>Inscription :</b></legend>
	</div>
	<div id = "inscription">
	<table>
	<tr><td>Nom d'utilisateur:</td> <td><input type="text" class="form-control" name="login" size="30" maxlength="30"></td></tr>	
	
	<tr><td>Mot de passe: </td><td><input type="password" class="form-control" name="motdepasse" size="30" maxlength="256"></td></tr>	
	
  	<tr><td>Nom:</td> <td> <input type="text" class="form-control" name="nom" size="30" maxlength="256" ></td></tr><br/>
  	
	<tr><td>Prénom:</td> <td> <input type="text" class="form-control" name="prenom" size="30" maxlength="256"></td></tr>
	
  	<tr><td>Numéro de téléphone: </td> <td><input type="text" class="form-control" name="tel" size="20" maxlength="20"></td></tr>
  	
	<tr><td>Adresse e-mail: </td> <td><input type="text" class="form-control" name="adresseMail" size="30" maxlength="256"></td></tr>
  
	<tr><td>Date de naissance: </td> <td>
  	<select name="jourNaiss" >
  	<?php
  	for ($i = 1; $i < 32; $i++) //Liste des jour de naissance
  	{
  		echo '<option value="'.$i.'">'.$i.'</option>';
  	}
  	?>
  	</select>
  
  	<select name="moisNaiss" >
  	<?php
  	for ($i = 1;$i < 13; $i++) //Liste des mois de naissance
  	{
  		echo '<option value="'.$i.'">'.$i.'</option>';
  	}
  	?>
  	</select>
  
  	<select name="anneeNaiss" >
  	<?php
  	for ($i = 1900;$i < 2014; $i++) //Liste des annees de naissance
  	{
  		echo '<option value="'.$i.'">'.$i.'</option>';
  	}?>
  	</select></td></tr><br/>
	</table>
	</div>
	<div id = "boutonEnvoyer">
  	<input type="submit" class="btn btn-success btn-large" value="Valider"/>
	</div>
  	</fieldset>
</form>	
	
<?php
require_once('templates/footer.php');
