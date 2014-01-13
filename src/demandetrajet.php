<!-- Formulaire demande de trajet  -->
<?php require_once('includes/init.php');
require_once('templates/header.php');
 ?>


<form name="demandeTrajet" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      <br>
	  <fieldset>
	  <legend><b>Demande de trajet :</b></legend><br>
	  Conducteur : <?php echo $nomconducteur; echo $prenomconducteur; ?><br>
	  Age : <?php echo $ageconducteur; ?><br>
	  Ville de depart : <?php echo $villedepart; ?><br>
	  Ville arrivee : <?php echo $villearrivee; ?><br>
	  Date de depart : <?php echo $datedepart; ?><br>
	  Heure de depart : <?php echo $heuredepart; ?><br>
	  Prix : <?php echo $prix; ?><br>
	  Nombre de place : <?php echo $nbplace; ?><br>
	  
	  <br><input type="submit" name="valider" value="Envoyer une demande"> 
	  <input type="button" name="annuler" value="Annuler"> 
      
      </br>	   
	  </fieldset>
    </form>	