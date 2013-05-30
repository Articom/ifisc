<?php // template para la mayor parte de las paginas del sistema 
//iniciamos la sesion para utilizarla en todas las paginas
session_start();
//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

//se cargan las funciones de los permisos de usuario
$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
require $permisos_location;
//variable que indica la localizacion absoluta de la cabecera.
$header_location = $path_absoluto ."local/_header.php";
//texto del titulo de la ventana
$titulo = "Editar Roles";
//si la pagina es privada requiere un menú 
//$show_menu = true;
//sino comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
        $show_menu = true;
        //se comprueba si el usuario posee los permisos para
        //editar los permisos asociados a los roles
        if ($permiso_usuario['EditarPermisos']) {
            //si es cierto continua...
        }else{
            //se devuelve al inicio
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/index.php"); 
            exit;
        }
         
    }else{
       //lo devuelve al inicio
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /ifisc/index.php"); 
        exit;
    }
}else{
    //lo devuelve al inicio
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /ifisc/index.php"); 
    exit;
}
//se localiza la direccion del archivo que busca todos los roles
$roles_location = $path_absoluto ."model/common/load_all_role.php";
//se incluye
include_once $roles_location;

//se renderiza el html de la cabecera
include $header_location; 
?>
<!-- contenido de la pagina -->
        <ul data-role="listview" data-divider-theme="b" data-inset="true">
            <li data-role="list-divider" role="heading">
                Roles
            </li>
            <?php 
                $indice = 1;
                while($row1 = mysql_fetch_array($roles)){
                    echo '<li data-theme="a">';
                    echo '<a href="/ifisc/local/admin/permisos/editar.php?role='.$row1['Nombre'];
                    echo '" data-transition="slide" data-ajax="false">';
                    echo $row1['Nombre'];
                    echo '</a></li>';
                }
             ?>
        </ul>
    </div>
                               
<!-- fin del contenido de la pagina -->
<?php 
    //variable que indica la localizacion absoluta del footer.
    $footer_location = $path_absoluto ."local/_footer.php";
    //se le da el texto a el fondo
    $footer_string = "iFISC";
    $show_footer=true;
    //se incluye el archivo segun la variable de posicion absoluta
    include $footer_location;
 ?>