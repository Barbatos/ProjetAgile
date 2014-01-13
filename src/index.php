<?php 
require_once('includes/init.php');
require_once('templates/header.php');

$stmt = $bdd->prepare("SELECT id_trajet, nom_ville as ville_d, nom_ville as ville_a, tochar(date_trajet, 'DD/MM/YYYY') as date
							FROM TRAJET tra 
							JOIN VILLE vi1 ON tra.id_ville_d = vi1.id_ville
							JOIN VILLE vi2 ON tra.id_ville_a = vi2.id_ville
							WHERE ROWNUM < 10 ORDER BY tra.date_trajet asc");
	$stmt->execute();
	$data = $stmt->fetchAll(PDO::FETCH_OBJ);
	$stmt->closeCursor();
?>

<form name="formulaire" action="" method="post" enctype="multipart/form-data">
	<h1> Accueil Site Co-Voiturage </h1>
	<br/>
	<fieldset>
		<legend> Derniers co-voiturage proposés </legend>
		<select>
		<?php
			for ($i=0;$i < 10;$i++)
			{
			  echo '<option value="'.$data[$i]["id_trajet"].'">'.$data[$i]['ville_d'].' - '.$data[$i]['ville_a'].' '.$data[$i]['date'];
			  echo '</option>';
			}
				
		?>
	</fieldset>
</form>
  
<?php
require_once('templates/footer.php');
?>
