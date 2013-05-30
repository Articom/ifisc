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

//se verifica si se han mandado algun parametro por el metodo get
if (count($_GET) > 0) {
    //Se verifica que el parametro enviado sea de tipo role 
    if ($_GET['role']) {
        //si es de tipo role guardamos el parametro
        $roleAEditar=$_GET['role'];
    }//de lo contrario se devuelve al inicio
    else{
        //se devuelve al inicio
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/local/admin/permisos/rolesAdmin.php"); 
            exit;
        }
}//de lo contrario se devuelve al inicio
else{
     //se devuelve al inicio
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/local/admin/permisos/rolesAdmin.php"); 
            exit;       
}
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

//se busca el permiso por el rol asociado
 $clase_permiso_location = $path_absoluto ."model/class_permisos.php";
 include $clase_permiso_location;
 //se hace una instancia del objeto de permisos
$obj_permisos = new permiso;
//se accede a la funcion del objeto permisos para buscar por el nombre del role
$permisos_role = $obj_permisos->getPermisosByRoleName($roleAEditar);

//comprobamos que se haiga mandado algo por el metodo post
if (count($_POST) > 0) {
	//si tiene mas uno o mas parametros en el post
	//se crea el inicio  de la consulta update
	$query ="UPDATE permisos
						SET";
	//se itera sobre cada uno de los permisos existentes
	for($i = 1; $i < mysql_num_fields($permisos_role); $i++) {
        $field_info = mysql_fetch_field($permisos_role, $i);
        //se busca el parametro del permiso sobre cada elemento en el metodo post
        if (isset($_POST[$field_info->name])) {
        	//se crea el cuerpo de la consulta de update
        	if ($_POST[$field_info->name]==="on") {
        		$valor = '1';
        	}else{
        		$valor = '0';
        	}
        	$query .=" ".$field_info->name." = ".$valor.",";
        }
    }
    //se elimina la ultima coma de mas en la cadena de consulta
    $query = rtrim($query, ",");
    //Se formatea el result de la consulta para buscar el id
    $row1 = mysql_fetch_assoc($permisos_role);
    //se crea el final de la consulta agregandole el id
    $query .=" WHERE id = ".$row1['id']."";
    //se ejecuta la consulta en la base de datos 
    mysql_query($query,$conn);
    //se regresa a la vista anterior con los datos actualizados
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /ifisc/local/admin/permisos/rolesAdmin.php"); 
    exit;
}

 ?>