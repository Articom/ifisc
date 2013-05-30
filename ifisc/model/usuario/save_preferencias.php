<?php
session_start();
$path = $_SERVER['PHP_SELF']; 
    $temp = explode("/", $path); 
    $path_absoluto = "/"; 
    for($i=3;$i<count($temp);$i++) 
    $path_absoluto .= "../"; 

    //variable que indica la localizacion absoluta del archivo.
    $conection_file = $path_absoluto ."model/sesion/seguridad/open_conn.php";
include_once $conection_file;
//comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
    	//lo dejamos continual
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
// se ve si el metodo post posee algun valor... en especifico el de preftList
if (isset($_POST['prefList'])) {
	$preferencias = $_POST['prefList'];
	//variable que almacena el id del usuario loggeado
	$id_usuario = $_SESSION['id_usuario'];
	//se crea la consulta para eliminar todos los registros de las preferencias pasadas
		$consulta_eliminar = "DELETE FROM preferencias
								WHERE id_usuario = '$id_usuario'";
	//se hace el delete que borra todos los datos existentes
	mysql_query($consulta_eliminar, $conn); 
	foreach ($preferencias as $categoria_id) {
    	//vamos a formar la consulta para guardar
    	$consulta_save = "INSERT INTO preferencias (id_categoria, id_usuario)
								VALUES ('$categoria_id', '$id_usuario')";
		//se ejecuta la consulta por cada item en la variable
		mysql_query($consulta_save, $conn); 
	}

}

    //se regresa al inicio
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /ifisc/index.php"); 
    exit;


 ?>