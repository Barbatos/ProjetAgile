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
