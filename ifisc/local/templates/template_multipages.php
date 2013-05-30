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
//texto del titulo de la ventana
$titulo = "";

//si la pagina es privada requiere un menú 
//$show_menu = true;
//sino comprobamos si el usuario ha iniciado sesion
if (count($_SESSION) > 0) {
    //si la sesion ha iniciado
    $estado_sesion = $_SESSION['autentificado'];
    if ( $estado_sesion === "SI") {
        $show_menu = true;
    }else{
        $show_menu = false;
    }
}else{
    $show_menu = false;
}
//se renderiza el html de la cabecera
include $header_location; 
?>
<!-- contenido de la pagina -->

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

<!-- fin del contenido de la pagina2 -->
<?php 
//incluimos el archivo de footer para cerrar la estructura
//se localiza la ubicacion absoluta del archivo
$page_extra_f1 = $path_absoluto ."local/_page_F.php";
//se incluye el archivo del footer para terminar
include $page_extra_f1;
//incluir cuantas paginas sean necesarias
?>