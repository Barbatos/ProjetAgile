<?php 
require_once('includes/init.php');

$pageActive = "Connexion";

if(P()){
	if(P('identifiant') && P('mdp')){
		$stmt = $bdd->prepare("SELECT * FROM UTILISATEUR WHERE LOGIN = :login AND MDP = :password");
		$stmt->bindValue(':login', P('identifiant'));
		$stmt->bindValue(':password', sha1(P('mdp')));
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_OBJ);
		$stmt->closeCursor();

		if(!$data->LOGIN){
			message_redirect("Nom d'utilisateur ou mot de passe invalide.", "connexion.php");
		}
		else {
			$_SESSION['id'] = $data->ID_UTILISATEUR;
			$_SESSION['level'] = $data->ID_TYPE;

			message_redirect("Vous êtes maintenant connecté au site. :)", "index.php", 1);
		}
	}
	else {
		message_redirect("Il faut remplir tous les champs !", "connexion.php");
	}
}

require_once('templates/header.php');
?>

<form name="formulaire" action="" method="post" enctype="multipart/form-data">
	<div id="titre">
		<h1>Connexion au site</h1>
	</div>
	<br/>
	<fieldset>
		<legend>Connexion</legend>
		<label for="identifiant"> Identifiant : </label> <br/>
		<input id="identifiant" type="text" class="form-control" name="identifiant" placeholder="Votre nom d'utilisateur"><br/>
		<br/>
		<label for="mdp"> Mot de passe : </label> <br/>
		<input id="mdp" type="password" class="form-control" name="mdp" placeholder="Votre mot de passe"><br/>
		<br/>
	</fieldset>
	<div id="boutonEnvoyer">
		<fieldset>
			<input type="submit" class="btn btn-success btn-large" value="Connexion" />
		</fieldset>
	</div>
	<div id="autresBoutons">
		<a class="btn btn-small btn-info" href="mdpOublie.php">Mot de passe oublié</a>&nbsp;&nbsp;
		<a class="btn btn-small btn-info" href="inscription.php">Créer un compte</a>
	</div>
</form>

<?php
require_once('templates/footer.php');
