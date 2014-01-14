<?php require_once('includes/init.php');

if(!est_connecte()){
	message_redirect('Vous devez être connecté pour voir cette page !', 'index.php');
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

<form name="modifierCompte" action="" method="post">
      <br>
	  <fieldset>
	  <legend><b>Modifier votre compte :</b></legend>
	  Nom :<input type="text" name="nom" size="30" maxlength="256" value="<?php echo $data->NOM ?>"><br/>
	  Prénom :<input type="text" name="nomcomplet" size="30" maxlength="256" value="<?php echo $data->PRENOM ?>"><br/>
	  Ancien mot de passe :<input type="password" name="ancienmdp" size="30" maxlength="256"><br/>
	  Nouveau mot de passe : <input type="password" name="nouveaumdp" size="30" maxlength="256"><br/>
	  Retaper nouveau mot de passe : <input type="password" name="nouveaumdp2" size="30" maxlength="256"><br/>
	  Adresse e-mail :   <input type="text" name="email" size="30" maxlength="256" value = "<?php echo $data->MAIL ?>"><br/>
	  Numero de telephone :   <input type="text" name="tel" size="30" maxlength="256" value="<?php echo $data->TEL ?>"><br/><br/>
	
	<legend><b>Modifier vos coordonnees bancaire :</b></legend>
	   Numero carte bancaire :<input type="text" name="numcarte" size="30" maxlength="256" value="<?php echo $data->NUMERO_CB ?>"><br/>
	   Date validite :<input type="text" name="datecarte" size="30" maxlength="256" value="<?php echo $data->DATE_VALIDITE?>"><br/><br/><br/>
	  
	  
	  <input type="submit" name="modifier" value="Valider les modifications"> 
      
      </br>	   
	  </fieldset>
    </form>	
	
	
 
 
 <?php require_once('templates/footer.php');
