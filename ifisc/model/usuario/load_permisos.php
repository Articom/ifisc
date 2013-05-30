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

$usuarioLogged = $_SESSION['logged_user'];
//sentencia para buscarl el id del usuario logeado
$ssql ="SELECT * FROM usuario u where u.Nombre= '$usuarioLogged'";

//Ejecuto la sentencia 
$fila= mysql_fetch_assoc(mysql_query($ssql,$conn)); 
	//si fila contiene algun resultado
  if($fila['id']){
  	$id_role =$fila['id_role'];
  	//ejecutamos la consulta para cargar el rol del usuario
  	$ssql2 ="SELECT * FROM role where id = '$id_role'";
  	//variable que almacenará los datos del usuario
  	$role_usuario= mysql_fetch_assoc(mysql_query($ssql2,$conn)); 
  	if($role_usuario['id']){
  		$id_permiso =$role_usuario['id_permiso'];
  		//creamos la consulta para buscar los permisos del usuario asociado
  		$ssql3 ="SELECT * FROM permisos where id = '$id_permiso'";
  		//variable que almacena los permisos de los usuarios
  		$permiso_usuario= mysql_fetch_assoc(mysql_query($ssql3,$conn)); 
  	}
  }

 ?>