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
  
 <form id="nuevo_articulo" action="#" method="POST" data-ajax="false">
            <label for="titulo">
                    Nombre de la categoria
               </label>
               <input name="nombre_cat" id="nombre_cat" placeholder="Nombre de la categoria"
               value="" type="text">
</div>

            <div data-role="fieldcontain">
               <label for="contenido">
                    descripcio de la categoria
               </label>
               <textarea name="cad_descrip" id="cat_descrip" placeholder=""></textarea>
          </div>
          </form>
           <div id="menuarticulo" data-role="navbar" data-iconpos="top">
               <ul>
                    <li>
                         <a href="#page1" data-rol="submit" data-transition="flip" data-theme="" data-icon="check">
                              Guardar
                         </a>
                    </li>
                    <li>
                         <a href="#page2" data-transition="fade" data-theme="" data-icon="delete">
                              Cancelar
                         </a>
                    </li>
                    <li>
                         <a href="#page3" data-transition="fade" data-theme="" data-icon="info">
                              Ayuda
                         </a>
                    </li>
               </ul>
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
