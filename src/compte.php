<?php require_once('includes/init.php');

if(!est_connecte()){
	message_redirect('Vous devez être connecté pour voir cette page !', 'index.php');
}

if(P()){
	if(P('modifierInfosPerso')){
		if(P('nom') && P('prenom') && P('email') && P('tel')){
			$stmt = $bdd->prepare('UPDATE UTILISATEUR SET NOM = :nom, PRENOM = :prenom, MAIL = :email, TEL = :tel');
			$stmt->bindValue(':nom', P('nom'));
			$stmt->bindValue(':prenom', P('prenom'));
			$stmt->bindValue(':email', P('email'));
			$stmt->bindValue(':tel', P('tel'));
			$stmt->execute();
			$stmt->closeCursor();

			message_redirect('Vos informations personnelles ont bien été modifiées', 'compte.php');
		}
		else {
			message_redirect('Vous devez renseigner tous les champs !', 'compte.php');
		}
	}

	if(P('modifierMdp')){
		if(P('ancienmdp') && P('nouveaumdp') && P('nouveaumdp2')){
			if(P('nouveaumdp') != P('nouveaumdp2')){
				message_redirect('Les deux mots de passe ne correspondent pas !', 'compte.php');
			}

			$stmt = $bdd->prepare('SELECT MDP FROM UTILISATEUR WHERE ID_UTILISATEUR = :id');
			$stmt->bindValue(':id', $_SESSION['id']);
			$stmt->execute();
			$date = $stmt->fetch(PDO::FETCH_OBJ);
			$stmt->closeCursor();

			
		}
		else {
			message_redirect('Vous devez renseigner tous les champs !', 'compte.php');
		}
	}
}

$pageActive = "Compte";

require_once('templates/header.php');

$stmt = $bdd->prepare("
	SELECT u.ID_UTILISATEUR, LOGIN, MDP, ID_TYPE, MAIL, TEL, NOM, PRENOM, DATENAISS_JOUR, DATENAISS_MOIS, DATENAISS_ANNEE 
	FROM UTILISATEUR u
	LEFT JOIN COMPTE c ON c.ID_UTILISATEUR = u.ID_UTILISATEUR 
	WHERE u.ID_UTILISATEUR = :utilisateur");
$stmt->bindValue(':utilisateur', $_SESSION['id']);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_OBJ);
$stmt->closeCursor();

?>

<div id="titre"><h1>Mon compte</h1></div>

	<form name="modifierInfosPerso" action="" method="post">
      <br>
	  <fieldset>
	  <legend><b>Modifier vos informations personnelles :</b></legend>
	  <label>Nom</label>
	  <div class="controls">
	  	<input type="text" name="nom" size="30" maxlength="256" value="<?php echo $data->NOM ?>">
	  </div><br/>
	  <label>Prénom</label>
	  <div class="controls">
	  	<input type="text" name="prenom" size="30" maxlength="256" value="<?php echo $data->PRENOM ?>">
	  </div><br/>
	  <label>Adresse e-mail</label>
	  <div class="controls">
	  	<input type="text" name="email" size="30" maxlength="256" value = "<?php echo $data->MAIL ?>">
	  </div><br/>
	  <label>Numéro de téléphone</label>
	  <div class="controls">
	  	<input type="text" name="tel" size="30" maxlength="256" value="<?php echo $data->TEL ?>">
	  </div><br/><br/>
	  
	  <input type="submit" name="modifier" class="btn btn-success" value="Modifier les informations personnelles"><br /><br /> 
	</form>

	<form name="modifierMdp" action="" method="post">
	  <legend><b>Modifier votre mot de passe</b></legend>
	  <label>Ancien mot de passe</label>
	  <div class="controls">
	  	<input type="password" name="ancienmdp" size="30" maxlength="256">
	  </div><br/>
	  <label>Nouveau mot de passe</label>
	  <div class="controls">
	  	<input type="password" name="nouveaumdp" size="30" maxlength="256">
	  </div><br/>
	  <label>Retaper nouveau mot de passe</label>
	  <div class="controls">
	  	<input type="password" name="nouveaumdp2" size="30" maxlength="256">
	  </div><br/><br />

	  <input type="submit" name="modifier" class="btn btn-success" value="Modifier le mot de passe"> <br /><br /> 
	</form>

	<form name="modifierCoordBancaires" action="" method="post">
	  <legend><b>Modifier vos coordonnees bancaire :</b></legend>
	  <label>Numero carte bancaire</label>
	  <div class="controls">
	  	<input type="text" name="numcarte" size="30" maxlength="256" value="<?php echo $data->NUMERO_CB ?>">
	  </div><br/>
	  <label>Date validite</label>
	  <div class="controls">
	  	<input type="text" name="datecarte" size="30" maxlength="256" value="<?php echo $data->DATE_VALIDITE ?>">
	  </div>
	  <br/><br/><br/>
	 
	  <input type="submit" name="modifier" class="btn btn-success" value="Modifier les coordonnées bancaires"> <br /><br /> 
    </form>

      </br>	   
	  </fieldset>
    </form>	
	
	
 
 
 <?php require_once('templates/footer.php');
