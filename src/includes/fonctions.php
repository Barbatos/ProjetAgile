<?php

/**
 * Sécurise une chaîne de caractères.
 *
 * @param 	$string - chaîne de caractère
 * @return 	la chaîne sécurisée
 * @author 	Charles 'Barbatos' Duprey
 * @access 	public
 */
function s($string)
{
	return stripslashes(stripslashes(htmlspecialchars($string)));
}

/**
 * Récupère et sécurise un élément $_GET
 *
 * @param 	$string - chaîne de caractère - le paramètre à récupérer
 * @param 	$index - si string est un tableau, permet de récupérer un
 *				champ spécifique du tableau.
 * @return 	le contenu du champ
 * @author 	Charles 'Barbatos' Duprey
 * @access 	public
 */
function G($str, $index = NULL)
{
	if(!isset($index)):
		if(isset($_GET[$str])):
			return s($_GET[$str]);
		
		else:
			return NULL;
		endif;
	
	else:
		if(isset($_GET[$str]) AND is_array($_GET[$str]) AND isset($_GET[$str][$index])):
			return s($_GET[$str][$index]);
			
		else:
			return NULL;
		endif;
	endif;	
}

/**
 * Récupère et sécurise un élément $_POST
 *
 * @param 	$string - chaîne de caractère - le paramètre à récupérer
 * @param 	$index - si string est un tableau, permet de récupérer un
 *				champ spécifique du tableau.
 * @return 	le contenu du champ
 * @author 	Charles 'Barbatos' Duprey
 * @access 	public
 */
function P($str = NULL, $index = NULL)
{
	if(!isset($str)){
		if(isset($_POST) && !empty($_POST)){
			return true;
		}
		else {
			return false;
		}
	}

	if(!isset($index)){
		if(isset($_POST[$str])){
			return s($_POST[$str]);
		} 
		else {
			return NULL;
		}
	}
	else {
		if(isset($_POST[$str]) AND is_array($_POST[$str]) AND isset($_POST[$str][$index])){
			return s($_POST[$str][$index]);
		}
		else {
			return NULL;
		}
	}
	
}

/**
 * Ajoute un message d'erreur.
 *
 * @param 	$error - chaîne de caractères - l'erreur à afficher
 * @author 	Charles 'Barbatos' Duprey
 * @access 	public
 */
function error_add($error){
	$_SESSION['errors'][]['error'] = $error;
}

/**
 * Ajoute un message de confirmation.
 *
 * @param 	$message - chaîne de caractères - le message à afficher
 * @author 	Charles 'Barbatos' Duprey
 * @access 	public
 */
function message_add($message){
	$_SESSION['messages'][]['message'] = $message;
}

/**
 * Redirige l'utilisateur sur une page avec affichage
 * d'un message ou d'une erreur.
 *
 * @param 	$message - le message à afficher
 * @param 	$url - l'url sur laquelle rediriger l'utilisateur
 * @param 	$type - le type du message:
 *				1: message normal
 *				autre: message d'erreur
 * @author 	Charles 'Barbatos' Duprey
 * @access 	public
 */
function message_redirect($message, $url = 'index.php', $type = 0){
	global $Site;

	if(empty($url)){
		$url = $_SERVER['HTTP_REFERER'];
	}
	else {
		$url = $Site['base_address'].$url;
	}

	if($type == 1){
		message_add($message);
	}
	else {
		error_add($message);
	}

	header('Location: '.$url);
	exit();
}

/**
 * Vérifie s'il existe des erreurs à afficher.
 *
 * @return 	true s'il y a des erreurs, sinon false
 * @author 	Charles 'Barbatos' Duprey
 * @access 	public
 */
function error_exists(){
	return (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) ? true : false;
}

/**
 * Vérifie si le visiteur est connecté
 *
 * @return 	true si l'utilisateur est connecté, sinon false
 * @author 	Charles 'Barbatos' Duprey
 * @access 	public
 */
function est_connecte(){
	if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
		return true;
	}
	else {
		return false;
	}
}

/**
 * Gestion de l'affichage des dates
 *
 * @return 	la date sous différents formats
 * @author 	Charles 'Barbatos' Duprey, zCorrecteurs.fr
 * @access 	public
 */
