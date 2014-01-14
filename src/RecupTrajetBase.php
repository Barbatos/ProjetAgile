<form name="form" action="verif.php" method="post" enctype="multipart/form-data"> 
	
	<?php
	//

	$dns = 'mysql:host=barbatos.fr;dbname=agile';
	try{
		$co = new PDO($dns,'agile', '4g!l3');
	}
	
	catch (Exception $e){
        	die('Erreur : ' . $e->getMessage());
	}
	
	$req = 'SELECT d.NOM_VILLE "Ville départ", a.NOM_VILLE "Ville arrivée",DATE_TRAJET,DATE_AJOUT
FROM TRAJET
JOIN VILLE d ON d.ID_VILLE = ID_VILLE_D
JOIN VILLE a ON a.ID_VILLE = ID_VILLE_A';

	if(P('trajet'))
	{
		$id = P('trajet');
		$req .= 'WHERE ID_TRAJET = "'.$id.'" ;';
	}
	
	$req = $co->query($req);
	$res = $req->fetchAll();
	for($i=0;$i < count($res);$i++){
		for($j=0;$j < 4;$j++){
			echo $res[$i][$j]." ";
			if($j==3)
				echo "</br>";
		}
	}
?>

<input type="submit" value="ajouter">
</html>