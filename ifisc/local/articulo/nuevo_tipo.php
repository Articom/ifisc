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
$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
$clase_categoria_location = $path_absoluto ."model/class_categoria.php";
$roles_location = $path_absoluto ."model/common/load_all_role.php";
require $permisos_location;
include $clase_categoria_location;
 //se invoca el archivo que busca todas los roles 
include_once $roles_location;
//se declara el objeto de tipo categoria
$obj_categoria = new categoria;
//texto del titulo de la ventana
$titulo = "Nueva publicación";
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
//se renderiza el html de la cabecera
include $header_location; 
?>
<!-- contenido de la pagina -->
         <ul data-role="listview" data-divider-theme="b" data-inset="true">
            <li data-role="list-divider" role="heading">
                Nueva Publicación
            </li>
            <li data-theme="c">
        <h3>
            Categoría:
        </h3>
        <form data-ajax="false" action="/ifisc/local/articulo/nuevo.php" method="POST">
            <div data-role="fieldcontain">
                <label for="selectmenu1">
                    Seleccione la categoría de su publicación:
                </label>
                <select id="selectmenu1" name="categoria" data-native-menu="true">
                <?php 
                //comprobamos si el usuario posee permisos para crear publicaciones estaticas
                 
                  if ($permiso_usuario['CrearPublicacionesEstaticas']) {
                    $categorias = $obj_categoria->getAllNombreCategoria();
                     while($row = mysql_fetch_array($categorias)){
                                   echo ' <option value="';
                                   echo $row['id'];//el id del objeto
                                   echo '">';
                                   echo $row['Nombre'];//nombre del objeto
                                   echo '</option>';
                                } 
                  }else{
                    $categorias = $obj_categoria->getAllNombreCategoriaPublicas();
                     while($row = mysql_fetch_array($categorias)){
                                   echo ' <option value="';
                                   echo $row['id'];//el id del objeto
                                   echo '">';
                                   echo $row['Nombre'];//nombre del objeto
                                   echo '</option>';
                                } 
                  }

                 ?>
               </select>
            </div>
            <input id="submit" type="submit" data-inline="true" data-theme="a" data-icon="check"
            data-iconpos="left" value="Aceptar" class="submit">
            <a href="/ifisc/index.php" data-ajax="false"  data-role="button" data-inline="true">Cancelar</a>
        </form>
     </li>
    </ul>
    </div>

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