function dateformat($dateheure, $datetime = 1)
{
	if($dateheure == 0)
	{
		return 'jamais';
	}
	$final = '';
	$dateheurefausse = mktime(1, 0, 0, date('m', $dateheure), date('d', $dateheure), date('Y', $dateheure));
	$fauxnow = mktime(1, 0, 0, date('m'), date('d'), date('Y'));
	$faussedifference = $fauxnow - $dateheurefausse;
	$now = time();
	$difference = $now - $dateheure;

	$futur = false;
	if($difference < 0)
	{
		$difference = abs($difference);
		$faussedifference = abs($faussedifference);
		$futur = true;
	}

	if($faussedifference > 2*24*60*60) 
	{
		if($datetime == 1)
		{
			return 'le '.date('d/m/Y à H\hi:s', $dateheure);
		}
		elseif($datetime == 0)
		{
			return 'le '.date('d/m/Y', $dateheure);
		}
	}
	elseif($faussedifference == 0) 
	{
		if($datetime == 1)
		{
			if($difference >= 4*60*60) 
			{
				$final = 'aujourd\'hui,';
			}
			elseif($difference < 4*60*60) 
			{
				if($futur)
				{
					$final = 'dans ';
				}
				else
				{
					$final = 'il y a ';
				}
				$heure = (int)($difference/(60*60));
				$difference -= $heure*60*60;
				$minute = (int)($difference/60);
				$difference -= $minute*60;
				$seconde = $difference;
				if($heure > 0)
				{
					if($minute < 10)
					{
						$minute = '0'.$minute;
					}
					$final .= $heure.'h'.$minute;
				}
				elseif($minute > 0)
				{
					$final .= $minute.' min';
				}
				else
				{
					$final .= $seconde.' s';
				}
				return $final;
			}
		}
		elseif($datetime == 0)
		{
			return 'aujourd\'hui';
		}
	}
	elseif($faussedifference == 24*60*60 || $faussedifference == 24*60*60 + 3600 || $faussedifference == 24*60*60 - 3600) 
	{
		if($futur)
		{
			$final = 'demain,';
		}
		else
		{
			$final = 'hier,';
		}
	}
	elseif($faussedifference == 2*24*60*60 || $faussedifference == 2*24*60*60 + 3600 || $faussedifference == 2*24*60*60 - 3600) 
	{
		if($futur)
		{
			$final = 'après-demain,';
		}
		else
		{
			$final = 'avant-hier,';
		}
	}
	if($datetime == 1)
	{
		
		$final .= ' à '.date('H\hi:s', $dateheure);
	}
	else
	{
		$final = substr($final, 0, strlen($final) - 1);
	}

	return $final;
}

function genererCode()
{
	$code = "";
	$clef = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789abcdefghijklmnopqrstuvwxyz";
	
	
	for($i=0;$i<6;$i++)
	{
		$code .= $clef[rand(0,strlen($clef)-1)];
	}
	
	return $code;
}	

function compterPlacesDispo($idTrajet){
	global $bdd;

	$stmt = $bdd->prepare("SELECT NB_PLACE FROM TRAJET WHERE ID_TRAJET = :id");
	$stmt->bindValue(':id', $idTrajet);
	$stmt->execute();
	$nbPlaces = $stmt->fetch(PDO::FETCH_OBJ);
	$stmt->closeCursor();

	$stmt = $bdd->prepare("SELECT COUNT(*) AS nb FROM PASSAGER WHERE ID_TRAJET = :trajet AND DEMANDE_VALIDEE = :valide");
	$stmt->bindValue(':trajet', $idTrajet);
	$stmt->bindValue(':valide', 1);
	$stmt->execute();
	$nbPlacesPrises = $stmt->fetch(PDO::FETCH_OBJ);
	$stmt->closeCursor();

	return $nbPlaces->NB_PLACE - $nbPlacesPrises->nb;
}

function mailTo($id_destinataire, $sujet, $message)
{
	$stmt = $bdd->prepare('SELECT mail FROM UTILISATEUR WHERE ID_UTILISATEUR = "'.$id_destinataire.'" ;');
	$stmt->execute();
	$data = $stmt->fetch(PDO::FETCH_OBJ);
	$stmt->closeCursor();
		
	$sujet = 'Sujet de l\'email';
	$message = "Bonjour,
	Ceci est un message texte envoyé grâce à  php.
	merci :)";
	$destinataire = 'destinataire@domaine.com';
	$headers = "From: \"expediteur moi\"<moi@domaine.com>\n";
	$headers .= "Reply-To: moi@domaine.com\n";
	$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"";
	if(mail($destinataire,$sujet,$message,$headers))
	{
			echo "L'email a bien été envoyé.";
	}
	else
	{
			echo "Une erreur c'est produite lors de l'envois de l'email.";
	}
}

function mailTo_info($id_destinataire, $code)
{
	$stmt = $bdd->prepare('SELECT mail FROM UTILISATEUR WHERE ID_UTILISATEUR = "'.$id_destinataire.'" ;');
	$stmt->execute();
	$destinataire = $stmt->fetch(PDO::FETCH_OBJ);
	$stmt->closeCursor();
	
	$sujet = 'Info Co-Voiturage';
	$message = "Bonjour,
	L'un des co-voiturages que vous aviez demandé vient d'être validé.
	Nous vous invitons à venir consulter l'état de vos demandes sur le site.
	Votre code passager pour ce trajet sera : ".$code. "
	Merci d'avoir utilisé notre site.";
	$headers = "From: Co-Voiturage ";
	$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"";
	if(mail($destinataire,$sujet,$message,$headers))
	{
			echo "L'email a bien été envoyé.";
	}
	else
	{
			echo "Une erreur c'est produite lors de l'envoi de l'email.";
	}
}

