<?php
if(empty($resultat)){
	?>
	<table>
		<thead>
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
			if($trajet['NB_PLACE_OCCUPE'] < $trajet['NB_PLACE']){
	?>
			<tr>
				<td><?php echo $trajet['villeDepart'];?></td>
				<td><?php echo $trajet['villeArriver'];?></td>
				<td><?php echo $trajet['PRIX'];?></td>
				<td><?php echo $trajet['DATE_TRAJET'];?></td>
				<td><?php echo $trajet['NB_PLACE'];?></td>
				<td><a href="voirtrajet.php?id=<?php echo $trajet['ID_TRAJET'];?>" title="Detail du covoiturage">Detail</a></td>
			</tr>
	<?php
			}
		}
	?>
		</body>
	</table>
	<?php 
}
else{ ?>

	<div>Il n'y a pas de trajet de disponible.</div>
<?php }
?>
