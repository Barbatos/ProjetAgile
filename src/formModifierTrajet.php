<!-- Formulaire modifierTrajet  -->

<form name="modifierTrajet" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      <br>
	  <fieldset>
	  <legend><b>Modifier votre trajet :</b></legend>
	  Ville de depart <input type="text" name="villedepart" size="30" maxlength="256" ><br/>
	  Ville arrivee <input type="text" name="villearrivee" size="30" maxlength="256"><br/>
	  Prix <input type="text" name="prix" size="30" maxlength="256"><br/>
	  Nombre de place   <input type="text" name="nbplace" size="30" maxlength="256"><br/>
	
	  
	  <input type="submit" name="valider" value="Valider"> 
      
      </br>	   
	  </fieldset>
    </form>	