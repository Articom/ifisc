<?php // template para la mayor parte de las paginas del sistema 
//iniciamos la sesion para utilizarla en todas las paginas
session_start();
//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

//variable que indica la localizacion absoluta de la cabecera.
$header_location = $path_absoluto ."local/_header.php";
//texto del titulo de la ventana
$titulo = "Aprobación de solicitudes";
//si la pagina es privada requiere un menú 
//$show_menu = true;
//sino comprobamos si el usuario ha iniciado sesion
// importamos los archivos de permisos, publicaciones, usuario y categorias
$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
$class_usuario_location = $path_absoluto ."model/class_usuario.php";
$clase_categoria_location = $path_absoluto ."model/class_categoria.php";
$clase_publicaciones_location = $path_absoluto ."model/class_publicacion.php";
require $permisos_location;
include $clase_categoria_location;
include $clase_publicaciones_location;
include $class_usuario_location;
//instanciamos un ubjeto de tipo categoria
$obj_categoria = new categoria;
//se crea un objeto de tipo usuario
$obj_usuario = new usuarioN;
if (count($_SESSION) > 0) {
        //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
                //si esta loggeado se muestra el menu
                $show_menu = true;
                
                    //se comprueba si tiene el permiso para aprobar publicaciones
                    if ($permiso_usuario['AprobarPublicaciones']) {
                        //si es cierto continua...
                       //se inicializa el objeto que buscará las operaciones en las publicaciones
                      $obj_publicacion = new publicacion;
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
        $page_id='page';
//se renderiza el html de la cabecera
include $header_location; 
?>
<!-- contenido de la pagina -->

    <ul data-filter="true" data-filter-theme="b" data-role="listview" id="list" data-split-icon="check" data-split-theme="b" data-divider-theme="a" data-inset="true">
        <li data-role="list-divider" role="heading">
               Solicitudes de artículos
        </li>
        <!-- debajo se muestran los articulos pendientes de aprobación -->
        <?php 
        //primero listamos todas las categorias de las publicaciones que esten pendientes
         $categoriasId = $obj_publicacion->getIdCategoriasOfPublicacionesPendientes();
         //buscamos todas las publicaciones pendientes por los categoriasId
         while ($categoriaId = mysql_fetch_array($categoriasId)) {
            // Se buscan todas la publicaciones de esta categoria
            $publicaiones_cat = $obj_publicacion->getPublicacionesPendientesByIdCategoria($categoriaId['id_categoria']);
            // Por cada categiria encontrada se coloca un list-divider
            echo '<li data-role="list-divider">';
            //nombre de la categoria
            echo $obj_categoria->getCategoriaNombreById($categoriaId['id_categoria']);
            echo '<span class="ui-li-count">';
            echo mysql_num_rows($publicaiones_cat);
            echo '</span></li>';
            //mostramos por pantalla cada una de las publicaciones de esta categoria
             while ($publicacion_pendiente = mysql_fetch_array($publicaiones_cat)) {
                echo '<li ><a href="/ifisc/local/vistas/public.php?ar='.$publicacion_pendiente['id'].'">';
                //se muestra la imagen de la publicacion
                //echo '<img src="../../_assets/img/album-bb.jpg">';
                //se muestra el titulo de la publicacion
                echo '<h2>'.$publicacion_pendiente['Titulo'].'</h2>';
                //se muestra la fecha de la publicacion
                echo '<p class="ui-li-aside" >'.$publicacion_pendiente['FechaMod'].'</p>';
                //se muestra el nombre del autor de la publicacion
                echo '<p>Autor: <strong>'.$obj_usuario->getNombreUsuarioById($publicacion_pendiente['id_usuario']).'</strong></p>';
                //se muestra una fraccion del contenido de la publicación
                echo '<p style="white-space:normal;">'.substr(strip_tags($publicacion_pendiente['Cuerpo']),0,250).'</p></a>';

                echo '<a id="apr" href="#aprobar" data-rel="popup" data-id="'.$publicacion_pendiente['id'].'" data-position-to="window" data-transition="pop">Aprobar publicación</a>  </li>';
             }

         }
        ?>
    </ul>
    <!-- popup que aparece cuando se pincha en la opcion de aprobar articulo -->
    <div data-role="popup" id="aprobar" data-theme="d" data-overlay-theme="b" class="ui-content" style="max-width:340px; padding-bottom:2em;">
        <h3>¿Desea aprobar este artículo?</h3>
        <p>Esta publicación se hará visible inmediatamente luego de su aprobación.</p>
        <a href="#" id="okay" data-role="button" rel="external" data-theme="b" data-icon="check" data-inline="true" data-mini="true">Aprobar</a>
        <a href="#" data-role="button" data-rel="back" data-icon="minus" data-inline="true" data-mini="true">Cancelar</a>
    </div>
 </div>
 <!-- script para el comportamienro de aprobar las solicitudes -->
 <script type="text/javascript">
         // variables que usamos para contruir la url de actualizacion
            var currentId = 0;
            var baseURL = "/ifisc/model/articulo/aprobar.php?Idart=";

           //$('#page').on('pageinit', function(){
                $('#list li a').click(function(e){
                   // e.preventDefault();
                    
                    if ($(this).attr("data-id") !== undefined) {
                        //el atributo existe
                        currentId = $(this).attr("data-id");
                        $("#aprobar").popup("open", {transition:"slideup"} );
                    } else {
                        // no existe el atributo
                    }
                });
            //});
            $('#aprobar').on('popupbeforeposition', function(){
                $("#okay").attr("href", baseURL + currentId);
            });
 </script>
<!-- fin del contenido de la pagina -->
<?php 
    //variable que indica la localizacion absoluta del footer.
    $footer_location = $path_absoluto ."local/_footer.php";
    //se le da el texto a el fondo
    $footer_string = "iFISC 2013";
    $show_footer=true;
    //se incluye el archivo segun la variable de posicion absoluta
    include $footer_location;
 ?>
