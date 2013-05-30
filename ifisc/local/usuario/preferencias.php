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
$titulo = "Mis preferencias";
//si la pagina es privada requiere un menú 
//$show_menu = true;
//sino comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
        $show_menu = true;
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
//se importan los archivos de clases
$permisos_location = $path_absoluto ."model/usuario/load_permisos.php";
$clase_preferencia_location = $path_absoluto ."model/class_preferencias.php";
require $permisos_location;
include $clase_preferencia_location;
//se declara el objeto de tipo preferencia
$obj_preferencia = new preferencias;
//se renderiza el html de la cabecera
include $header_location; 
?>
<!-- contenido de la pagina -->
        <h3>
            Preferencias de publicaciones
        </h3>
        <h5>
            Forme su lista de categorías a las que se desea subscribir
        </h5>
         <h5>
                Categorías:
            </h5>
            <div class="ui-grid-a">                
                <div class="ui-block-a">
                    <div data-role="fieldcontain">
                        <select id="categorias" name="categorias" data-native-menu="true" name="" data-theme="b"
                        data-mini="true">
                         <?php 
                            //comprobamos si el usuario posee permisos para crear publicaciones estaticas
                             
                              if ($permiso_usuario['CrearPublicacionesEstaticas']) {
                                $preferencias = $obj_preferencia->getAllIdCategoriasPreferenciasNoSelectedByIdUsuario($_SESSION['id_usuario'] );
                                 while($row = mysql_fetch_array($preferencias)){
                                               echo '<option id='.$row['Nombre'].' value="';
                                               echo $row['id'];//el id del objeto
                                               echo '">';
                                               echo $row['Nombre'];//nombre del objeto
                                               echo '</option>';
                                            } 
                              }else{
                                $preferencias = $obj_preferencia->getIdCategoriasPreferenciasNoSelectedByIdUsuario($_SESSION['id_usuario']);
                                 while($row = mysql_fetch_array($preferencias)){
                                               echo '<option id='.$row['Nombre'].' value="';
                                               echo $row['id'];//el id del objeto
                                               echo '">';
                                               echo $row['Nombre'];//nombre del objeto
                                               echo '</option>';
                                            }  
                              }

                             ?>
                            
                        </select>
                    </div>
                </div>
                <div class="ui-block-b">
                    <input type="button" data-inline="true" data-icon="plus" data-mini="false" data-iconpos="left" value="Agregar" data-theme="a" id="agregarCategoria"/>
                   
                </div>
            </div>
        <form data-ajax="false" action="/ifisc/model/usuario/save_preferencias.php" method="POST">
            <ul data-role="listview" data-split-theme="d" data-divider-theme="b" data-inset="true" id="preferencias" data-split-icon="delete">
                <li data-role="list-divider" role="heading">
                    Categorías
                </li>
                <!-- items de preferencias -->
                   <?php 
                    //comprobamos si el usuario posee permisos para crear publicaciones estaticas
                             
                              if ($permiso_usuario['CrearPublicacionesEstaticas']) {
                                $preferencias = $obj_preferencia->getAllIdCategoriasPreferenciasSelectedByIdUsuario($_SESSION['id_usuario'] );
                                 while($row = mysql_fetch_array($preferencias)){
                                    echo '<li id="'.$row['id'].'" data-id="'.$row['Nombre'].'"><a>'.$row['Nombre'].'</a><a class="borrar"></a><input type="hidden" name="prefList[]" value="'.$row['id'].'"/></li>';
                                     } 
                              }else{
                                $preferencias = $obj_preferencia->getIdCategoriasPreferenciasSelectedByIdUsuario($_SESSION['id_usuario']);
                                 while($row = mysql_fetch_array($preferencias)){
                                    echo '<li id="'.$row['id'].'" data-id="'.$row['Nombre'].'"><a>'.$row['Nombre'].'</a><a class="borrar"></a><input type="hidden" name="prefList[]" value="'.$row['id'].'"/></li>';
                                   } 
                              }
                   ?>
            </ul>
           
            
            <input type="submit" data-inline="true" data-theme="b" data-icon="check"
            data-iconpos="left" value="Guardar" data-mini="true">
            <input type="submit" data-inline="true" data-icon="delete" data-iconpos="left"
            value="Cancelar" data-mini="true">
        </form>
    </div>
    <!-- script para la funcionalidad de agregar o quitar items de la lista -->
    <script type="text/javascript">
        $('.borrar').live('click', function(){
            //cuando se prsiona el boton de borrar
            if ($(this).parent().attr("id") !== undefined) {
                //si el atributo al cual se esta ingresando no es indefinido
                //se gusrdan los datos de nombre y el id
                currentId = $(this).parent().attr("id");
                currentCaption = $(this).parent().attr("data-id");
                //se quita el item seleccionado
                $(this).parent().remove();
                $('#preferencias').listview('refresh');
                //se agrega a la lista de posible categorias por seleccionar
                $('#categorias').append('<option id='+currentCaption+' value="'+currentId+'">'+currentCaption+'</option>');
                //se refesca la lista
                $('#categorias').selectmenu("refresh",true);
                $('#categorias').listview('refresh');

            }else {
                // no existe el atributo
            }
        });

        $('#agregarCategoria').click(function() {
            //cuando se pincha el boton de agragar categoria
            //se guardan los datos del item seleccionado
            var Newitem = $('#categorias').val();
            var caption = $('#categorias').find(":selected").text();
            //si el item seleccionado no tiene datos
            if(Newitem != null) {
                //si no es null
                //se agraga un nuevo item a mis preferencias
                $('#preferencias').append('<li id="'+ Newitem +'" data-id="'+ caption +'"><a>'+caption+'</a><a class="borrar"></a><input type="hidden" name="prefList[]" value="'+Newitem+'"/></li>').listview('refresh');
                //se borra el item de las posibles opciones a agragar
                $('#categorias option[value=' + Newitem +']').remove();
                //se referesca el item actualmente seleccionado
                $('#categorias').selectmenu("refresh",true);
                //se refesca la vista de posibles opciones a agragar
                $('#categorias').listview('refresh');              
            } else {
                //se muestra la advertencia
                alert('No hay categorías disponibles.');   
            }
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
