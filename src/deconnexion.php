<?php 

require_once('includes/init.php');

session_destroy();
		
$_SESSION = array();
$_COOKIE = array();

session_start();

message_redirect('Vous êtes maintenant déconnecté, à bientôt !', 'index.php', 1);
