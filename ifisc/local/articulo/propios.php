<?php // template para la mayor parte de las paginas del sistema 
//iniciamos la sesion para utilizarla en todas las paginas
//vista inicial... para mostrar las publicaciones aprobadas
session_start();
//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

//variable que indica la localizacion absoluta de la cabecera.
$header_location = $path_absoluto ."local/_header.php";
//se loccaliza y se incluye el archivo de los permisos de usuario
$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
$clase_categoria_location = $path_absoluto ."model/class_categoria.php";
$clase_publicaciones_location = $path_absoluto ."model/class_publicacion.php";

//incluimos el archivo que nos trae las publicaciones de los usuarios
require $permisos_location;
require $permisos_location;
include $clase_categoria_location;
include $clase_publicaciones_location;
//se declara el objeto de tipo categoria
$obj_categoria = new categoria;
//texto del titulo de la ventana
$titulo = "Mis publicaciones";
//si la pagina es privada requiere un menú 
$show_menu = true;
//sino comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
        //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
                //si esta loggeado se muestra el menu
                $show_menu = true;
                
                    //se comprueba si tiene el permiso para editar su perfil
                    if ($permiso_usuario['CrearPublicaciones']) {
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
        //como esta vista consta de muchas vistas por paginas
        //declaramos un id de la pagina para poder identificarla de las demas
        $page_id = "pagina1";
//se renderiza el html de la cabecera

include $header_location; 
?>
<!-- contenido de la pagina -->
    <h2>
      Artículos creados         
    </h2>
     <div data-role="navbar" data-iconpos="top">
            <ul>
                <li>
                    <a href="#pagina1" data-transition="slide" data-theme="a" data-icon="check"
                    class="ui-btn-active ui-state-persist">
                        Publicados
                    </a>
                </li>
                <li>
                    <a href="#pagina2" data-transition="slide" data-theme="a" data-icon="info">
                        Pendientes
                    </a>
                </li>
                <li>
                    <a href="#pagina3" data-transition="fade" data-theme="a" data-icon="delete">
                        Eliminados
                    </a>
                </li>
            </ul>
        </div>
        <div data-role="collapsible-set">
      <?php 
      //se inicializa el objeto que buscará las operaciones en las publicaciones
          $obj_publicacion = new publicacion;
          //se buscan las operaciones por el nombre del usuario y estado
          $publicaciones_aprobadas = $obj_publicacion->getPublicacionesAprobadasByUsuarioName($_SESSION['logged_user']);
          $publicaciones_pendientes = $obj_publicacion->getPublicacionesPendientesByUsuarioName($_SESSION['logged_user']);
          $publicaciones_eliminadas = $obj_publicacion->getPublicacionesEliminadasByUsuarioName($_SESSION['logged_user']);

          //inicializamos una variable para ver cuantos datos devuelve la consulta 
          $indice = 1;
          while ($fila = mysql_fetch_array($publicaciones_aprobadas)) {
      ?>
                  
                    <div data-role="collapsible">
                        <h3>
                          <?php
                          //el titulo de cada articulo del usuario
                              echo $fila['Titulo'];
                           ?>
                          </h3>
                          <!-- informacion de los articulos -->
                          <ul data-role="listview" data-theme="a"  data-divider-theme="a">
            <li>
                           <?php 
                                echo '<form action="/ifisc/local/articulo/editar.php?Idpub='.$fila['id'].'" method="POST" data-ajax="false">';
                                echo 'Categoría: <input type="text" name="categoria" readonly value="';                         
                                //el nombre de la categoria de cada articulo
                                echo $obj_categoria->getCategoriaNombreById($fila['id_categoria']).'">';
                                //la fecha de creacion de la publcacion
                                 echo 'Fecha: <input type="text" name="fechaCreacion" readonly value="';                         
                                //el nombre de la categoria de cada articulo
                                echo $fila['FechaMod'].'">';
                                //comprobamos que usuario que esta viendo los items tenga prrmisos para editar las publicaciones
                               if ($permiso_usuario['EditarPublicaciones']) {
                               //se muestra la opcion de editar la publicacion                                  
                                echo '<input type="submit" name="submit" data-inline="true" data-theme="b" data-icon="plus"data-iconpos="left" value="Editar" data-mini="true">';
                                
                                }
                                echo '<a href="/ifisc/local/vistas/vmart.php?art='.$fila['id'].'" data-ajax="false"  data-role="button" data-inline="true" data-mini="true">Ver</a>';   
                            ?>
                          </form></h3></li></ul>
            
                    </div>
                
      <?php
              //a la variable contadora se le suma uno... por cada item de BD
              $indice++;
          //cierre del mientras...
          }
          echo '</div>';
         //si al final de todo el index sigue siendo 1; no existen registros
         //se le muestra el erroro correspondiente
        if($indice === 1){
            echo ' <div class="bar">';
            echo '<h2>';
            echo 'Usted no posee ninguna publicación aprobada.';
            echo '</h2>';
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
    $footer_string = "";
    $show_footer=true;
    //se incluye el archivo segun la variable de posicion absoluta
    include $footer_location;
 ?>
<!-- ********************************************************************** -->
 <!-- inclusion de la segunda pagina -->
<?php
//vista para las publicaciones en estado pendiente de aprobación
//la segunda página despues de la primera en un mismo archivo
//localizamnos la ubicación de la cabecera de esta pagina
$page_extra_h1 = $path_absoluto ."local/_page_H.php";
//se le da un id a esta pagina para navegar a travez de ella
$page_id = "pagina2";
//se incluye el archivo de cabecera segun la variable de posicion absoluta
include $page_extra_h1;
?>
<!-- contenido de la pagina2 -->
<h2>
      Artículos creados         
    </h2>
     <div data-role="navbar" data-iconpos="top">
            <ul>
                <li>
                    <a href="#pagina1" data-transition="slide" data-theme="a" data-icon="check"
                    >
                        Publicados
                    </a>
                </li>
                <li>
                    <a href="#pagina2" data-transition="slide" data-theme="a" data-icon="info"
                    class="ui-btn-active ui-state-persist">
                        Pendientes
                    </a>
                </li>
                <li>
                    <a href="#pagina3" data-transition="fade" data-theme="a" data-icon="delete">
                        Eliminados
                    </a>
                </li>
            </ul>
        </div>
        <div data-role="collapsible-set" data-theme="d">
         <?php 
      
          //inicializamos una variable para ver cuantos datos devuelve la consulta 
          $indice = 1;

          while ($fila = mysql_fetch_array($publicaciones_pendientes)) {
      ?>
                 
                    <div data-role="collapsible">
                        <h3>
                          <?php
                          //el titulo de cada articulo del usuario
                              echo $fila['Titulo'];
                           ?>
                          </h3><ul data-role="listview" data-theme="a"  data-divider-theme="a">
            <li>
                          <!-- informacion de los articulos -->
                           <?php 
                                echo '<li><form action="/ifisc/local/articulo/editar.php?Idpub='.$fila['id'].'" method="POST" data-ajax="false">';
                                echo 'Categoría: <input type="text" name="categoria" readonly value="';                         
                                //el nombre de la categoria de cada articulo
                                echo $obj_categoria->getCategoriaNombreById($fila['id_categoria']).'">';
                                //la fecha de creacion de la publcacion
                                 echo 'Fecha: <input type="text" name="fechaCreacion" readonly value="';                         
                                //el nombre de la categoria de cada articulo
                                echo $fila['FechaMod'].'">';
                                //comprobamos que usuario que esta viendo los items tenga prrmisos para editar las publicaciones
                               if ($permiso_usuario['EditarPublicaciones']) {
                               //se muestra la opcion de editar la publicacion                                  
                                echo '<input type="submit" name="submit" data-inline="true" data-theme="b" data-icon="plus"data-iconpos="left" value="Editar" data-mini="true">';
                                
                                }
                                echo '<a href="/ifisc/local/vistas/vmart.php?art='.$fila['id'].'" data-ajax="false"  data-role="button" data-inline="true" data-mini="true">Ver</a>';   
                            ?>
                          </form></li></ul>
                    </div>
                
      <?php
              //a la variable contadora se le suma uno... por cada item de BD
              $indice++;
          //cierre del mientras...
          }
          echo '</div>';
         //si al final de todo el index sigue siendo 1; no existen registros
         //se le muestra el erroro correspondiente
        if($indice === 1){
            echo ' <div class="bar">';
            echo '<h2>';
            echo 'Usted no posee ninguna publicación pendiente.';
            echo '</h2>';
            echo '<a href="/ifisc/index.php" data-ajax="false" data-transition="fade" class="enlace">
                        Volver al Inicio
                    </a>';
            echo '</div>';
        }            
          ?>
       </div>       
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
 <!-- inclusion de la tercera pagina -->
<?php
//vista para las publicaciones en estado eliminadas
//la tercera página despues de la segunda en un mismo archivo
//localizamnos la ubicación de la cabecera de esta pagina
$page_extra_h2 = $path_absoluto ."local/_page_H.php";
//se le da un id a esta pagina para navegar a travez de ella
$page_id = "pagina3";
//se incluye el archivo de cabecera segun la variable de posicion absoluta
include $page_extra_h2;
?>
<!-- contenido de la pagina3 -->
<h2>
      Artículos creados         
    </h2>
     <div data-role="navbar" data-iconpos="top">
            <ul>
                <li>
                    <a href="#pagina1" data-transition="slide" data-theme="a" data-icon="check"
                    >
                        Publicados
                    </a>
                </li>
                <li>
                    <a href="#pagina2" data-transition="slide" data-theme="a" data-icon="info">
                        Pendientes
                    </a>
                </li>
                <li>
                    <a href="#pagina3" data-transition="fade" data-theme="a" data-icon="delete"
                    class="ui-btn-active ui-state-persist">
                        Eliminados
                    </a>
                </li>
            </ul>
        </div>
        <div data-role="collapsible-set">
         <?php
          //inicializamos una variable para ver cuantos datos devuelve la consulta 
          $indice = 1;

          while ($fila = mysql_fetch_array($publicaciones_eliminadas)) {
      ?>
                  
                    <div data-role="collapsible">
                        <h3>
                          <?php
                          //el titulo de cada articulo del usuario
                              echo $fila['Titulo'];
                           ?>
                          </h3><ul data-role="listview" data-theme="a"  data-divider-theme="a">
            <li>
                          <!-- informacion de los articulos -->
                           <?php 
                                echo '<form action="/ifisc/local/articulo/editar.php?Idpub='.$fila['id'].'" method="POST" data-ajax="false">';
                                echo 'Categoría: <input type="text" name="categoria" readonly value="';                         
                                //el nombre de la categoria de cada articulo
                                echo $obj_categoria->getCategoriaNombreById($fila['id_categoria']).'">';
                                //la fecha de creacion de la publcacion
                                 echo 'Fecha: <input type="text" name="fechaCreacion" readonly value="';                         
                                //el nombre de la categoria de cada articulo
                                echo $fila['FechaMod'].'">';
                                
                                echo '<a href="/ifisc/local/vistas/vmart.php?art='.$fila['id'].'" data-ajax="false"  data-role="button" data-inline="true" data-mini="true">Ver</a>';   
                            ?>
                          </form></li></ul>
                    </div>
      <?php
              //a la variable contadora se le suma uno... por cada item de BD
              $indice++;
          //cierre del mientras...
          }
          echo '</div>';
         //si al final de todo el index sigue siendo 1; no existen registros
         //se le muestra el erroro correspondiente
        if($indice === 1){
            echo ' <div class="bar">';
            echo '<h2>';
            echo 'Usted no posee ninguna publicación eliminada.';
            echo '</h2>';
            echo '<a href="/ifisc/index.php" data-ajax="false" data-transition="fade" class="enlace">
                        Volver al Inicio
                    </a>';
            echo '</div>';
        }            
          ?>
       </div>       
<!-- fin del contenido de la pagina2 -->
<?php 
//incluimos el archivo de footer para cerrar la estructura
//se localiza la ubicacion absoluta del archivo
$page_extra_f2 = $path_absoluto ."local/_page_F.php";
//se incluye el archivo del footer para terminar
include $page_extra_f2;
//incluir cuantas paginas sean necesarias
?>