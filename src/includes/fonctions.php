<?php

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

// $_POST
function P($str, $index = NULL)
{
	if(!isset($index)):
		if(isset($_POST[$str])):
			return s($_POST[$str]);
			
		else:
			return NULL;
		endif;
	else:
		if(isset($_POST[$str]) AND is_array($_POST[$str]) AND isset($_POST[$str][$index])):
			return s($_POST[$str][$index]);
			
		else:
			return NULL;
		endif;
	endif;
	
}
