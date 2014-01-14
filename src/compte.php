<?php require_once('includes/init.php');

if(!est_connecte()){
	message_redirect('Vous devez être connecté pour voir cette page !', 'index.php');
}

if(P()){
	if(P('nom') || P('prenom')){
		if(P('nom') && P('prenom') && P('email') && P('tel')){
			$stmt = $bdd->prepare('UPDATE UTILISATEUR SET NOM = :nom, PRENOM = :prenom, MAIL = :email, TEL = :tel WHERE ID_UTILISATEUR = :id');
			$stmt->bindValue(':nom', P('nom'));
			$stmt->bindValue(':prenom', P('prenom'));
			$stmt->bindValue(':email', P('email'));
			$stmt->bindValue(':tel', P('tel'));
			$stmt->bindValue(':id', $_SESSION['id']);
			$stmt->execute();
			$stmt->closeCursor();

			message_redirect('Vos informations personnelles ont bien été modifiées', 'compte.php');
		}
		else {
			message_redirect('Vous devez renseigner tous les champs !', 'compte.php');
		}
	}

	if(P('ancienmdp') || P('nouveaumdp')){
		if(P('ancienmdp') && P('nouveaumdp') && P('nouveaumdp2')){
			if(P('nouveaumdp') != P('nouveaumdp2')){
				message_redirect('Les deux mots de passe ne correspondent pas !', 'compte.php');
			}

			$stmt = $bdd->prepare('SELECT MDP FROM UTILISATEUR WHERE ID_UTILISATEUR = :id');
			$stmt->bindValue(':id', $_SESSION['id']);
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_OBJ);
			$stmt->closeCursor();

			if($data->MDP != sha1(P('ancienmdp'))){
				message_redirect("L'ancien mot de passe ne correspond pas.", 'compte.php');
			}

			$stmt = $bdd->prepare('UPDATE UTILISATEUR SET MDP = :mdp WHERE ID_UTILISATEUR = :id');
			$stmt->bindValue(':mdp', sha1(P('nouveaumdp')));
			$stmt->bindValue(':id', $_SESSION['id']);
			$stmt->execute();
			$stmt->closeCursor();

			message_redirect('Le mot de passe a bien été changé !', 'compte.php');
		}
		else {
			message_redirect('Vous devez renseigner tous les champs !', 'compte.php');
		}
	}

	if(P('numcarte') || P('datecarte')){
		if(P('numcarte') && P('datecarte')){
			$mysqlDate = date('Y-m-d', P('datecarte'));
			$stmt = $bdd->prepare('UPDATE COMPTE SET NUMERO_CB = :numcb, DATE_VALIDITE = :dateval WHERE ID_UTILISATEUR = :id');
			$stmt->bindValue(':numcb', P('numcarte'));
			$stmt->bindValue(':dateval', $mysqlDate);
			$stmt->bindValue(':id', $_SESSION['id']);
			$stmt->execute();
			$stmt->closeCursor();

			message_redirect('Vos coordonnées bancaires ont bien été changées !', 'compte.php');
		}
		else {
			message_redirect('Vous devez renseigner tous les champs !', 'compte.php');
		}
	}
}

$pageActive = "Compte";

require_once('templates/header.php');

$stmt = $bdd->prepare("
	SELECT u.ID_UTILISATEUR, LOGIN, MDP, ID_TYPE, MAIL, TEL, NOM, PRENOM, DATENAISS_JOUR, DATENAISS_MOIS, DATENAISS_ANNEE, NUMERO_CB, DATE_VALIDITE 
	FROM UTILISATEUR u
	LEFT JOIN COMPTE c ON c.ID_UTILISATEUR = u.ID_UTILISATEUR 
	WHERE u.ID_UTILISATEUR = :utilisateur");
$stmt->bindValue(':utilisateur', $_SESSION['id']);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_OBJ);
$stmt->closeCursor();

?>
<script type="text/javascript" src="js/calendrier.js"></script>
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="css/design.css" />
<div id="titre"><h1>Mon compte</h1></div>

		<!-- Tableau obligatoire ! C'est lui qui contiendra le calendrier ! -->
		<table class="ds_box" cellpadding="0" cellspacing="0" id="ds_conclass" style="display: none;">
			<tr>
				<td id="ds_calclass"></td>
			</tr>
		</table>

	<form name="modifierInfosPerso" action="" method="post">
      <br>
	  <fieldset>
	  <legend><b>Modifier vos informations personnelles :</b></legend>
	  <label>Nom</label>
	  <div class="controls">
	  	<input type="text" class="form-control" name="nom" size="30" maxlength="256" value="<?php echo $data->NOM ?>">
	  </div><br/>
	  <label>Prénom</label>
	  <div class="controls">
	  	<input type="text" class="form-control" name="prenom" size="30" maxlength="256" value="<?php echo $data->PRENOM ?>">
	  </div><br/>
	  <label>Adresse e-mail</label>
	  <div class="controls">
	  	<input type="text" class="form-control" name="email" size="30" maxlength="256" value = "<?php echo $data->MAIL ?>">
	  </div><br/>
	  <label>Numéro de téléphone</label>
	  <div class="controls">
	  	<input type="text" class="form-control" name="tel" size="30" maxlength="256" value="<?php echo $data->TEL ?>">
	  </div><br/><br/>
	  
	  <input type="submit" name="modifier" class="btn btn-success" value="Modifier les informations personnelles"><br /><br /> 
	</form>

	<form name="modifierMdp" action="" method="post">
	  <legend><b>Modifier votre mot de passe</b></legend>
	  <label>Ancien mot de passe</label>
	  <div class="controls">
	  	<input type="password" class="form-control" name="ancienmdp" size="30" maxlength="256">
	  </div><br/>
	  <label>Nouveau mot de passe</label>
	  <div class="controls">
	  	<input type="password" class="form-control" name="nouveaumdp" size="30" maxlength="256">
	  </div><br/>
	  <label>Retaper nouveau mot de passe</label>
	  <div class="controls">
	  	<input type="password" class="form-control" name="nouveaumdp2" size="30" maxlength="256">
	  </div><br/><br />

	  <input type="submit" name="modifier" class="btn btn-success" value="Modifier le mot de passe"> <br /><br /> 
	</form>

	<form name="modifierCoordBancaires" action="" method="post">
	  <legend><b>Modifier vos coordonnees bancaire :</b></legend>
	  <label>Numéro carte bancaire</label>
	  <div class="controls">
	  	<input type="text" class="form-control" name="numcarte" size="30" maxlength="256" value="<?php echo $data->NUMERO_CB ?>">
	  </div><br/>
	  <label>Date validité</label>
	  <div class="controls">
	  	<input type="text" class="form-control" name="datecarte" size="30" maxlength="256" value="<?php echo $data->DATE_VALIDITE ?>" onclick="ds_sh(this);">
	  </div>
	  <br/><br/><br/>
	 
	  <input type="submit" name="modifier" class="btn btn-success" value="Modifier les coordonnées bancaires"> <br /><br /> 
    </form>

      </br>	   
	  </fieldset>
    </form>	
 
 
 <?php require_once('templates/footer.php');
