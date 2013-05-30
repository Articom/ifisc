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

$usuario = $_SESSION['logged_user'];
//sentencia para buscarl el id del usuario logeado
$ssql ="SELECT id FROM usuario u where u.Nombre= '$usuario'";

//Ejecuto la sentencia 
$fila= mysql_fetch_assoc(mysql_query($ssql,$conn)); 
	//si fila contiene algun resultado
  if($fila['id']){
  	$id_usuario =$fila['id'];
  	//ejecutamos la consulta para cargar los datos del usuario
  	$ssql2 ="SELECT * FROM datosusuario d where d.id_usuario = '$id_usuario'";
  	//variable que almacenará los datos del usuario
  	$datosusuario= mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
  }

 ?>