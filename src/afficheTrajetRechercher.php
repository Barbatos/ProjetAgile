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
		if($trajet['tr.nb_place_occupe'] < $trajet['tr.nb_place'])
?>
		<tr>
			<td><?php echo $trajet['villeDepart'];?></td>
			<td><?php echo $trajet['villeArriver'];?></td>
			<td><?php echo $trajet['tr.prix'];?></td>
			<td><?php echo $trajet['tr.date_trajet'];?></td>
			<td><?php echo $trajet['tr.nb_place'];?></td>
			<td><a href="voirtrajet.php?id=<?php echo $trajet['tr.id'];?>" title="Detail du covoiturage">Detail</a></td>
		</tr>
<?php
	}
?>
	</body>
</table>
