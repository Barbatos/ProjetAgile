<?php

// On définit le charset et le timezone
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
date_default_timezone_set('Europe/Paris');
ini_set('arg_separator.output', '&amp;');

// On force la désactivation des magic quotes
ini_set('magic_quotes_runtime', 0);

// Connexion à la base de données
$db['user'] 	= "agile";
$db['password'] = "4g!l3";
$db['dbname'] 	= "agile";
$db['host'] 	= "barbatos.fr";
$db['db'] 		= "mysql:host=".$db['host'].";dbname=".$db['dbname'].";charset=UTF8";

$bdd = new PDO($db['db'], $db['user'], $db['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
if(!$bdd){
	exit('Erreur de connexion à la base de données.');
}

unset($db);
