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
$clase_publicaciones_location = $path_absoluto ."model/class_publicacion.php";
$roles_location = $path_absoluto ."model/common/load_all_role.php";
$categoria_location = $path_absoluto ."model/common/load_categoria_codigo.php";
require $permisos_location;
include $clase_categoria_location;
include $clase_publicaciones_location;
include_once $roles_location;
//se declara el objeto de tipo categoria
$obj_categoria = new categoria;
//texto del titulo de la ventana
$titulo = "Editar publicación";
//si la pagina es privada requiere un menú 
//$show_menu = true;
//sino comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
        //si la sesion ha iniciado
            $estado_sesion = $_SESSION['autentificado'];
            if ( $estado_sesion === "SI") {
                //si esta loggeado se muestra el menu
                $show_menu = true;
                
                    //se comprueba si tiene el permiso para editar publicaciones
                    if ($permiso_usuario['EditarPublicaciones']) {
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

  //comprobamos si se ha enviado algun parametro por el método get
        if (count($_GET) > 0) {
          //comprobamos si el metodo get posee algun parametro de tipo Idpub
          if (isset($_GET['Idpub'])){
            //setteamos el parametron del id de la publicacion
            $id_publicacion = $_GET['Idpub'];
          }else{
          // se redirecciona a la pagina de inicio
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/index.php"); 
            exit;
          }
        }else{
          // se redirecciona a la pagina de inicio
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/index.php"); 
            exit;
        }
        //Comprobamos que lo que se desea es ver y no editar
        if (isset($_POST['submit'])) {         
          if ($_POST['submit'] === 'Ver') {
           //entonces se desea ver la publicacion
            //se redirige al usuario
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /ifisc/local/articulo/publicacion?Idpub=".$id_publicacion); 
            exit;
          }
        }

//se renderiza el html de la cabecera
include $header_location; 
  //se busca la publicacion seleccionada segun el id
  $publicacion_selected = $obj_publicacion->getPublicacionById($id_publicacion);
  $data_articulo = 'update';
  $data_location =$path_absoluto ."model/articulo/data.php";
    include $data_location; 
?>
<!-- contenido de la pagina -->
  <h2>Asistente para la edición de una publicación</h2>

   <?php

  $categoria_selected = $publicacion_selected['id_categoria'];
  //se llama al archivo que busca el codigo de la categoria
  require $categoria_location;
  if (!empty($publicacion_selected['id'])) {
   
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
    //mensaje de error 
    echo 'Publicacion no encontrada /*modifica este ensaje para que se vea chulo :3';
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
