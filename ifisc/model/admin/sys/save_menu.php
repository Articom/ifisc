<?php
session_start();
//ubicacion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
    $temp = explode("/", $path); 
    $path_absoluto = "/"; 
    for($i=3;$i<count($temp);$i++) 
    $path_absoluto .= "../"; 

    //variable que indica la localizacion absoluta del archivo.
    $conection_file = $path_absoluto ."model/sesion/seguridad/open_conn.php";    
$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
include_once $conection_file;
require $permisos_location;
//comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
    	//lo dejamos continual
    	//comprobamos los permisos
    	if ($permiso_usuario['EditarMenuArt']) {
                        //si es cierto continua...

	    }//de lo contrario vuelve al inicio
	    else{
	        header("HTTP/1.1 301 Moved Permanently");
	        header("Location: /ifisc/index.php"); 
	        exit;
	    	echo 'llego';
	    }
    }//si no... se envia al login
    else{
    	header("HTTP/1.1 301 Moved Permanently");
        header("Location: /ifisc/local/sesion/login.php"); 
        exit;
    }
}//sino... se envia al login
else{
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: /ifisc/local/sesion/login.php"); 
    exit;
}
//se ve que variables don enviadas desde la vista
if ((isset($_GET['item']) && isset($_GET['tipo'])) && isset($_GET['val'])) {
	//se guarda la variable que almacena los datos de la publicacion o categoria asociada al item de menu
	$id_enlace = $_GET['val'];
	//se guarda el item del menu al cual se le va a asignar las publicaciones o categoria
	$item_id = $_GET['item'];
	//se ve que tipo de dato es... si categoria o una publicacion
	if ($_GET['tipo'] == '1') {
		//es de tipo publicacion
		$isCategoria = false;
	}else{
		$isCategoria = true;
	}

	//se crea la consulta para actualizar el item del menu seleccionado
		$consulta_actualizar = "UPDATE display SET id_enlace = '$id_enlace', isCategoria = '$isCategoria'
								 WHERE id = '$item_id'";
	//ejecutamos la consulta
	$dbcons =mysql_query($consulta_actualizar, $conn); 
	echo $consulta_actualizar;
}else{
	//lo reenviamos de vuelta para mostrar el error de datos faltantes
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: /ifisc/local/admin/articulo/menu_articulo.php?error=1"); 
    exit;
}
	if (!$dbcons) {
		//lo renviamos porque algo ha salido mal con la base de datos o la consulta
		header("HTTP/1.1 301 Moved Permanently");
	    header("Location: /ifisc/local/admin/articulo/menu_articulo.php?error=1"); 
	    exit;

	}
    //se regresa al inicio
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /ifisc/index.php"); 
    exit;


 ?>