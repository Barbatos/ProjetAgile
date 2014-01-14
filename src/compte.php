<?php require_once('includes/init.php');
require_once('templates/header.php');
?>


<form name="modifierCompte" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      <br>
	  <fieldset>
	  <legend><b>Modifier votre compte :</b></legend>
	  Nom complet :<input type="text" name="nomcomplet" size="30" maxlength="256" value="NOM_COMPLET"><br/>
	  Nom d'utilisateur :<input type="text" name="login" size="30" maxlength="256" value="LOGIN"><br/>
	  Ancien mot de passe :<input type="password" name="ancienmdp" size="30" maxlength="256" value ="MDP"><br/>
	  Nouveau mot de passe : <input type="password" name="nouveaumdp" size="30" maxlength="256"><br/>
	  Retaper nouveau mot de passe : <input type="password" name="nouveaumdp2" size="30" maxlength="256"><br/>
	  Adresse e-mail :   <input type="text" name="email" size="30" maxlength="256" value = "MAIL"><br/>
	  Numero de telephone :   <input type="text" name="tel" size="30" maxlength="256" value="TEL"><br/><br/>
	
	<legend><b>Modifier vos coordonnees bancaire :</b></legend>
	   Numero carte bancaire :<input type="text" name="numcarte" size="30" maxlength="256" value="NUMERO_CB"><br/>
	   Date validite :<input type="text" name="datecarte" size="30" maxlength="256" value="DATE_VALIDITE"><br/><br/><br/>
	  
	  
	  <input type="submit" name="modifier" value="Valider les modifications"> 
      
      </br>	   
	  </fieldset>
    </form>	
	
	
 
 
 <?php require_once('templates/footer.php');
