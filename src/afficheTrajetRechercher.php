<div id="titre"><h1>Recherche de covoiturage</h1></div>

<?php
if(!empty($resultat)){
	?>
	<table>
		<thead>
		<table class = "table">
			<tr>
				<th>Ville de depart</th>
				<th>Ville d'arriver</th>
				<th>Prix</th>
				<th>Date trajet</th>
				<th>Nombre de place</th>
				<th>Detail</th>
			</tr>
		</thead>
		<body>
	<?php
		foreach($resultat as $trajet){
			//if($trajet['NB_PLACE_OCCUPE'] < $trajet['NB_PLACE']){
	?>
		
			<tr>
				<td><?php echo $trajet['villeDepart'];?></td>
				<td><?php echo $trajet['villeArriver'];?></td>
				<td><?php echo $trajet['PRIX'];?></td>
				<td><?php echo $trajet['DATE_TRAJET'];?></td>
				<td><?php echo $trajet['NB_PLACE'];?></td>
				<td><a href="voirtrajet.php?id=<?php echo $trajet['ID_TRAJET'];?>" title="Detail du covoiturage">Detail</a></td>
			</tr>
		</table>
	<?php
			//}
		}
	?>
		</body>
	</table>
	<?php 
}
else{ ?>

	<div>Il n'y a pas de trajet de disponible.</div>
	<form action="enregistreAvertisement.php?villeD=<?php echo $villeDepart.'&villeA='.$villeArriver.'&dateD='.$date_trajet;?>" method="POST">
		<input type="submit" name="avertisment" value="Etre averti"/>
	</form>
<?php }
?>
