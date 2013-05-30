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
$categoria_location = $path_absoluto ."model/common/load_categoria_codigo.php";
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
  <?php 

  // se ve que template se va a utilizar para guardar los datos de la publicación
if (isset($_POST['categoria']) || isset($_GET['categoria'])) {
  //se mira el tipo de categoria
  if (isset($_POST['categoria'])) {
    $categoria_selected = $_POST['categoria'];
  }else{
    $categoria_selected = $_GET['categoria'];
  }
  $data_articulo = 'new';
  $data_location =$path_absoluto ."model/articulo/data.php";
  include $data_location; 
  echo '<h2>Asistente para la creación de una nueva publicación</h2>';
  //se llama al archivo que busca el codigo de la categoria
  require $categoria_location;
  //se compueba cual es el codigo de esa categoria
  if (($codigo == 1)||($codigo == 2)) {
    //si es de tipo evento se muestra la plantilla relacionada
    $plantilla_evento =$path_absoluto ."local/articulo/plantilla/Evento_Actividad.php";
    include $plantilla_evento; 

  }elseif ($codigo == 4) {
    //plantilla relacionada a becas
   $oferta_beca =$path_absoluto ."local/articulo/plantilla/Oferta_Beca.php";
    include $oferta_beca; 
  }elseif ($codigo == 5) {
    //plantilla para llenar los datos de una publicacion de empleo
    $oferta_empleo =$path_absoluto ."local/articulo/plantilla/Oferta_Empleo.php";
    include $oferta_empleo; 
  }elseif ($codigo == 6) {
   //plantilla para llenar los datos de una publicacion de oferta de practica profesinal
    $oferta_practica =$path_absoluto ."local/articulo/plantilla/Oferta_Practica.php";
    include $oferta_practica; 
  }elseif ($codigo == 9) {
    //plantilla para llenar los datos de una publicacion de una carrera
    $info_carrera =$path_absoluto ."local/articulo/plantilla/Info_Carrera.php";
    include $info_carrera; 
  }elseif ($codigo ==11) {
    //plantilla para rellenar los datos de un contacto de atencion al cliente
    $info_contacto =$path_absoluto ."local/articulo/plantilla/Info_Contacto.php";
    include $info_contacto; 
  }else{
    //se muestra el template de publicacion estatica
    $plantilla_estatica =$path_absoluto ."local/articulo/plantilla/Estatica.php";
    include $plantilla_estatica; 

  }
  
}else{
  //se reenvia al nuevo tipó
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/local/articulo/nuevo_tipo.php"); 
            exit;
}


 ?>

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
