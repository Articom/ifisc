
<?php // template para la mayor parte de las paginas del sistema 
//iniciamos la sesion para utilizarla en todas las paginas
session_start();
//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 
$page_id = "pagPrincipal";
//variable que indica la localizacion absoluta de la cabecera.
$header_location = $path_absoluto ."local/_header.php";
$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
$class_display_location = $path_absoluto ."model/class_display.php";
$class_usuario_location = $path_absoluto ."model/class_usuario.php";
$clase_categoria_location = $path_absoluto ."model/class_categoria.php";
$clase_publicaciones_location = $path_absoluto ."model/class_publicacion.php";

include $clase_categoria_location;
include $clase_publicaciones_location;
include $class_display_location;
require $permisos_location;
include $class_usuario_location;
//texto del titulo de la ventana
$titulo = "Editar Menú";

//si la pagina es privada requiere un menú 
//$show_menu = true;
//sino comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
        //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
                //si esta loggeado se muestra el menu
                $show_menu = true;
                
                    //se comprueba si tiene el permiso para editar su perfil
                    if ($permiso_usuario['EditarMenuArt']) {
                        //si es cierto continua...
                        $obj_publicacion = new publicacion;                        
                        //se crea un objeto de tipo usuario
                        $obj_usuario = new usuarioN;
                         $obj_categoria = new categoria;
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
//se renderiza el html de la cabecera
require $header_location; 
//se crea un objeto para accesar a los metodos de la clase
$obj_display = new displayes;

if (isset($_GET['item'])) {
    $item_selected =$_GET['item'];
}

?>
<!-- contenido de la pagina -->
<div id = "errorRed">
                <?php 
                    //contamos si se ha registrado algun error
                    if (isset($_GET['error'])) {
                            //si es error de dato faltante o de tipo de guardar en la base de datos
                        echo '<h6>';
                             //se muestra el mensaje de error
                        echo 'Algo ha salido mal, intenta realizar el proceso una vez más.';
                        echo '</h6>';
                        }
                    
                 ?>
                 </div>
<!-- <div data-role="collapsible" data-theme="b" data-content-theme="c"> -->
    <h2>Seleccione un Item del Menú principal para editar</h2>
    <ul data-role="listview" data-filter="true" data-inset="true" data-theme="d" data-divider-theme="b" data-count-theme="b">
        <li data-role="list-divider">Menú</li>
        <?php 
        $display_array = $obj_display->getAllDisplays();
        while ($display = mysql_fetch_array($display_array)) {
             echo '<li data-icon="check"><a data-transition="fade" rel="external" href="/ifisc/local/admin/articulo/menu_articulo.php?item='.$display['id'].'#page-1">'.$display['Nombre'].'</a></li>';
        }
         ?>
        
    </ul>
<!-- </div> -->
 <?php
    if (isset($_GET['item'])) {  ?>

        <a href="#page-1" data-role="button" data-icon="arrow-r" data-iconpos="right" data-inline="true">Adelante</a>
    <?php
        }
    ?>


<!-- fin del contenido de la pagina -->
<?php 
    //variable que indica la localizacion absoluta del footer.
    $footer_location = $path_absoluto ."local/_footer.php";
    //se le da el texto a el fondo
    $footer_string = "";
    $show_footer=true;
    //se incluye el archivo segun la variable de posicion absoluta
    include $footer_location;
 ?>
 <!-- ********************************************************************** -->
 <!-- inclusion de la segunda pagina -->
<?php
//la segunda página despues de la primera en un mismo archivo
//localizamnos la ubicación de la cabecera de esta pagina
$page_extra_h1 = $path_absoluto ."local/_page_H.php";
//se le da un id a esta pagina para navegar a travez de ella
$page_id = "page-1";
//se incluye el archivo de cabecera segun la variable de posicion absoluta
include $page_extra_h1;
?>
<!-- contenido de la pagina2 -->

<?php
    if (isset($_GET['item'])) {  
        $item = $_GET['item'];
        ?>
        <h2>Seleccione a que va asociado este ítem</h2>
        <ul data-role="listview" data-split-icon="check" data-theme="a" data-split-theme="b" data-inset="true">
    <li><?php echo '<a href="/ifisc/local/admin/articulo/menu_articulo.php?item='.$item.'&&tipo=1#page-2" data-rel="external" data-ajax="false" data-position-to="window" data-transition="fade">'; ?>
        <h2>Un artículo</h2>
        </a><?php echo '<a href="/ifisc/local/admin/articulo/menu_articulo.php?item='.$item.'&&tipo=1#page-2" data-rel="external" data-ajax="false" data-position-to="window" data-transition="fade">Seleccionar</a>'; ?> 
    </li>
    <li><?php echo '<a href="/ifisc/local/admin/articulo/menu_articulo.php?item='.$item.'&&tipo=2#page-2" data-ajax="false" data-rel="external" data-position-to="window" data-transition="fade">'; ?>
        <h2>Una Categoría</h2>
        </a></a><?php echo '<a data-rel="external" href="/ifisc/local/admin/articulo/menu_articulo.php?item='.$item.'&&tipo=2#page-2" data-ajax="false" data-transition="fade">Seleccionar</a>'; ?> 
    </li>
        </ul>

        <a href="#pagPrincipal" data-role="button" data-icon="arrow-l" data-iconpos="left" data-inline="true">Atrás</a>
        <?php
    if (isset($_GET['tipo'])) {  ?>

        <a href="#page-2" data-role="button" data-icon="arrow-r" data-iconpos="right" data-inline="true">Adelante</a>
<?php
    }
?>

<?php
    }else{
?>  
     <h2>Debe seleccionar un ítem primero</h2>
        <a href="#pagPrincipal" data-role="button" data-icon="arrow-l" data-iconpos="left" data-inline="true">Atrás</a>
<?php
    }
?>

<!-- fin del contenido de la pagina2 -->
<?php 
//incluimos el archivo de footer para cerrar la estructura
//se localiza la ubicacion absoluta del archivo
$page_extra_f1 = $path_absoluto ."local/_page_F.php";
//se incluye el archivo del footer para terminar
include $page_extra_f1;
//incluir cuantas paginas sean necesarias
?>
 <!-- ********************************************************************** -->
 <!-- inclusion de la segunda pagina -->
<?php
//la segunda página despues de la primera en un mismo archivo
//localizamnos la ubicación de la cabecera de esta pagina
$page_extra_h1 = $path_absoluto ."local/_page_H.php";
//se le da un id a esta pagina para navegar a travez de ella
$page_id = "page-2";
//se incluye el archivo de cabecera segun la variable de posicion absoluta
include $page_extra_h1;
?>
<!-- contenido de la pagina2 -->
<!-- //paragina para mistrar los items de las publicaciones -->
<?php 
    if (isset($_GET['item'])&&isset($_GET['tipo'])) {
        $tipo =$_GET['tipo'];
        $item = $_GET['item'];
        if ($_GET['tipo'] == '2') {
           //datos de los articulos, divididos por categoria
        
       ?>

        <h2>Seleccione la categoría a la que está asociada este Ítem:</h2>
        <ul data-role="listview" data-autodividers="true" data-filter="true" data-inset="true">
            <?php 
            //buscamos todas las categorias que sean estaticas

           

            $categorias_estaticas = $obj_categoria->getAllCategoriasEstaticas();
            //iteramos sobre todos los resultados
            while ($categoria_simple = mysql_fetch_array($categorias_estaticas)) {
                echo '<li data-icon="check"><a data-ajax="false" data-rel="external" href="/ifisc/model/admin/sys/save_menu.php?item='.$item.'&&tipo=2&&val='.$categoria_simple['id'].'">'.$categoria_simple['Nombre'].'</a></li>';

            }
             ?>
        </ul>
         <a href="#page-1" data-role="button" data-icon="arrow-l" data-iconpos="left" data-inline="true">Atrás</a>
       <?php   
       }elseif ($_GET['tipo'] == '1') {
        //datos de las categorias
        ?>
        <h2>Seleccione la publicación a la que está asociada este Ítem:</h2>
        <div data-role="collapsible-set" data-theme="b" data-content-theme="d">
         <?php 
        //primero listamos todas las categorias de las publicaciones que sean estaticas
         $categoriasId = $obj_publicacion->getCategoriasIdOfPublicacionesEstaticasAprobadas();
         //buscamos todas las publicaciones pendientes por los categoriasId
         while ($categoriaId = mysql_fetch_array($categoriasId)) {
            // Se buscan todas la publicaciones de esta categoria
            $publicaiones_cat = $obj_publicacion->getPublicacionAprobadasByCategoriaId($categoriaId['id_categoria']);
            // Por cada categiria encontrada se coloca un list-divider
            echo '<div data-role="collapsible"><h2>';
            //nombre de la categoria
            echo $obj_categoria->getCategoriaNombreById($categoriaId['id_categoria']);
            echo '</h2><ul data-role="listview" data-filter="true" data-filter-theme="c" data-divider-theme="d">';
            //mostramos por pantalla cada una de las publicaciones de esta categoria
             while ($publicacion_estatica = mysql_fetch_array($publicaiones_cat)) {
                //sobre cada publicacion estatica que pertenezca a esa categoria hacemos
                echo '<li><a href="/ifisc/model/admin/sys/save_menu.php?item='.$item.'&&tipo=1&&val='.$publicacion_estatica['id'].'" 
                 data-ajax="false" rel="external">';
                echo '<h2>-'.$publicacion_estatica['Titulo'].'</h2>'; 
                //echo '<p class="ui-li-aside" >'.$publicacion_estatica['FechaMod'].'</p>';
                echo '<p>Autor: <strong>'.$obj_usuario->getNombreUsuarioById($publicacion_estatica['id_usuario']).'</strong></p>';
                //echo '<p style="white-space:normal;">'.substr(strip_tags($publicacion_estatica['Cuerpo']),0,250).'</p>';
                echo'</a></li>';
             }
             echo '</ul></div>';
         }
        ?>
        </div>
     <a href="#page-1" data-role="button" data-icon="arrow-l" data-iconpos="left" data-inline="true">Atrás</a>
        <?php   
       }else{
            ?>  
     <h2>Debe seleccionar un típo valido primero</h2>
        <a href="#page-1" data-role="button" data-icon="arrow-l" data-iconpos="left" data-inline="true">Atrás</a>
<?php
       } 
    }elseif (isset($_GET['item'])) {
           
?>

        <h2>Debe seleccionar una categoría</h2>
        <a href="#pagPrincipal" data-role="button" data-icon="arrow-l" data-iconpos="left" data-inline="true">Atrás</a>
<?php
    }else{
        ?>
        <h2>Debe seleccionar un ítem primero</h2>
        <a href="#pagPrincipal" data-role="button" data-icon="arrow-l" data-iconpos="left" data-inline="true">Atrás</a>
    
<?php
    }
?>

<!-- fin del contenido de la pagina2 -->
<?php 
//incluimos el archivo de footer para cerrar la estructura
//se localiza la ubicacion absoluta del archivo
$page_extra_f1 = $path_absoluto ."local/_page_F.php";
//se incluye el archivo del footer para terminar
include $page_extra_f1;
//incluir cuantas paginas sean necesarias
?>
