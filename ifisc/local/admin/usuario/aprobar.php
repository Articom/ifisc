<?php // template para la mayor parte de las paginas del sistema 
//iniciamos la sesion para utilizarla en todas las paginas
session_start();
//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 
//se comprueba, antes que todo, si el usuario esta logeado
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
        //si esta logeado
        $permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
        //Se carga el archivo de busqueda de los usuarios en estado pendiente de aprobacion
        $usuarios_pendientes_loaction= $path_absoluto ."model/usuario/load_usuarios_pendientes.php";
        //se carga el archivo que realiza la consulta y extrae los permisos
        include_once $permisos_location;
        include_once $usuarios_pendientes_loaction;
        //antes de mostrar la interfaz se comprueba si el usuario tiene los permisos necesaroios
        if ($permiso_usuario['AprobarUsuario']) {
            
        } else{
            //de no tener los permisos que se requieren en esta interfaz 
            //retorna al home
            header("HTTP/1.1 301 Moved Permanently");
            header ("Location: /ifisc/index.php");  
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
//variable que indica la localizacion absoluta de la cabecera.
$header_location = $path_absoluto ."local/_header.php";
//texto del titulo de la ventana
$titulo = "Aprobar usuarios";
//si la pagina es privada requiere un menú 
//$show_menu = true;
//sino comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
        $show_menu = true;
    }else{
        $show_menu = false;
    }
}else{
    $show_menu = false;
}
//se renderiza el html de la cabecera
include $header_location; 
//se incluye la clase de datos del usuario para su utilizacion
$clase_usuario_location = $path_absoluto ."model/class_datos_usuario.php";
$clase_role = $path_absoluto ."model/class_role.php";
include $clase_usuario_location;
include $clase_role;
?>
<!-- contenido de la pagina -->
<h2>Solicitudes pendientes</h2>
<div data-role="collapsible-set" data-content-theme="a" data-theme="b" data-filter="true">

                <?php 
                $indice = 1;
               while($row = mysql_fetch_array($usuarios_no_aprobados)){
                //se crea un ojeto de tipo datos de usuario para mostrar los datos
                $obj_datos_usuario = new datos_usuario;
                //creamos la instancia de la clase role
                $obj_role = new role;
                //se buscan los datos del usuario por el id
                $datosde_usuario = $obj_datos_usuario->getDatosDeUsuarioById($row['id']);
                        echo '<div data-role="collapsible"><h3>';
                        echo 'Solicitud No. '.$indice;
                        echo '</h3>';
                        echo '<form action="/ifisc/model/admin/usuario/aprobar_usuario.php" method="POST" data-ajax="false">';
                        echo 'Usuario: <input type="text" name="nickname" readonly value="';
                        echo $row['Nombre'];
                        echo '">';
                        echo 'Nombre: <input type="text" name="nombre" readonly value="';
                        echo $datosde_usuario['Nombre1'];
                        echo '">';
                        echo 'Apellido: <input type="text" name="apellido" readonly value="';
                        echo $datosde_usuario['Apellido1'];
                        echo '">';
                        echo 'Cédula: <input type="text" name="ced"  readonly value="';
                        echo $datosde_usuario['Cedula'];
                        echo '">';
                        echo 'Rol: <input type="text" name="role" readonly value="';
                        //buscamos el nombre del rol por el id
                        echo $obj_role->getNombreRoleById($row['id_role']);
                        echo '">';
                        echo '<input type="submit" name="submit" data-inline="true" data-theme="b" data-icon="plus"data-iconpos="left" value="Aprobar" data-mini="true">';
                        echo '<input type="submit" name="submit" data-inline="true" data-theme="b" data-icon="minus"data-iconpos="left" value="Denegar" data-mini="true">';
                        echo '</form>';
                        echo '</div>';

                     $indice++;
                }
                if ($indice === 1) {
                    //si no existe ninguna solicitud que atender, se muestra el mensaje
                    //Se proporciona un link para retornar al inicio
                    echo ' <div id = "errorRed">';
                    echo '<h6>';
                    echo 'No hay solicitudes que atender.';
                    echo '</h6>';
                     echo '<a href="/ifisc/index.php" data-ajax="false" data-transition="fade" class="enlace">
                                Volver al Inicio
                            </a>';
                    echo '</div>';
                }
                 ?>
        </div>

<!-- fin del contenido de la pagina -->
<?php 
    //variable que indica la localizacion absoluta del footer.
    $footer_location = $path_absoluto ."local/_footer.php";
    //se le da el texto a el fondo
    $footer_string = "Administración iFISC";
    $show_footer=true;
    //se incluye el archivo segun la variable de posicion absoluta
    include $footer_location;
 ?>
