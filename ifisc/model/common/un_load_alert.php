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

 //se hace una instancia del objeto de alerta 

          //variable que almacenará el valor de la alerta

          

if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
    	//si el usuario esta loggeado y autentificado
    	$usuarioLogged = $_SESSION['logged_user'];
		$alerta_cons ="UPDATE usuario SET AlertaPendiente = false WHERE Nombre = '$usuarioLogged'";
		mysql_query("SET NAMES 'utf8'");
          mysql_query($alerta_cons,$conn);
    }
}
    $alertaPendiente =false;

 ?>