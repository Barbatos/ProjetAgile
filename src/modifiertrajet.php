<!-- Formulaire modifierTrajet  -->
<?php 
require_once('includes/init.php');
require_once('templates/header.php');

if(isset($_POST)){
	if(P('villedepart') && P('villearrivee') && P('datetrajet') && P('prix') && P('nbplace')){
		$stmt = $bdd->prepare("
			UPDATE TRAJET SET ID_VILLE_D = "P('villedepart')", PRIX = "P('prix')", DATE_TRAJET = "P('datetrajet')",ID_VILLE_A = 				"P('villearrivee')", ID_UTILISATEUR = ....., LIEUX = ....., NB_PLACE = "P('nbplace')";");
		$stmt->execute();
		$stmt->closeCursor();
	}
}

?>



<form name="modifierTrajet" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      <br>
	  <fieldset>
	  <legend><b>Modifier votre trajet :</b></legend>
	  Ville de depart <input type="text" name="villedepart" size="30" maxlength="256" ><br/>
	  Ville arrivee <input type="text" name="villearrivee" size="30" maxlength="256"><br/>
	  Date du trajet <input type="date" name="datetrajet" size="30" maxlength="256"><br/>
	  Prix <input type="text" name="prix" size="30" maxlength="256"><br/>
	  Nombre de place   <input type="text" name="nbplace" size="30" maxlength="256"><br/>
	
	  
	  <input type="submit" name="valider" value="Valider"> 
      
      </br>	   
	  </fieldset>
    </form>
<?php
require_once('templates/footer.php');	
