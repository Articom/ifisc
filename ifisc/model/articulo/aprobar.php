
<?php 
session_start();
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

//variable que indica la localizacion absoluta de la cabecera.
$arch_conect = $path_absoluto ."model/sesion/seguridad/open_conn.php";
$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
include_once $arch_conect;
require $permisos_location;
//comprobamos los permisos de los usuarios
if (count($_SESSION) > 0) {
        //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
                //se comprueba si tiene el permiso para aperobar publicaciones
                    if ($permiso_usuario['AprobarPublicaciones']) {
                        //si es cierto continua...
                    }//de lo contrario vuelve al inicio
                    else{
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: /ifisc/index.php"); 
                        exit;
                    }
               
            }else{
                //si no exite sesion alguna muestra la ventana de inicio de sesion
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: /ifisc/local/sesion/login.php"); 
                exit;
            }
        }else{
            //si no exite sesion alguna muestra la ventana de inicio de sesion
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/local/sesion/login.php"); 
            exit;
        }
//se comprueba si los datos mandados del la interfás vienen vacios
if (empty($_GET['Idart'])) {
	//se envia a la pagina del nuevo articulo con el error correspondiente
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: /ifisc/local/articulo/aprobar.php"); 
    exit;
}//si no... continua

 $publicacion_id = $_GET['Idart'];
 $estado = 1;     // la publicación se actualiza con estado 1 de aprobada
//se crea la consulta para actualizar los datos de la publicacion
$ssql ="UPDATE publicacion SET Estado = '$estado', FechaMod = now() WHERE id = '$publicacion_id'";

//Ejecuto la sentencia 
$rs = mysql_query($ssql,$conn); 
/*comprobamos el exito de la consulata*/
if ($rs){ 
    //se llama a la funcion que envia mensaje de alerta a los usuarios 
    //comprueba que la publicacion no es para todo el mundo
    //se crea una consulta para buscar la publicación
    $consultaPublicacion = "SELECT * FROM publicacion WHERE id = '$publicacion_id'";
    //se eejecuta la consulta en la base de datos
    $publication = mysql_fetch_assoc(mysql_query($consultaPublicacion,$conn)); 
    //se guardan los datos que vamos a usuar...
    $role_type = $publication['Destino'];//almacena los grupos de usuarios a los que va
                                        // destindo
    $categoria_id = $publication['id_categoria'];//almacena la categoria a la que pertenece
    //se comprueba que el destino no sea 0... 0= todo el mundo... no se envia notificacion por correo electronico

    if ($role_type === '0') {
        //Solo se le envia mensaje a los que tengan esa categoria en sus preferencias y además tengan activado el feed
        //se crea la consulta que busca todos los correos electronicos
        $consultaCorreos = "SELECT * FROM usuario WHERE id IN 
                            (SELECT id_usuario FROM preferencias WHERE id_categoria = '$categoria_id') 
                            AND Feed = true";
    }else{
        //se le enviara un mensaje a todos los usuarios que tengan el rol de destino de esta publicación
        //se crea la consulta que busca todos los correos electronicos
        $consultaCorreos = "SELECT * FROM usuario WHERE (id IN 
                            (SELECT id_usuario FROM preferencias WHERE id_categoria = '$categoria_id') OR id_role = '$role_type') 
                            AND Feed = true";
    }
    //se elecuta la consulta que busca los correos
    $correos_destino = mysql_query($consultaCorreos,$conn);
    $correos_destino2 =mysql_query($consultaCorreos,$conn);
    //consulta para buscar el nombre del publicador de la noticia
    $consultaNombre = "SELECT Nombre FROM usuario WHERE id = ".$publication['id_usuario']."";
    $nombre_publicador = mysql_fetch_assoc(mysql_query($consultaNombre,$conn)); 
    if (mysql_num_rows($correos_destino) > 0) {
        //echo 'entro';
        //se cambia el estado nueva publicaion de todos los usuarios relacionados a esta publicaion
         while($correo_data = mysql_fetch_array($correos_destino)){
            $consultaAlerta = "UPDATE usuario SET AlertaPendiente = true WHERE id = ".$correo_data['id']."";
            //se elecuta la consulta
            // echo "-".$correo_data['mail'];
            mysql_query($consultaAlerta, $conn);
        }

        //se importa la clase que envia los mensajes de alerta
        $mail_location = $path_absoluto ."model/common/mail/mail_publicacion.php";
        require $mail_location;
    }
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: /ifisc/local/articulo/aprobar.php"); 
    exit;
}else{ 
	echo "Existe un problema ".mysql_error(); 
} 
?>