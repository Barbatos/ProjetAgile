<?php 
require_once('includes/init.php');

if(P()){
	if(P('nom') && P('prenom') && P('motdepasse') && P('tel') && P('adresseMail') && P('jourNaiss') && P('moisNaiss') && P('anneeNaiss')){
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
			message_redirect("Votre inscription est terminée ! Vous pouvez maintenant vous connecter au site.", "connexion.php", 1);
		}
		else {
			message_redirect("Une erreur s'est produite lors de l'inscription. Veuillez réessayer.", "inscription.php");
		}

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
  	<legend><b>Inscription :</b></legend>
  	Nom d'utilisateur: <input type="text" name="login" size="30" maxlength="30"><br />
  	Mot de passe: <input type="password" name="motdepasse" size="30" maxlength="256"><br/><br />

  	Nom: <input type="text" name="nom" size="30" maxlength="256" ><br/>
  	Prénom: <input type="text" name="prenom" size="30" maxlength="256"><br/><br />

  	Numéro de téléphone: <input type="text" name="tel" size="20" maxlength="20"><br />
  	Adresse e-mail: <input type="text" name="adresseMail" size="30" maxlength="256"><br/>
  	Date de naissance: 
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
  	</select><br/>
  
  	<input type="submit" name="valider" value="Valider"> 
  
  	</fieldset>
</form>	
	
<?php
require_once('templates/footer.php');
