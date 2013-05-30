<?php
//si no existe coneccion abierta
if(!session_id()) 
{ 
	session_start();
} 
//localizamos el archivo de coneccion
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

//variable que indica la localizacion absoluta del archivo de conecion.
$conection_location = $path_absoluto ."model/sesion/seguridad/open_conn.php";
include_once $conection_location;


//sentencia para buscarl los usuarios son estado 2--- estado pendiente
$usuarios_no_aprobados = mysql_query("SELECT * FROM usuario u where u.Estado= 2");

 ?>