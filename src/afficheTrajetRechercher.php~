<table>
	<thead>
		<tr>
			<th>Ville de depart</th>
			<th>Ville d'arriver</th>
			<th>Prix</th>
			<th>Date trajet</th>
			<th>Nombre de place</th>
		</tr>
	</thead>
	<body>
<?php
	foreach($resultat as $trajet){
		if($trajet['nb_place_occupe'] < $trajet['nb_place'])
?>
		<tr>
			<td><?php echo $trajet['villeDepart'];?></td>
			<td><?php echo $trajet['villeArriver'];?></td>
			<td><?php echo $trajet['prix'];?></td>
			<td><?php echo $trajet['date_trajet'];?></td>
			<td><?php echo $trajet['nb_place'];?></td>
		</tr>
<?php
	}
?>
	</body>
</table>
