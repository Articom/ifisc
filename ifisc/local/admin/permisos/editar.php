<?php // template para la mayor parte de las paginas del sistema 
//iniciamos la sesion para utilizarla en todas las paginas
session_start();
//funcion para buscar la direccion absoluta del archivo
$path = $_SERVER['PHP_SELF']; 
$temp = explode("/", $path); 
$path_absoluto = "/"; 
for($i=3;$i<count($temp);$i++) 
$path_absoluto .= "../"; 

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
            header("Location: /ifisc/index.php"); 
            exit;
        }
}//de lo contrario se devuelve al inicio
else{
     //se devuelve al inicio
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/index.php"); 
            exit;       
}

//se cargan las funciones de los permisos de usuario
$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
require $permisos_location;
//variable que indica la localizacion absoluta de la cabecera.
$header_location = $path_absoluto ."local/_header.php";
//texto del titulo de la ventana
$titulo = "Editar permisos";
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

//se busca el permiso por el rol asociado
 $clase_permiso_location = $path_absoluto ."model/class_permisos.php";
 include $clase_permiso_location;
 //se hace una instancia del objeto de permisos
$obj_permisos = new permiso;
//se accede a la funcion del objeto permisos para buscar por el nombre del role
$permisos_role = $obj_permisos->getPermisosByRoleName($roleAEditar);

//se renderiza el html de la cabecera
include $header_location; 
?>
<!-- contenido de la pagina -->
        <ul data-role="listview" data-divider-theme="b" data-inset="true">
            <li data-role="list-divider" role="heading">            
            <?php 
            //se forma el titulo del formulario
            echo 'Permisos para '.$roleAEditar;
                echo '</li><form method="POST" data-ajax="false" action="/ifisc/model/admin/permisos/role_permiso.php?role='.$roleAEditar.'"/>';
                //row contiene el booleano resultante de la consulta de la busqueda de los permisos
                    $row1 = mysql_fetch_assoc($permisos_role);
                    //se itera sobre todas las columnas de la base de datos
                    for($i = 1; $i <= mysql_num_fields($permisos_role); $i++) {
                        //si se trata de la primera columna no hace nada... se trata del
                        //id y no nos interesa mostrarlo
                        if ($i===1) {//no hace nada
                        }else
                        //sino... crea un label con el nombre de la columna 
                        {
                            //se guarda el nombre de la columna en el campo de var_a
                            $var_a = mysql_fetch_field($permisos_role, $i-1)->name;
                            echo '<div data-role="fieldcontain"><label for="'.$var_a.'">';
                            echo $var_a;
                            echo '</label>';
                            echo ' <select name="'.$var_a.'" id="'.$var_a.'" data-theme="b" data-role="slider" data-mini="true">';
                            echo '<option ';
                            //se mustra una seleccion si en la base de datos posee el permiso
                            if ($row1[$var_a]) {

                            }else{
                                echo 'selected';
                            }
                            //si no, se muetra la opcion de apagado
                            echo ' value="off">No</option>';
                            echo '<option ';
                           if ($row1[$var_a]) {
                                echo 'selected';
                            }
                            //cierre del item
                            echo ' value="on">Sí</option></select>  </div>';
                        }                        
                    }
                ?>               
                <input type="submit" data-inline="true" data-theme="a" data-icon="check"
            data-iconpos="left" value="Guardar" data-mini="true"/>
            </form>
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