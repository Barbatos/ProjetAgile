<?php require_once('includes/init.php');

$pageActive = "Compte";

require_once('templates/header.php');

$stmt = $bdd->prepare("SELECT login, mdp, mail, tel, nom_complet, numero_cb, date_validite from utilisateur join compte using (id_utilisateur) where id_utilisateur = :utilisateur");
$stmt->bindValue(':utilisateur', $_SESSION['id']);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_OBJ);
$stmt->closeCursor();

?>


<form name="modifierCompte" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      <br>
	  <fieldset>
	  <legend><b>Modifier votre compte :</b></legend>
	  Nom complet :<input type="text" name="nomcomplet" size="30" maxlength="256" value="<?php $data->NOM_COMPLET ?>"><br/>
	  Nom d'utilisateur :<input type="text" name="login" size="30" maxlength="256" value="<?php $data->LOGIN ?>"><br/>
	  Ancien mot de passe :<input type="password" name="ancienmdp" size="30" maxlength="256" value ="<?php $data->MDP ?>"><br/>
	  Nouveau mot de passe : <input type="password" name="nouveaumdp" size="30" maxlength="256"><br/>
	  Retaper nouveau mot de passe : <input type="password" name="nouveaumdp2" size="30" maxlength="256"><br/>
	  Adresse e-mail :   <input type="text" name="email" size="30" maxlength="256" value = "<?php $data->MAIL ?>"><br/>
	  Numero de telephone :   <input type="text" name="tel" size="30" maxlength="256" value="<?php $data->TEL ?>"><br/><br/>
	
	<legend><b>Modifier vos coordonnees bancaire :</b></legend>
	   Numero carte bancaire :<input type="text" name="numcarte" size="30" maxlength="256" value="<?php $data->NUMERO_CB ?>"><br/>
	   Date validite :<input type="text" name="datecarte" size="30" maxlength="256" value="<?php $data->DATE_VALIDITE?>"><br/><br/><br/>
	  
	  
	  <input type="submit" name="modifier" value="Valider les modifications"> 
      
      </br>	   
	  </fieldset>
    </form>	
	
	
 
 
 <?php require_once('templates/footer.php');
