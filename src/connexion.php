<?php 
require_once('includes/init.php');

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
	<h1> Connexion site Covoiturage </h1>
	</div>
	<br/>
	<fieldset>
		<legend> Connexion</legend>
		<label for="identifiant"> Identifiant : </label> <br/>
		<input id="identifiant" type="text" name="identifiant" placeholder="Votre nom d'utilisateur"><br/>
		<br/>
		<label for="mdp"> Mot de passe : </label> <br/>
		<input id="mdp" type="password" name="mdp" placeholder="Votre mot de passe"><br/>
		<br/>
		
		<button class="btn btn-primary">Mot de passe oublié</button>
		<button class="btn btn-primary">Créer un compte</button>
	</fieldset>
	<div id="boutonfin">
	<fieldset>
		<button class="btn btn-danger">Effacer</button>
		<input type="submit" class="btn btn-success btn-large" value="Envoyer"/>
	</fieldset>
	</div>
</form>

<?php
require_once('templates/footer.php');
