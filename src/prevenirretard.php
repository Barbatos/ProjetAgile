<?php 
require_once('includes/init.php');

$pageActive = "";
require_once('templates/header.php');

$erreur = '';
$erreurBool = true;

	if(!P('Raison')){
		$erreur = $erreur .'Vous n\'avez pas saisi de raison.<br/>';
		$erreurBool = false;
	}
	if(!P('tmpderetard')){
		$erreur = $erreur .'Vous n\'avez pas saisi de temps de retard.<br/>';
		$erreurBool = false;
	}
	
	if(!$erreurBool || !P('prevenir')){ ?>
		<div id="titre"><strong>Prevenir d'un retard </strong></div><br />

		<?php if(!$erreurBool && P('prevenir')){ ?>
			<div><?php echo $erreur;?></div>
		<?php }?>

		<form action="prevenirretard.php" method="post"/>
		<?php $queryRetard = $bdd->prepare("select tr.*,a.NOM_VILLE as a,d.NOM_VILLE as d from TRAJET tr join VILLE a on a.ID_VILLE = ID_VILLE_A join VILLE d on d.ID_VILLE = ID_VILLE_D where ID_TRAJET IN (select ID_TRAJET from PASSAGER where ID_UTILISATEUR = ? and DEMANDE_VALIDEE =1)");
			$queryRetard->execute(array($_SESSION['id']));
			$data = $queryRetard->fetchAll();
			$queryRetard->closeCursor();
			?>
		
		
			Choisir un trajet : 
			<select id="trajetdemandee" name ="trajetdemandee">
			
			<?php 
			foreach($data as $d)
			{
				$libelle = $d['a'] . '-' . $d['d']. ' le ' . $d['DATE_TRAJET'];?>
				<option value="<?php echo $d['ID_TRAJET']; ?>"><?php echo $libelle; ?></option>;
			<?php }
			?>
			</select><br/><br/>

			Raison : <textarea name="Raison" cols = "100" rows = "20"></textarea><br/><br/>
			Temps de retard : <input type="text" name="tmpderetard" /><br/><br/>
			
			<input type="submit" name="prevenir" value="Prevenir" class="btn btn-success" />

		</form><?php
	}
	else if(P('prevenir')){
		$queryRetard = $bdd->prepare("select ID_UTILISATEUR from TRAJET WHERE ID_TRAJET=?");
		$queryRetard->execute(array(P('trajetdemandee')));
		$retar = $fetch();
		$queryRetard->closeCursor();
		
		mailTo_info_retard($retar['ID_UTILISATEUR'], P('Raison'), P('tmpderetard'));
		?>
		<div id="titre"><strong>Validation d'un retard </strong></div><br /><br />
		<div>Votre requete de retard a bien etait envoyer a votre conducteur.</div><br />
	<?php }
?>




<?php 
require_once('templates/footer.php');
