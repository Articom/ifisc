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
include $path_absoluto ."model/class_publicacion.php";
include $path_absoluto ."model/class_usuario.php";
include $path_absoluto ."model/class_categoria.php";
//instanciamos un ubjeto de tipo categoria
$obj_categoria = new categoria;
//se crea un objeto de tipo usuario
$obj_usuario = new usuarioN;
$obj_publicacion = new publicacion;
//variable que indica la localizacion absoluta de la cabecera.
$header_location = $path_absoluto ."local/_header.php";
//texto del titulo de la ventana
$titulo = "Lo último en iFISC";
//si la pagina es privada requiere un menú 
//$show_menu = true;
//sino comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
        $show_menu = true;
        //quitamos el mensaje de publicaciones pendientes por revisar
        $no_alertas_location = $path_absoluto ."model/common/un_load_alert.php";
        include $no_alertas_location;
         $no_logg = false;
         $usuarioLogged = $_SESSION['logged_user'];
    }else{
      $no_logg = true;
    }
}else{
    $no_logg = true;
}
//se renderiza el html de la cabecera
include $header_location; 
?>
<!-- contenido de la pagina -->
      <ul data-role="listview" data-inset="true">
        <?php 
        if ($no_logg) {
            //se hace una consulta sin tomar en cuenta las preferenicas
            $fechas = $obj_publicacion->getAllFechaModPublicacionesNuevas();
        }else{
        $fechas = $obj_publicacion->getFechaModsPublicacionesNuevasByPreferenciasUsuarioName($usuarioLogged);

        }
        $i =1;
        //formamos la estructura de edete view
        while ($fila = mysql_fetch_array($fechas)) {
            //buscamnos todas las publicaciones que ocurrieron en esa fecha
            $i++;
            if ($no_logg) {
                $articulos = $obj_publicacion->getAllPublicacionesNuevasByFechaMod($fila['FechaMod']);
            }else{
                $articulos = $obj_publicacion->getPublicacionesNuevasByPreferenciasUsuarioNameAndFechaMod($usuarioLogged,$fila['FechaMod']);
            }
            if (!mysql_num_rows($articulos)== 0) {
                 echo '<li data-role="list-divider">'.$fila['FechaMod'].'<span class="ui-li-count">'.mysql_num_rows($articulos).'</span></li>';
            }
           
            while ($articulo = mysql_fetch_array($articulos)) {
                //por cada articulo en esa fecha
                echo '<li><a data-ajax="false" href="/ifisc/local/vistas/vmart.php?art='.$articulo['id'].'" data-ajax="false">
                        <h2>'.$articulo['Titulo'].'</h2>
                        <p><strong>Por: '.$obj_usuario->getNombreUsuarioById($articulo['id_usuario']).', en '.$obj_categoria->getCategoriaNombreById($articulo['id_categoria']).'</strong></p>
                        <p>'.substr(strip_tags($articulo['Cuerpo']),0,250).'</p></a>';
                        echo '</li>';
            }
        }

        if ($i == 0) {
            echo '<div class="bar">
    <h1>¡No se han registrado publicaciones para esta categoría!</h1>
    <p></p><h4>De seguro en otras categorías encontrás artículos de tu interés.<h4></div>';
        }
        echo '</ul>';
         ?>
                         
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