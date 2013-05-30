<?php
	session_start(); 
	unset($_SESSION['autentificado']); 
	$_SESSION = array(); 
	session_unset();
	session_destroy(); 
	
	header("HTTP/1.1 301 Moved Permanently");
    header ("Location: /ifisc/index.php");	
  	exit;
?> 