<!-- Formulaire d'inscription  -->

<form name="inscription" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      <br>
	  <fieldset>
	  <legend><b>Inscription :</b></legend>
	  Nom <input type="text" name="nom" size="30" maxlength="256" ><br/>
	  Prenom <input type="text" name="prenom" size="30" maxlength="256"><br/>
	  Mot de passe <input type="text" name="motdepasse" size="30" maxlength="256"><br/>
	  Date de naissance  
	  <select name="jourNaiss" >
	  <?php
	  for ($i=1;$i<32;$i++) //Liste des jour de naissance
	  {echo '<option value="'.$i.'">'.$i.'';
	   echo '</option>';
	  }?></select>
	  
	  <select name="moisNaiss" >
	  <?php
	  for ($i=1;$i<13;$i++) //Liste des mois de naissance
	  {echo '<option value="'.$i.'">'.$i.'';
	   echo '</option>';
	  }?></select>
	  
	  <select name="anneeNaiss" >
	  <?php
	  for ($i=1900;$i<2014;$i++) //Liste des annees de naissance
	  {echo '<option value="'.$i.'">'.$i.'';
	   echo '</option>';
	  }?></select><br/>
	  
	  Adresse e-mail <input type="text" name="adresseMail" size="30" maxlength="256"><br/>
	  
	  <input type="submit" name="valider" value="Valider"> 
      
     
	  </fieldset>
    </form>	
	
