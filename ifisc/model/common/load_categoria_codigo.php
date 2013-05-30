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

//variable que indica la localizacion absoluta del archivo de conexion.
$conection_location = $path_absoluto ."model/sesion/seguridad/open_conn.php";
include_once $conection_location;


//consulta para buscar todas los roles de vista publica
$codigo_cat = mysql_fetch_assoc(mysql_query("SELECT * FROM categoria where id = '$categoria_selected'"));
	$codigo=$codigo_cat['Codigo'];
	$categoria_name=$codigo_cat['Nombre'];
	
 ?>